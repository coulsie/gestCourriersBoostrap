<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;


class MeetingController extends Controller
{
    public function hebdo() {
    $debutSemaine = now()->startOfWeek();
    $finSemaine = now()->endOfWeek();

    $reunions = Meeting::with(['animateur', 'redacteur', 'participants'])
        ->whereBetween('date_heure', [$debutSemaine, $finSemaine])
        ->orderBy('date_heure')
        ->get();

    return view('Reunions.hebdo', compact('reunions'));
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

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



}
