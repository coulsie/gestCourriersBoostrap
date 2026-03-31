<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{

    public function index()
    {
        $activities = Activity::with('service.direction')
            ->orderBy('report_date', 'desc')
            ->paginate(10);

        $services = Service::all();
        return view('activities.index', compact('activities', 'services'));
    }


/**
     * Formulaire de saisie quotidienne pour un service
     */
    public function create()
    {
        // En production, on récupérerait le service de l'utilisateur connecté
        $services = Service::all();
        return view('activities.create', compact('services'));
    }

    public function edit(Activity $activity) {
        $services = Service::all();
        return view('activities.edit', compact('activity', 'services'));
    }

    public function show(Activity $activity)
    {
        // On charge les relations pour éviter les requêtes N+1 dans la vue
        $activity->load('service.direction');
        return view('activities.show', compact('activity'));
    }


    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Le rapport a été supprimé définitivement.');
    }


    /**
     * Enregistrement de l'activité du jour
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
            'service_id'  => 'required|exists:services,id',
            'report_date' => 'required|date',
            'content'     => 'required|string|min:10',
        ]);

        Activity::create($validated);

            // Redirection vers la liste globale avec le message de succès
            return redirect()
                ->route('activities.index')
                ->with('success', 'L\'activité a été enregistrée avec succès !');
    }

    /**
     * Synthèse des activités par Direction
     * Usage : /synthese?periode=monthly&direction_id=1
     */
    public function synthese(Request $request)
    {
        $periode = $request->get('periode', 'weekly'); // Par défaut hebdo
        $directionId = $request->get('direction_id');

        // 1. On récupère les directions avec leurs services et activités filtrées
        $query = Direction::with(['services.activities' => function($q) use ($periode) {
            $q->forPeriod($periode)->orderBy('report_date', 'desc');
        }]);

        // 2. Filtrer par une direction spécifique si demandé
        if ($directionId) {
            $query->where('id', $directionId);
        }

        $directions = $query->get();

        // 3. Transformation pour la vue (regrouper les textes par direction)
        $rapport = $directions->map(function ($direction) {
            return [
                'direction' => $direction->name,
                'total_activites' => $direction->services->sum(fn($s) => $s->activities->count()),
                'details' => $direction->services->flatMap(fn($s) => $s->activities->map(fn($a) => [
                    'service' => $s->name,
                    'date' => $a->report_date->format('d/m/Y'),
                    'texte' => $a->content
                ]))
            ];
        });

        return view('activities.synthese', [
            'rapport' => $rapport,
            'periode' => $periode,
            'directions' => Direction::all()
        ]);
    }

    /**
 * Met à jour une activité existante.
 */
    public function update(Request $request, Activity $activity)
    {
        // 1. Validation des données entrantes
        $validated = $request->validate([
            'service_id'  => 'required|exists:services,id',
            'report_date' => 'required|date',
            'content'     => 'required|string|min:10',
        ]);

        // 2. Mise à jour de l'enregistrement
        $activity->update($validated);

        // 3. Redirection vers l'index avec le message de succès
        return redirect()
            ->route('activities.index')
            ->with('success', 'Le rapport d\'activité a été mis à jour avec succès !');
    }


}
