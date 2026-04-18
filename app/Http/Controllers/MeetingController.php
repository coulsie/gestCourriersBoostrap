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

        // Modifiez la ligne 20 comme ceci :
        $reunions = Meeting::with(['animateur', 'redacteur', 'participants', 'listeExternes'])
            ->whereBetween('date_heure', [$debutSemaine, $finSemaine])
            ->orderBy('date_heure', 'asc')
            ->get();


        // 2. Réunions hors-semaine (Historique complet)
        $autresReunions = Meeting::with(['animateur', 'redacteur', 'participants', 'listeExternes'])
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
                    $reunion->listeExternes()->create([
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
    public function update(Request $request, $id)
    {
        // 1. Récupération de la réunion ou erreur 404
        $reunion = Meeting::findOrFail($id);

        \DB::transaction(function () use ($request, $reunion, $id) {

            // --- GESTION DES FICHIERS (Avant l'update groupé) ---

            // On récupère les données de base
            $data = $request->only([
                'objet',
                'date_heure',
                'lieu',
                'animateur_id',
                'redacteur_id',
                'status',
                'ordre_du_jour'
            ]);

            // Vérification et stockage de la liste de présence
            if ($request->hasFile('presence_file')) {
                // On récupère le fichier
                $file = $request->file('presence_file');
                // On lui donne un nom unique propre
                $fileName = 'presence_' . time() . '_' . $file->getClientOriginalName();
                // On le déplace directement dans public/Rapport_Reunions
                $file->move(public_path('Rapport_Reunions'), $fileName);
                // On enregistre le chemin simple en base de données
                $data['presence_file'] = 'Rapport_Reunions/' . $fileName;
            }

            // Vérification et stockage du rapport
            if ($request->hasFile('report_file')) {
                $file = $request->file('report_file');
                $fileName = 'rapport_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('Rapport_Reunions'), $fileName);
                $data['report_file'] = 'Rapport_Reunions/' . $fileName;
            }

            // 2. Mise à jour des informations de base et des fichiers
            $reunion->update($data);

            // 3. GESTION DES PARTICIPANTS INTERNES (Agents)
            \DB::table('meeting_participants')->where('meeting_id', $id)->delete();

            if ($request->has('participants') && is_array($request->participants)) {
                $dataInternes = [];
                $now = now();

                foreach ($request->participants as $agent_id) {
                    if (!empty($agent_id)) {
                        $dataInternes[] = [
                            'meeting_id' => $id,
                            'agent_id'   => $agent_id,
                            'created_at' => $now,
                            'updated_at' => $now
                        ];
                    }
                }

                if (!empty($dataInternes)) {
                    \DB::table('meeting_participants')->insert($dataInternes);
                }
            }

            // 4. GESTION DES PARTICIPANTS EXTERNES (Invités)
            $reunion->listeExternes()->delete();

            if ($request->has('externes') && is_array($request->externes)) {
                foreach ($request->externes as $dataExterne) {
                    if (!empty($dataExterne['nom_complet'])) {
                        $reunion->listeExternes()->create([
                            'nom_complet' => $dataExterne['nom_complet'],
                            'origine'     => $dataExterne['origine'] ?? 'N/A',
                            'fonction'    => $dataExterne['fonction'] ?? null,
                            'email'       => $dataExterne['email'] ?? null,
                            'telephone'   => $dataExterne['telephone'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('reunions.hebdo')->with('success', 'La réunion et ses documents ont été mis à jour avec succès.');
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
        // 1. On charge la réunion
        $reunion = Meeting::with(['participants', 'listeExternes'])->findOrFail($id);

        // 2. Préparation des Internes
        $internes = $reunion->participants->map(function ($agent) {
            return (object)[
                'nom' => strtoupper($agent->last_name) . ' ' . $agent->first_name,
                'origine' => 'DSESF',
                // Remplacement de $p par $agent ici
                'fonction' => ($agent->status ?? 'Agent') . " | " . $agent->email_professionnel . " | " . $agent->phone_number,
                'contact' => $agent->phone_number,
            ];
        });

        // 3. Préparation des Externes
        $externes = $reunion->listeExternes->map(function ($e) {
            return (object)[
                'nom' => strtoupper($e->nom_complet),
                'origine' => $e->origine,
                'fonction' => ($e->fonction) . " | " . $e->email . " | " . $e->telephone,
                'contact' => $e->telephone . ' / ' . $e->email
            ];
        });

        // Fusion des listes
        $listeParticipants = $internes->concat($externes);

        return view('Reunions.print_presence', compact('reunion', 'listeParticipants'));
    }
}
