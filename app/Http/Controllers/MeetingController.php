<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\Meeting;


class MeetingController extends Controller
{
    public function hebdo()
{
    // Définition de la plage de la semaine actuelle
    $debutSemaine = now()->startOfWeek()->startOfDay();
    $finSemaine = now()->endOfWeek()->endOfDay();

    // 1. Réunions de la semaine en cours
    // On charge 'participants.agent' pour les internes et 'listeExternes' pour les invités
    $reunions = Meeting::with(['animateur', 'redacteur', 'participants.agent', 'listeExternes'])
        ->whereBetween('date_heure', [$debutSemaine, $finSemaine])
        ->orderBy('date_heure', 'asc')
        ->get();

    // 2. Réunions hors-semaine (Historique complet)
    $autresReunions = Meeting::with(['animateur', 'redacteur', 'participants.agent', 'listeExternes'])
        ->whereNotBetween('date_heure', [$debutSemaine, $finSemaine])
        ->orderBy('date_heure', 'desc')
        ->get();

    // Calcul des réunions en retard (À CLÔTURER)
    $nbRetards = $reunions->where('status', 'programmee')
                         ->filter(fn($r) => \Carbon\Carbon::parse($r->date_heure)->isPast())
                         ->count();

    // Envoi à la vue
    return view('Reunions.hebdo', compact('reunions', 'autresReunions', 'nbRetards'));
}



    public function create()
{
    // On trie par le nom de famille (last_name)
    $agents = \App\Models\Agent::orderBy('last_name', 'asc')->get();
    return view('Reunions.create', compact('agents'));
}


public function store(Request $request)
{
    // 1. Validation étendue
    $validated = $request->validate([
        'objet' => 'required|string|max:255',
        'date_heure' => 'required|date',
        'animateur_id' => 'required|exists:agents,id',
        'redacteur_id' => 'required|exists:agents,id',
        'lieu' => 'nullable|string|max:255',
        'ordre_du_jour' => 'nullable|string',

        // Participants Internes (Table agents)
        'participants' => 'nullable|array',
        'participants.*' => 'exists:agents,id',

        // Participants Externes (Table meeting_externes)
        'externes' => 'nullable|array',
        'externes.*.nom_complet' => 'required_with:externes|string|max:255',
        'externes.*.origine' => 'required_with:externes|string|max:255',
        'externes.*.fonction' => 'nullable|string|max:255',
        'externes.*.email' => 'nullable|email|max:255',
        'externes.*.telephone' => 'nullable|string|max:255',
    ]);

    // 2. Préparation des données pour la table 'meetings'
    // On ne garde que les colonnes qui existent réellement dans la table meetings
    $meetingData = $request->only([
        'objet', 'date_heure', 'animateur_id', 'redacteur_id', 'lieu', 'ordre_du_jour'
    ]);

    // 3. Création de la réunion
    $reunion = \App\Models\Meeting::create($meetingData);

    // 4. Enregistrement des participants internes (DSESF)
    // On utilise attach() pour la table pivot meeting_participants
    if ($request->has('participants')) {
        $reunion->participants()->attach($request->participants);
    }

    // 5. Enregistrement des participants externes (Table meeting_externes)
    if ($request->has('externes')) {
        foreach ($request->externes as $externe) {
            // On vérifie que le nom n'est pas vide (sécurité JS)
            if (!empty($externe['nom_complet'])) {
                $reunion->externes()->create([
                    'nom_complet' => $externe['nom_complet'],
                    'origine'     => $externe['origine'] ?? 'INCONNUE',
                    'fonction'    => $externe['fonction'] ?? null,
                    'email'       => $externe['email'] ?? null,
                    'telephone'   => $externe['telephone'] ?? null,
                ]);
            }
        }
    }

    return redirect()->route('reunions.hebdo')->with('success', 'Réunion et participants enregistrés avec succès !');
}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function show(Meeting $reunion)
    {
        return view('Reunions.show', compact('reunion'));
    }



    public function edit($id)
    {
        $reunion = Meeting::with(['participants', 'listeExternes'])->findOrFail($id);
        $agents = Agent::all();
        return view('Reunions.edit', compact('reunion', 'agents'));
    }

