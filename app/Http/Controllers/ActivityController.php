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

        // 2. Définition des bornes de dates (Plage de filtrage)
        $startDate = now();
        $endDate = now();

        switch ($periode) {
            case 'hebdomadaire':
                $startDate = $date->startOfWeek()->format('Y-m-d');
                $endDate = $date->endOfWeek()->format('Y-m-d');
                $label = "cette semaine";
                break;
            case 'trimestriel':
                $startDate = $date->startOfQuarter()->format('Y-m-d');
                $endDate = $date->endOfQuarter()->format('Y-m-d');
                $label = "ce trimestre";
                break;
            case 'annuel':
                $startDate = $date->startOfYear()->format('Y-m-d');
                $endDate = $date->endOfYear()->format('Y-m-d');
                $label = "l'année " . $date->year;
                break;
            default:
                $startDate = $date->startOfMonth()->format('Y-m-d');
                $endDate = $date->endOfMonth()->format('Y-m-d');
                $label = "ce mois";
                break;
        }

        // 3. Calcul des KPI (Global ou par Direction)
        $kpiQuery = Activity::whereBetween('report_date', [$startDate, $endDate]);
        if ($direction_id) {
            $kpiQuery->whereHas('service', fn($q) => $q->where('direction_id', $direction_id));
        }

        $totalActivites = (clone $kpiQuery)->count();
        $tauxMoyen = (clone $kpiQuery)->avg('progress') ?? 0;
        $activitesEnCours = (clone $kpiQuery)->whereBetween('progress', [1, 99])->count();
        $activitesNonDemarrees = (clone $kpiQuery)->where('progress', 0)->count();

        // 4. Top Services Actifs
        $topServices = Service::with('direction')
            ->withCount(['activities' => fn($q) => $q->whereBetween('report_date', [$startDate, $endDate])])
            ->orderBy('activities_count', 'desc')
            ->take(5)
            ->get();

        // 5. CONSTRUCTION DES DONNÉES HIÉRARCHIQUES (Détail des activités)
        // On récupère les Directions -> avec leurs Services -> avec leurs Activités sur la période
        $queryDirections = Direction::with(['services' => function ($query) use ($startDate, $endDate) {
            $query->with(['activities' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('report_date', [$startDate, $endDate])->orderBy('report_date', 'desc');
            }]);
        }])
            ->withCount(['activities' => fn($q) => $q->whereBetween('report_date', [$startDate, $endDate])])
            ->withAvg(['activities as avg_progress' => fn($q) => $q->whereBetween('report_date', [$startDate, $endDate])], 'progress');

        if ($direction_id) {
            $statsDirections = $queryDirections->where('id', $direction_id)->get();
            $isDetailView = true;
        } else {
            // Pour la vue globale, on ne garde que les directions qui ont eu des activités sur la période
            $statsDirections = $queryDirections->having('activities_count', '>', 0)->get();
            $isDetailView = false;
        }

        $directions = Direction::all();

        return view('activities.synthese', compact(
            'totalActivites',
            'tauxMoyen',
            'activitesEnCours',
            'activitesNonDemarrees',
            'statsDirections',
            'topServices',
            'periode',
            'label',
            'directions',
            'direction_id',
            'isDetailView'
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
