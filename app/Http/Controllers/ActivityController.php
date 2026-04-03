<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ActivityController extends Controller
{
    /**
     * Liste des activités avec pagination et optimisation RAM
     */



public function index()
{
    // 1. On récupère les activités de manière fluide (sans calculer le total global)
    $activities = Activity::select('id', 'service_id', 'report_date', 'content')
        ->with([
            'service:id,name,direction_id',
            'service.direction:id,name'
        ])
        ->orderBy('report_date', 'desc')
        ->simplePaginate(15);

    // 2. On met en cache la liste des services pendant 1 heure (3600 secondes)
    // Cela évite de recharger la liste des services à chaque affichage de l'index
    $services = cache()->remember('services_list', 3600, function () {
        return Service::select('id', 'name')->orderBy('name')->get();
    });

    return view('activities.index', compact('activities', 'services'));
}


    /**
     * Formulaire de création
     */
    public function create()
    {
        $services = Service::select('id', 'name')->orderBy('name')->get();
        return view('activities.create', compact('services'));
    }

    /**
     * Enregistrement sécurisé
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'  => 'required|exists:services,id',
            'report_date' => 'required|date',
            'content'     => 'required|string|min:10',
        ]);

        try {
            Activity::create($validated);
            return redirect()->route('activities.index')
                ->with('success', 'L\'activité a été enregistrée avec succès !');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de l\'enregistrement.');
        }
    }

    /**
     * Détails d'une activité
     */
    public function show(Activity $activity)
    {
        $activity->load(['service:id,name,direction_id', 'service.direction:id,name']);
        return view('activities.show', compact('activity'));
    }

    /**
     * Edition d'une activité
     */
    public function edit(Activity $activity)
    {
        $services = Service::select('id', 'name')->orderBy('name')->get();
        return view('activities.edit', compact('activity', 'services'));
    }

    /**
     * Mise à jour sécurisée
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'service_id'  => 'required|exists:services,id',
            'report_date' => 'required|date',
            'content'     => 'required|string|min:10',
        ]);

        try {
            $activity->update($validated);
            return redirect()->route('activities.index')
                ->with('success', 'Le rapport d\'activité a été mis à jour.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    /**
     * Suppression sécurisée
     */
    public function destroy(Activity $activity)
    {
        try {
            $activity->delete();
            return redirect()->route('activities.index')
                ->with('success', 'Le rapport a été supprimé définitivement.');
        } catch (Exception $e) {
            return redirect()->route('activities.index')
                ->with('error', 'Impossible de supprimer ce rapport.');
        }
    }

    /**
     * Synthèse optimisée pour les grandes quantités de données
     */


public function synthese(Request $request)
{
    $periode = $request->get('periode', 'weekly');
    $directionId = $request->get('direction_id');

    // On récupère directement les activités filtrées avec leurs relations
    $activities = Activity::query()
        ->select('id', 'service_id', 'report_date', 'content')
        ->forPeriod($periode)
        ->with(['service:id,name,direction_id', 'service.direction:id,name'])
        ->when($directionId, function($q) use ($directionId) {
            $q->whereHas('service', function($sq) use ($directionId) {
                $sq->where('direction_id', $directionId);
            });
        })
        ->orderBy('report_date', 'desc')
        ->get();

    // ✅ On groupe par Direction directement via les Collections Laravel (très rapide)
    $rapport = $activities->groupBy(function($activity) {
        return $activity->service->direction->name;
    })->map(function ($group, $directionName) {
        return [
            'direction' => $directionName,
            'total_activites' => $group->count(),
            'details' => $group->map(function($act) {
                return [
                    'service' => $act->service->name,
                    'date'    => $act->report_date->format('d/m/Y'),
                    'texte'   => $act->content
                ];
            })
        ];
    })->values();

    $allDirections = Direction::select('id', 'name')->orderBy('name')->get();

    return view('activities.synthese', [
        'rapport' => $rapport,
        'periode' => $periode,
        'directions' => $allDirections
    ]);
}

}
