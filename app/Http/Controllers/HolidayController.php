<?php
// app/Http/Controllers/HolidayController.php
namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{

    public function index()
    {
        // On trie par holiday_date de façon croissante (asc)
        $holidays = Holiday::orderBy('holiday_date', 'asc')->get();

        return view('holidays.index', compact('holidays'));
    }


    public function store(Request $request)
    {
        // 1. Vérifier si un jour férié existe déjà pour cette date
        $existing = \App\Models\Holiday::whereDate('holiday_date', $request->holiday_date)->first();

        if ($existing) {
            $dateFmt = \Carbon\Carbon::parse($request->holiday_date)->format('d/m/Y');
            $nomExistant = mb_strtoupper($existing->name, 'UTF-8');

            return back()->withInput()->withErrors([
                'holiday_date' => "Enregistrement impossible : le $dateFmt est déjà enregistré comme jour férié ($nomExistant). Opération annulée."
            ]);
        }

        // 2. Validation si la date est libre
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|date',
        ]);

        // 3. Force la désignation en MAJUSCULES
        $data['name'] = mb_strtoupper($data['name'], 'UTF-8');

        \App\Models\Holiday::create($data);

        return back()->with('success', "Le jour férié " . $data['name'] . " a été enregistré avec succès !");
    }



    public function destroy(Holiday $holiday) {
        $holiday->delete();
        return back()->with('success', 'Jour férié supprimé.');
    }

    public function syncPresences($date) {
        \App\Models\Presence::whereDate('heure_arrivee', $date)
            ->update(['statut' => 'Férié']);

        return back()->with('success', 'Les présences de cette date ont été mises à jour.');
    }

    public function create()
    {
        return view('holidays.create');
    }


        public function edit(Holiday $holiday)
    {
        return view('holidays.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            // On ignore l'ID actuel pour la règle unique
            'holiday_date' => 'required|date|unique:holidays,holiday_date,' . $holiday->id,
            'description' => 'nullable|string'
        ]);

        // 1. Forcer la désignation en MAJUSCULES avant l'update
        $data['name'] = mb_strtoupper($data['name'], 'UTF-8');

        // 2. Mise à jour du jour férié
        $holiday->update($data);

        // 3. Mise à jour des présences existantes à cette nouvelle date
        \App\Models\Presence::whereDate('heure_arrivee', $holiday->holiday_date)
            ->update(['statut' => 'Férié']);

        return redirect()->route('holidays.index')
            ->with('success', 'Le jour férié "' . $holiday->name . '" a été mis à jour avec succès.');
    }

}
