<?php
// app/Http/Controllers/HolidayController.php
namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index() {
        $holidays = Holiday::orderBy('holiday_date', 'asc')->get();
        return view('holidays.index', compact('holidays'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|date|unique:holidays,holiday_date',
        ]);

        Holiday::create($data);
        return back()->with('success', 'Jour férié ajouté !');
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

        $holiday->update($data);

        // Optionnel : Mettre à jour les présences existantes à cette nouvelle date
        \App\Models\Presence::whereDate('heure_arrivee', $holiday->holiday_date)
            ->update(['statut' => 'Férié']);

        return redirect()->route('holidays.index')
            ->with('success', 'Le jour férié a été mis à jour avec succès.');
    }


}
