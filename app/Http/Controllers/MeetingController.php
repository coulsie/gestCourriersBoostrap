<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\Meeting;


class MeetingController extends Controller
{
    public function hebdo()
{
    // Définition de la plage de la semaine actuelle (Lundi 00:00 au Dimanche 23:59)
    $debutSemaine = now()->startOfWeek()->startOfDay();
    $finSemaine = now()->endOfWeek()->endOfDay();

    // 1. Réunions de la semaine en cours
    $reunions = Meeting::with(['animateur', 'redacteur', 'participants'])
        ->whereBetween('date_heure', [$debutSemaine, $finSemaine])
        ->orderBy('date_heure', 'asc')
        ->get();

    // 2. Réunions hors-semaine (Historique complet pour le Modal)
    // On récupère tout ce qui n'est pas dans la semaine actuelle
    $autresReunions = Meeting::with(['animateur', 'redacteur'])
        ->whereNotBetween('date_heure', [$debutSemaine, $finSemaine])
        ->orderBy('date_heure', 'desc') // Les plus récentes (ou futures proches) en premier
        ->get();

    // Optionnel : On peut aussi calculer le nombre de réunions "À CLÔTURER" pour une alerte globale
    $nbRetards = $reunions->where('status', 'programmee')
                         ->filter(fn($r) => \Carbon\Carbon::parse($r->date_heure)->isPast())
                         ->count();

    // On envoie les variables à la vue
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
    // 1. Validation
    $validated = $request->validate([
        'objet' => 'required|string|max:255',
        'date_heure' => 'required|date',
        'animateur_id' => 'required|exists:agents,id',
        'redacteur_id' => 'required|exists:agents,id',
        'participants' => 'nullable|array',
        'participants.*' => 'exists:agents,id',
        'externes_simple' => 'nullable|string',
        'ordre_du_jour' => 'nullable|string',
        'lieu' => 'nullable|string|max:255'
    ]);

    $data = $validated;

    // 2. Traitement des externes
    if ($request->filled('externes_simple')) {
        $nomsTableau = array_filter(array_map('trim', explode(',', $request->externes_simple)));
        $data['externes'] = array_values($nomsTableau);
    } else {
        $data['externes'] = null;
    }

    // --- CORRECTION ICI ---
    // 3. ON RETIRE les clés qui ne sont pas des colonnes dans la table 'meetings'
    unset($data['participants']);      // Va dans la table pivot, pas dans 'meetings'
    unset($data['externes_simple']);   // Colonne inexistante (on utilise 'externes' à la place)

    // 4. Créer la réunion (Uniquement avec les colonnes réelles)
    $reunion = \App\Models\Meeting::create($data);

    // 5. Attacher les participants internes (Table pivot meeting_participants)
    if ($request->has('participants')) {
        $reunion->participants()->attach($request->participants);
    }

    return redirect()->route('reunions.hebdo')->with('success', 'Réunion programmée avec succès !');
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

    /**
     * Formulaire d'édition
     */
    public function edit(Meeting $reunion)
    {
        $agents = Agent::orderBy('last_name')->get();
        return view('Reunions.edit', compact('reunion', 'agents'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Meeting $reunion)
{
    $validated = $request->validate([
        'objet' => 'required|string|max:255',
        'date_heure' => 'required',
        'animateur_id' => 'required|exists:agents,id',
        'redacteur_id' => 'required|exists:agents,id',
        'externes_simple' => 'nullable|string',
        'lieu' => 'nullable|string|max:255',
        'ordre_du_jour' => 'nullable|string',
        'status' => 'required|in:programmee,terminee,annulee',
        'presence_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2Mo
        'report_file' => 'nullable|file|mimes:pdf,doc,docx,odt|max:5120',   // Max 5Mo
    ]);

    // 1. Traitement des participants externes
    $externes = null;
    if ($request->filled('externes_simple')) {
        $externes = array_map('trim', explode(',', $request->externes_simple));
    }

    // 2. Gestion de l'upload de la liste de présence
        if ($request->hasFile('presence_file')) {
            $fileP = $request->file('presence_file');
            $fileNameP = time() . '_presence_' . $fileP->getClientOriginalName();

            // Déplacement vers public/Rapport_Reunions
            $fileP->move(public_path('Rapport_Reunions'), $fileNameP);

            // On enregistre le nom du fichier dans le tableau de données
            $data['presence_file'] = $fileNameP;
        }

        // 3. Gestion de l'upload du rapport / compte-rendu
        if ($request->hasFile('report_file')) {
            $fileR = $request->file('report_file');
            $fileNameR = time() . '_rapport_' . $fileR->getClientOriginalName();

            // Déplacement vers public/Rapport_Reunions
            $fileR->move(public_path('Rapport_Reunions'), $fileNameR);

            // On enregistre le nom du fichier dans le tableau de données
            $data['report_file'] = $fileNameR;
        }

    // 4. Mise à jour des données textuelles et fichiers
    $reunion->update([
        'objet'         => $request->objet,
        'date_heure'    => $request->date_heure,
        'animateur_id'  => $request->animateur_id,
        'redacteur_id'  => $request->redacteur_id,
        'ordre_du_jour' => $request->ordre_du_jour,
        'externes'      => $externes,
        'lieu'          => $request->lieu,
        'status'        => $request->status,
        'presence_file' => $data['presence_file'] ?? $reunion->presence_file,
        'report_file'   => $data['report_file'] ?? $reunion->report_file,
    ]);

    // 5. Synchronisation des participants internes
    $reunion->participants()->sync($request->participants ?? []);

    return redirect()->route('reunions.hebdo')->with('success', 'Réunion mise à jour et classée avec succès.');
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

}