    /**
     * Mise à jour
     */
public function update(Request $request, Meeting $reunion)
{
    // 1. Validation rigoureuse
    $validated = $request->validate([
        'objet' => 'required|string|max:255',
        'date_heure' => 'required',
        'animateur_id' => 'required|exists:agents,id',
        'redacteur_id' => 'required|exists:agents,id',
        'lieu' => 'nullable|string|max:255',
        'ordre_du_jour' => 'nullable|string',
        'status' => 'required|in:programmee,terminee,annulee',
        'presence_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'report_file' => 'nullable|file|mimes:pdf,doc,docx,odt|max:5120',

        // Internes
        'participants' => 'nullable|array',
        'participants.*' => 'exists:agents,id',

        // Externes
        'externes' => 'nullable|array',
        'externes.*.id' => 'nullable|exists:meeting_externes,id',
        'externes.*.nom_complet' => 'required_with:externes|string|max:255',
        'externes.*.origine' => 'required_with:externes|string|max:255',
        'externes.*.fonction' => 'nullable|string|max:255',
        'externes.*.email' => 'nullable|email|max:255',
        'externes.*.telephone' => 'nullable|string|max:255',
    ]);

    // 2. Données de base
    $data = $request->only(['objet', 'date_heure', 'animateur_id', 'redacteur_id', 'ordre_du_jour', 'lieu', 'status']);

    // 3. Gestion des fichiers (Archives)
    if ($request->hasFile('presence_file')) {
        $fileP = $request->file('presence_file');
        $fileNameP = time() . '_presence_' . $fileP->getClientOriginalName();
        $fileP->move(public_path('Rapport_Reunions'), $fileNameP);
        $data['presence_file'] = $fileNameP;
    }

    if ($request->hasFile('report_file')) {
        $fileR = $request->file('report_file');
        $fileNameR = time() . '_rapport_' . $fileR->getClientOriginalName();
        $fileR->move(public_path('Rapport_Reunions'), $fileNameR);
        $data['report_file'] = $fileNameR;
    }

    // 4. Mise à jour de la réunion principale
    $reunion->update($data);

    // 5. SYNCHRONISATION DES INTERNES (Agents DSESF)
    // On ne traite la suppression que si le champ participants existe dans la requête
    if ($request->has('participants')) {
        $newInternalIds = $request->input('participants', []);

        // Supprimer ceux qui ont été décochés
        $reunion->participants()->whereNotIn('agent_id', $newInternalIds)->delete();

        // Maintenir ou ajouter les autres
        foreach ($newInternalIds as $agentId) {
            $reunion->participants()->updateOrCreate(
                ['agent_id' => $agentId],
                ['meeting_id' => $reunion->id]
            );
        }
    } else {
        // Si le champ n'existe pas du tout (aucune case cochée), on vide tout par sécurité
        $reunion->participants()->delete();
    }

    // 6. SYNCHRONISATION DES EXTERNES
    $externesInput = $request->input('externes', []);
    $keptExternalIds = [];

    // On boucle pour créer ou mettre à jour
    foreach ($externesInput as $exData) {
        if (!empty($exData['nom_complet'])) {
            $externe = $reunion->listeExternes()->updateOrCreate(
                ['id' => $exData['id'] ?? null], // Utilise l'ID pour l'update
                [
                    'nom_complet' => $exData['nom_complet'],
                    'origine'     => $exData['origine'],
                    'fonction'    => $exData['fonction'] ?? null,
                    'email'       => $exData['email'] ?? null,
                    'telephone'   => $exData['telephone'] ?? null,
                ]
            );
            $keptExternalIds[] = $externe->id;
        }
    }

    // Suppression des lignes qui ne sont plus dans le formulaire
    // Uniquement si le tableau externe est envoyé (évite les bugs de vidage)
    if ($request->has('externes')) {
        $reunion->listeExternes()->whereNotIn('id', $keptExternalIds)->delete();
    }

    return redirect()->route('reunions.hebdo')->with('success', 'Réunion mise à jour avec succès !');
}



    /**
     * Supprimer la réunion
     */
    public function destroy(Meeting $reunion)
    {
        // 1. Détacher d'abord les participants dans la table pivot (sécurité)
        $reunion->participants()->detach();

        // 2. Supprimer la réunion de la base de données
        $reunion->delete();

        // 3. Rediriger avec un message de succès éclatant
        return redirect()->route('reunions.hebdo')
            ->with('success', 'La réunion a été supprimée avec succès.');
    }

        public function etat(Request $request)
    {
        // Valeurs par défaut : mois en cours
        $debut = $request->filled('date_debut') ? \Carbon\Carbon::parse($request->date_debut)->startOfDay() : now()->startOfMonth();
        $fin = $request->filled('date_fin') ? \Carbon\Carbon::parse($request->date_fin)->endOfDay() : now()->endOfMonth();
        $statut = $request->get('status');

        $query = Meeting::with(['animateur', 'redacteur', 'participants'])
            ->whereBetween('date_heure', [$debut, $fin]);

        // Filtre optionnel par statut
        if ($request->filled('status')) {
            $query->where('status', $statut);
        }

        $reunions = $query->orderBy('date_heure', 'asc')->get();

        return view('Reunions.etat', compact('reunions', 'debut', 'fin', 'statut'));
    }

    public function listePresence($id)
    {
        // On charge la réunion avec ses deux types de participants
        $reunion = Meeting::with(['participants.agent', 'listeExternes'])->findOrFail($id);

        // 1. Préparation des Internes (DSESF)
        $internes = $reunion->participants->map(function($p) {
            return (object)[
                'nom' => $p->agent->last_name . ' ' . $p->agent->first_name,
                'origine' => 'DSESF',
                'fonction' => $p->agent->status,
                'contact' => ($p->telephone ?? $p->agent->phone_number) . ' / ' . ($p->email ?? $p->agent->email)
            ];
        });

        // 2. Préparation des Externes
        $externes = $reunion->listeExternes->map(function($e) {
            return (object)[
                'nom' => $e->nom_complet,
                'origine' => $e->origine,
                'fonction' => $e->fonction ?? '---',
                'contact' => ($e->telephone ?? '---') . ' / ' . ($e->email ?? '---')
            ];
        });

        // Fusion des listes
        $listeParticipants = $internes->concat($externes);

        return view('Reunions.print_presence', compact('reunion', 'listeParticipants'));
    }


}
