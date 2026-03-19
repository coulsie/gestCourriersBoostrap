<?php

namespace App\Http\Controllers;

use App\Models\Interim;
use App\Models\Agent;
use Illuminate\Http\Request;

class InterimController extends Controller
{

public function index()
{
    // Récupère tous les intérims avec les agents liés
    $interims = Interim::with(['agent', 'interimaire'])
        ->orderBy('date_debut', 'desc')
        ->paginate(15); // Utilise la pagination pour plus de performance

    return view('interims.index', compact('interims'));
}

public function create()
{
    // On récupère tous les agents pour remplir les deux listes (Titulaire et Remplaçant)
    $agents = \App\Models\Agent::orderBy('last_name')->get();
    return view('interims.create', compact('agents'));
}

/**
 * Affiche le formulaire de modification d'un intérim.
 */
public function edit($id)
{
    // 1. On récupère l'intérim concerné ou erreur 404 si introuvable
    $interim = \App\Models\Interim::findOrFail($id);

    // 2. On récupère la liste des agents pour remplir les menus déroulants
    $agents = \App\Models\Agent::orderBy('last_name')->get();

    // 3. On retourne la vue avec les données
    return view('interims.edit', compact('interim', 'agents'));
}




    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'agent_id'       => 'required|exists:agents,id',
            'interimaire_id' => 'required|exists:agents,id|different:agent_id',
            'date_debut'     => 'required|date|after_or_equal:today',
            'date_fin'       => 'required|date|after_or_equal:date_debut',
            'motif'          => 'nullable|string|max:1000',
            'force_confirm'  => 'nullable|boolean', // Champ pour la validation forcée
        ], [
            'interimaire_id.different' => 'L\'intérimaire doit être une personne différente du titulaire.',
            'date_fin.after'           => 'La date de fin doit être postérieure à la date de début.',
        ]);

        try {
            $interimaire = \App\Models\Agent::findOrFail($validated['interimaire_id']);

            if (!$interimaire->user_id) {
                return back()->with('error', "L'agent " . $interimaire->last_name . " ne possède pas de compte utilisateur.");
            }

            // A. VÉRIFICATION PERMISSIONNAIRE (Bloquante)
            $isPermissionnaire = \App\Models\Absence::where('agent_id', $validated['interimaire_id'])
                ->where(function ($query) use ($validated) {
                    $query->where('date_debut', '<=', $validated['date_fin'])
                        ->where('date_fin', '>=', $validated['date_debut']);
                })->exists();

            if ($isPermissionnaire) {
                return back()->with('error', "Impossible : l'agent remplaçant est déjà permissionnaire sur cette période.");
            }

            // B. VÉRIFICATION CONFLIT INTERIM (Avertissement avec option de forcer)
            $conflitInterim = \App\Models\Interim::where('interimaire_id', $validated['interimaire_id'])
                ->where('is_active', true)
                ->where(function ($query) use ($validated) {
                    $query->where('date_debut', '<=', $validated['date_fin'])
                        ->where('date_fin', '>=', $validated['date_debut']);
                })->exists();

            // Si conflit et que l'utilisateur n'a pas encore cliqué sur "Valider quand même"
            if ($conflitInterim && !$request->has('force_confirm')) {
                return back()
                    ->withInput() // Garde les données saisies
                    ->with('warning_conflit', "Cet agent est déjà programmé pour un autre intérim sur cette période. Voulez-vous qu'il assure ce nouvel intérim ?");
            }

            // 3. TRANSACTION : Création
            \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $interimaire) {
                \App\Models\Interim::create([
                    'agent_id'       => $validated['agent_id'],
                    'interimaire_id' => $validated['interimaire_id'],
                    'user_id'        => $interimaire->user_id,
                    'date_debut'     => $validated['date_debut'],
                    'date_fin'       => $validated['date_fin'],
                    'motif'          => $validated['motif'],
                    'is_active'      => true,
                ]);

                \App\Models\Absence::create([
                    'agent_id'        => $validated['agent_id'],
                    'date_debut'      => $validated['date_debut'],
                    'date_fin'        => $validated['date_fin'],
                    'approuvee'       => 1,
                    'type_absence_id' => 1,
                    'document_justificatif' => $validated['motif'] ?? 'Intérim programmé #' . time(),
                ]);
            });

            return redirect()->route('interims.index')
                ->with('success', "L'intérim a été enregistré avec succès.");
        } catch (\Exception $e) {
            return back()->with('error', "Erreur système : " . $e->getMessage());
        }
    }



    public function update(Request $request, $id)
{
    $interim = \App\Models\Interim::findOrFail($id);

    // 1. Validation (on autorise after_or_equal:today seulement si les dates changent)
    $validated = $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'interimaire_id' => 'required|exists:agents,id|different:agent_id',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after:date_debut',
    ]);

    try {
        $interimaire = \App\Models\Agent::findOrFail($validated['interimaire_id']);

        if (!$interimaire->user_id) {
            return back()->with('error', "L'agent n'a pas de compte utilisateur.");
        }

        // Vérification des conflits (en excluant l'intérim actuel)
        $conflit = \App\Models\Interim::where('interimaire_id', $validated['interimaire_id'])
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                      ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']]);
            })->exists();

        if ($conflit) {
            return back()->with('error', "Conflit de période pour cet intérimaire.");
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $interimaire, $interim) {

            // A. Rechercher l'absence liée avant de modifier l'intérim
            // On se base sur l'agent_id et les ANCIENNES dates pour la trouver
            $absence = \App\Models\Absence::where('agent_id', $interim->agent_id)
                ->where('date_debut', $interim->date_debut)
                ->where('date_fin', $interim->date_fin)
                ->first();

            // B. Mise à jour de l'intérim
            $interim->update([
                'agent_id'       => $validated['agent_id'],
                'interimaire_id' => $validated['interimaire_id'],
                'user_id'        => $interimaire->user_id,
                'date_debut'     => $validated['date_debut'],
                'date_fin'       => $validated['date_fin'],
            ]);

            // C. Mise à jour de l'absence si elle existe
            if ($absence) {
                $absence->update([
                    'agent_id'   => $validated['agent_id'],
                    'date_debut' => $validated['date_debut'],
                    'date_fin'   => $validated['date_fin'],
                ]);
            }
        });

        return redirect()->route('interims.index')
            ->with('success', "Intérim et absence mis à jour avec succès.");

    } catch (\Exception $e) {
        return back()->with('error', "Erreur lors de la mise à jour : " . $e->getMessage());
    }
}

public function show($id)
{
    // Charge l'intérim avec les informations des deux agents concernés
    $interim = Interim::with(['agent', 'interimaire'])->findOrFail($id);

    return view('interims.show', compact('interim'));
}
public function destroy($id)
{
    $interim = Interim::findOrFail($id);

    try {
        \Illuminate\Support\Facades\DB::transaction(function () use ($interim) {

            // 1. Rechercher l'absence liée (même agent, mêmes dates)
            $absence = \App\Models\Absence::where('agent_id', $interim->agent_id)
                ->where('date_debut', $interim->date_debut)
                ->where('date_fin', $interim->date_fin)
                ->first();

            // 2. Supprimer l'absence si elle existe
            if ($absence) {
                $absence->delete();
            }

            // 3. Supprimer l'intérim
            $interim->delete();
        });

        return redirect()->route('interims.index')
            ->with('success', "L'intérim et l'absence liée ont été supprimés avec succès.");

    } catch (\Exception $e) {
        return back()->with('error', "Erreur lors de la suppression : " . $e->getMessage());
    }
}




public function stop(\App\Models\Interim $interim)
{
    // On passe le statut à faux
    $interim->update(['is_active' => false]);

    return back()->with('success', "L'intérim a été arrêté prématurément.");
}

}
