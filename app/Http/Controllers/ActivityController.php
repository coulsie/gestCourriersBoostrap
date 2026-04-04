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



public function index(Request $request)
{
    // 1. On récupère les directions pour le menu déroulant (en cache pour la performance)
    $directions = cache()->remember('directions_list', 3600, function () {
        return Direction::select('id', 'name')->orderBy('name')->get();
    });

    // 2. Construction de la requête avec filtrage dynamique
    $query = Activity::select('id', 'service_id', 'report_date', 'content', 'progress')
        ->with([
            'service:id,name,direction_id',
            'service.direction:id,name'
        ]);

    // Filtrer par direction si sélectionné dans le <select>
    if ($request->filled('direction')) {
        $query->whereHas('service', function($q) use ($request) {
            $q->where('direction_id', $request->direction);
        });
    }

    $activities = $query->orderBy('report_date', 'desc')
                        ->simplePaginate(15)
                        ->withQueryString(); // Garde le filtre actif lors du changement de page

    // 3. Liste des services (déjà en cache dans votre code)
    $services = cache()->remember('services_list', 3600, function () {
        return Service::select('id', 'name')->orderBy('name')->get();
    });

    return view('activities.index', compact('activities', 'services', 'directions'));
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
    // 1. Récupération des filtres
    $periode = $request->get('periode', 'mensuel');
    $direction_id = $request->get('direction_id');
    $date = now();

    // 2. Construction de la requête de base selon la période
    $query = Activity::query();
    switch ($periode) {
        case 'hebdomadaire':
            $query->whereBetween('report_date', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')]);
            $label = "cette semaine";
            break;
        case 'trimestriel':
            $query->whereBetween('report_date', [$date->startOfQuarter()->format('Y-m-d'), $date->endOfQuarter()->format('Y-m-d')]);
            $label = "ce trimestre";
            break;
        case 'annuel':
            $query->whereYear('report_date', $date->year);
            $label = "l'année " . $date->year;
            break;
        default:
            $query->whereMonth('report_date', $date->month)->whereYear('report_date', $date->year);
            $label = "ce mois";
            break;
    }

    // 3. Application du filtre Direction sur les KPI (en haut)
    $kpiQuery = clone $query;
    if ($direction_id) {
        $kpiQuery->whereHas('service', fn($q) => $q->where('direction_id', $direction_id));
        $label .= " (Direction spécifique)";
    }

    // 4. Calcul des KPI
    $totalActivites = (clone $kpiQuery)->count();
    $tauxMoyen = (clone $kpiQuery)->avg('progress') ?? 0;
    $activitesEnCours = (clone $kpiQuery)->whereBetween('progress', [1, 99])->count();
    $activitesNonDemarrees = (clone $kpiQuery)->where('progress', 0)->count();

    // 5. Calcul du Top Services (TOUJOURS DÉFINI ICI)
    $topServices = Service::select('services.*', 'directions.name as direction_name')
        ->join('directions', 'services.direction_id', '=', 'directions.id')
        ->withCount(['activities' => function($q) use ($query) {
            $q->whereIn('id', (clone $query)->pluck('id'));
        }])
        ->orderBy('activities_count', 'desc')
        ->take(5)
        ->get();

    // 6. Logique adaptative pour le bas de page (Compil ou Détail)
    $directions = Direction::all();
    if ($direction_id) {
        $statsDirections = Service::where('direction_id', $direction_id)
            ->get()
            ->map(function ($service) use ($query) {
                $sub = Activity::where('service_id', $service->id)->whereIn('id', (clone $query)->pluck('id'));
                $service->activities_count = $sub->count();
                $service->avg_progress = $sub->avg('progress') ?? 0;
                return $service;
            });
        $isDetailView = true;
    } else {
        $statsDirections = $directions->map(function ($dir) use ($query) {
            $sub = Activity::whereHas('service', fn($q) => $q->where('direction_id', $dir->id))
                            ->whereIn('id', (clone $query)->pluck('id'));
            $dir->activities_count = $sub->count();
            $dir->avg_progress = $sub->avg('progress') ?? 0;
            return $dir;
        })->filter(fn($d) => $d->activities_count > 0);
        $isDetailView = false;
    }

    return view('activities.synthese', compact(
        'totalActivites', 'tauxMoyen', 'activitesEnCours', 'activitesNonDemarrees',
        'statsDirections', 'topServices', 'periode', 'label', 'directions',
        'direction_id', 'isDetailView'
    ));
}

    public function reporting(Request $request)
    {
        // On récupère l'année en cours par défaut ou celle choisie
        $annee = $request->get('annee', date('Y'));
        $type = $request->get('type', 'mois'); // 'mois' ou 'semaine'

        // 1. Récupérer les directions et leurs services
        $directions = Direction::with('services')->get();

        // 2. Initialiser la requête sur le modèle Activity avec la bonne colonne : report_date
        $query = Activity::whereYear('report_date', $annee);

        if ($type == 'semaine') {
            // Groupement par semaine via la colonne report_date
            $stats = $query->selectRaw('service_id, WEEK(report_date) as periode, COUNT(*) as total')
                ->groupBy('service_id', 'periode')
                ->get();
            $colonnes = range(1, 52);
            $labelPeriode = "Semaine";
        } else {
            // Groupement par mois via la colonne report_date
            $stats = $query->selectRaw('service_id, MONTH(report_date) as periode, COUNT(*) as total')
                ->groupBy('service_id', 'periode')
                ->get();
            $colonnes = range(1, 12);
            $labelPeriode = "Mois";
        }

        // 3. Transformer en tableau associatif [service_id][periode] = total
        $matrix = [];
        foreach ($stats as $s) {
            $matrix[$s->service_id][$s->periode] = $s->total;
        }

        return view('activities.reporting', compact('directions', 'matrix', 'colonnes', 'type', 'annee', 'labelPeriode'));
    }
}
