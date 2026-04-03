<?php

namespace App\Http\Controllers;

use App\Models\Seminaire;
use Illuminate\Http\Request;
use Exception;
use App\Models\Agent; // N'oubliez pas d'importer le modèle en haut
use App\Models\SeminaireDocument;
use Illuminate\Support\Facades\Storage; // Utile pour supprimer des fichiers plus tard


class SeminaireController extends Controller
{
    /**
     * Liste des séminaires avec pagination
     */

    public function index()
{
    $now = now();

    // 1. Mise à jour physique des statuts en base de données avant l'affichage

    // Cas : "En cours" (entre début et fin, si pas déjà terminé/annulé)
    Seminaire::whereNotIn('statut', ['termine', 'annule'])
        ->where('date_debut', '<=', $now)
        ->where('date_fin', '>=', $now)
        ->update(['statut' => 'en_cours']);

    // Cas : "Planifié" (si la date de début n'est pas encore arrivée)
    Seminaire::whereNotIn('statut', ['termine', 'annule'])
        ->where('date_debut', '>', $now)
        ->update(['statut' => 'planifie']);

    // Cas : "En attente du rapport final" (si la date de fin est dépassée et pas de rapport)
    Seminaire::whereNotIn('statut', ['termine', 'annule'])
        ->where('date_fin', '<', $now)
        ->update(['statut' => 'en attente du rapport final']);

    // 2. Récupération des données pour la vue avec pagination
    $seminaires = Seminaire::select(
            'id',
            'titre',
            'organisateur',
            'lieu',
            'date_debut',
            'date_fin', // Ajouté pour les calculs éventuels dans la vue
            'statut',
            'nb_participants_prevu'
        )
        ->orderBy('date_debut', 'desc')
        ->paginate(15);

    return view('seminaires.index', compact('seminaires'));
}



    public function create()
    {
        // 1. On récupère les agents
        $agents = Agent::orderBy('last_name', 'asc')->get();

        // 2. On les envoie à la vue des séminaires
        return view('seminaires.create', compact('agents'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'                 => 'required|string|max:255',
            'organisateur'          => 'required|string|max:255',
            'lieu'                  => 'required|string|max:255',
            'date_debut'            => 'required|date',
            'date_fin'              => 'required|date|after_or_equal:date_debut',
            'nb_participants_prevu' => 'required|integer|min:0',
            'statut'                => 'required|string|max:255',
            'description'           => 'nullable|string',
        ]);

        try {
            Seminaire::create($validated);

            return redirect()->route('seminaires.index')
                ->with('success', 'Le séminaire a été programmé avec succès.');

        } catch (\Exception $e) {
            // Correction ici : l\'enregistrement avec un antislash
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }


        // App\Http\Controllers\SeminaireController.php

        public function show(Seminaire $seminaire)
    {
        $seminaire->load('participations.agent');

        // On récupère tous les agents triés par nom
        $agents = \App\Models\Agent::with('service:id,name')
            ->select('id', 'first_name', 'last_name', 'service_id', 'matricule')
            ->orderBy('last_name')
            ->get();

        return view('seminaires.show', compact('seminaire', 'agents'));
    }



        /**
         * Formulaire d'édition
         */
        public function edit(Seminaire $seminaire)
        {
            return view('seminaires.edit', compact('seminaire'));
        }

        /**
         * Mise à jour du séminaire
         */
        public function update(Request $request, Seminaire $seminaire)
{
    $validated = $request->validate([
        'titre'                 => 'required|string|max:255',
        'nb_participants_prevu' => 'required|integer|min:0',
        'organisateur'          => 'required|string|max:255',
        'lieu'                  => 'required|string|max:255',
        'date_debut'            => 'required|date',
        'date_fin'              => 'required|date|after_or_equal:date_debut',
        // Suppression de la règle "in:..." car le statut peut désormais être "en attente du rapport final"
        'statut'                => 'required|string|max:255',
        'description'           => 'nullable|string',
    ]);

    try {
        $seminaire->update($validated);

        return redirect()->route('seminaires.index')
            ->with('success', 'Le séminaire "' . $seminaire->titre . '" a été mis à jour avec succès.');

    } catch (\Exception $e) {
        // Log de l'erreur pour le développeur si besoin : \Log::error($e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'Erreur lors de la modification : ' . $e->getMessage());
    }
}

        /**
         * Suppression
         */
        public function destroy(Seminaire $seminaire)
        {
            try {
                $seminaire->delete();
                return redirect()->route('seminaires.index')
                    ->with('success', 'Le séminaire a été annulé et supprimé.');
            } catch (Exception $e) {
                return back()->with('error', 'Impossible de supprimer ce séminaire.');
            }
        }


    public function uploadDocument(Request $request, $seminaireId)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:pdf,docx,jpg,png|max:10240',
            'type'    => 'required|in:presence,rapport,support'
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $path = $file->store('documents_seminaires', 'public');

            // 1. Enregistrement du document
            SeminaireDocument::create([
                'seminaire_id' => $seminaireId,
                'nom_document' => $file->getClientOriginalName(),
                'fichier_path' => $path,
                'type'         => $request->type,
            ]);

            // 2. Si le document est de type 'rapport', on met à jour le statut du séminaire
            if ($request->type === 'rapport') {
                $seminaire = Seminaire::findOrFail($seminaireId);
                $seminaire->update(['statut' => 'termine']);
            }

            return back()->with('success', 'Rapport archivé et séminaire marqué comme terminé !');
        }

        return back()->with('error', 'Aucun fichier sélectionné.');
    }

    public function dashboard()
    {
        // On récupère les séminaires avec le compte des participants et des documents
        $stats = Seminaire::withCount([
            'participants as inscrits_total',
            'participants as presents_count' => function ($query) {
                $query->where('est_present', 1);
            },
            'documents as rapports_count' => function ($query) {
                $query->where('type', 'rapport');
            }
        ])->orderBy('date_debut', 'desc')->get();

        // Calculs globaux pour le haut de page
        $totalSeminaires = $stats->count();
        $enAttenteRapport = $stats->where('statut', 'en attente du rapport final')->count();

        return view('seminaires.report', compact('stats', 'totalSeminaires', 'enAttenteRapport'));
    }

    }
