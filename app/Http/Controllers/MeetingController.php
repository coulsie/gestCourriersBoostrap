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
        $debutSemaine = now()->startOfWeek();
        $finSemaine = now()->endOfWeek();

        // 1. Réunions de la semaine (ton code actuel)
        $reunions = Meeting::with(['animateur', 'redacteur', 'participants'])
            ->whereBetween('date_heure', [$debutSemaine, $finSemaine])
            ->orderBy('date_heure')
            ->get();

        // 2. Réunions hors-semaine (passées et futures)
        $autresReunions = Meeting::with(['animateur', 'redacteur'])
            ->whereNotBetween('date_heure', [$debutSemaine, $finSemaine])
            ->orderBy('date_heure', 'desc') // Les plus récentes en premier
            ->get();

        // On envoie les deux variables à la vue
        return view('Reunions.hebdo', compact('reunions', 'autresReunions'));
    }


    public function create()
{
    // On trie par le nom de famille (last_name)
    $agents = \App\Models\Agent::orderBy('last_name', 'asc')->get();
    return view('Reunions.create', compact('agents'));
}


public function store(Request $request)
{
    // 1. Validation de tous les champs provenant du formulaire
    $validated = $request->validate([
        'objet' => 'required|string|max:255',
        'date_heure' => 'required|date',
        'animateur_id' => 'required|exists:agents,id',
        'redacteur_id' => 'required|exists:agents,id',
        'participants' => 'nullable|array',
        'participants.*' => 'exists:agents,id',
        'externes_simple' => 'nullable|string',
        'ordre_du_jour' => 'nullable|string',
    ]);

    // 2. Préparer les données pour l'insertion
    // On extrait les données validées dans une variable $data
    $data = $validated;

    // 3. Transformation du texte "externes_simple" pour la colonne "externes" de la base
    if ($request->filled('externes_simple')) {
        // On transforme "Jean, Marc" en tableau ["Jean", "Marc"]
        $nomsTableau = array_filter(array_map('trim', explode(',', $request->externes_simple)));

        // IMPORTANT : On force l'ajout dans $data pour que Laravel le voie lors du create()
        // array_values permet de réinitialiser les clés du tableau
        $data['externes'] = array_values($nomsTableau);
    } else {
        $data['externes'] = null;
    }

    // 4. Créer la réunion (Laravel fera le json_encode automatiquement grâce au $casts 'array' du modèle)
    $reunion = \App\Models\Meeting::create($data);

    // 5. Attacher les participants internes (table pivot)
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
        return view('reunions.show', compact('reunion'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Meeting $reunion)
    {
        $agents = Agent::orderBy('last_name')->get();
        return view('reunions.edit', compact('reunion', 'agents'));
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
        ]);

        $externes = null;
        if ($request->filled('externes_simple')) {
            $externes = array_map('trim', explode(',', $request->externes_simple));
        }

        $reunion->update([
            'objet' => $request->objet,
            'date_heure' => $request->date_heure,
            'animateur_id' => $request->animateur_id,
            'redacteur_id' => $request->redacteur_id,
            'ordre_du_jour' => $request->ordre_du_jour,
            'externes' => $externes,
        ]);

        // Sync synchronise la table pivot (ajoute les nouveaux, retire les absents)
        $reunion->participants()->sync($request->participants ?? []);

        return redirect()->route('reunions.hebdo')->with('success', 'Mise à jour effectuée.');
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
}
