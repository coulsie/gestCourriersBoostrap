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
        $activities = Activity::select('id', 'service_id', 'report_date', 'content')
            ->with([
                'service:id,name,direction_id',
                'service.direction:id,name'
            ])
            ->orderBy('report_date', 'desc')
            ->paginate(15); // Augmenté à 15, plus standard

        $services = Service::select('id', 'name')->orderBy('name')->get();

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

    // 1. Base de la requête : On ne sélectionne que l'essentiel
    $query = Direction::query()->select('id', 'name');

    // 2. Filtre par Direction spécifique
    if ($directionId) {
        $query->where('id', $directionId);
    }

    // 3. OPTIMISATION : On ne charge QUE les directions ayant des activités sur la période
    // Cela évite de traiter des données vides inutilement
    $query->whereHas('services.activities', function($q) use ($periode) {
        $q->forPeriod($periode);
    });

    // 4. Eager Loading ultra-ciblé
    $directions = $query->with(['services' => function($q) use ($periode) {
        $q->select('id', 'name', 'direction_id')
          ->whereHas('activities', function($aq) use ($periode) {
              $aq->forPeriod($periode);
          })
          ->with(['activities' => function($aq) use ($periode) {
              $aq->select('id', 'service_id', 'report_date', 'content')
                 ->forPeriod($periode)
                 ->orderBy('report_date', 'desc');
          }]);
    }])->get();

    // 5. Transformation des données
    $rapport = $directions->map(function ($direction) {
        $details = [];
        $total = 0;

        foreach ($direction->services as $service) {
            foreach ($service->activities as $activity) {
                $details[] = [
                    'service' => $service->name,
                    'date'    => $activity->report_date->format('d/m/Y'),
                    'texte'   => $activity->content
                ];
                $total++;
            }
        }

        return [
            'direction' => $direction->name,
            'total_activites' => $total,
            'details' => $details
        ];
    });

    // Liste pour le filtre (optimisée)
    $allDirections = Direction::select('id', 'name')->orderBy('name')->get();

    return view('activities.synthese', [
        'rapport' => $rapport,
        'periode' => $periode,
        'directions' => $allDirections
    ]);
}

}
