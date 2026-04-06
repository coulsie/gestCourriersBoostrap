<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;


class ActivityController extends Controller
{
    /**
     * Liste des activités avec pagination et optimisation RAM
     */



    public function index(Request $request)
    {
        // 1. Récupération de l'agent connecté et de son rôle
        $agent = auth::user()->agent;
        $status = $agent->status;

        // Définition des rôles AUTORISÉS à accéder à cette page
        $rolesAutorises = ['Chef de service', 'Sous-directeur', 'Directeur', 'Conseiller Technique', 'Conseiller Spécial', 'Administrateur'];

        // --- SÉCURITÉ : BLOCAGE DES AGENTS NON AUTORISÉS ---

        if (!in_array($status, $rolesAutorises)) {
            return redirect()->back()->with('error', "Désolé, vous n'avez pas le grade requis pour consulter le journal des activités.");
        }

        // Définition des rôles qui voient TOUTES les directions (Admins/Directeurs)
        $rolesAdmin = ['Directeur', 'Conseiller Technique', 'Conseiller Spécial', 'Administrateur'];

        // 2. On récupère les directions pour le menu (Filtré selon le grade)
        $directions = cache()->remember('directions_list_' . $agent->id, 60, function () use ($rolesAdmin, $status, $agent) {
            $query = Direction::select('id', 'name');
            if (!in_array($status, $rolesAdmin)) {
                // Le Chef de service ou Sous-directeur ne voit que sa direction dans le filtre
                $query->where('id', $agent->service->direction_id);
            }
            return $query->orderBy('name')->get();
        });

        // 3. Construction de la requête principale
        $query = Activity::select(
            'id',
            'service_id',
            'report_date',
            'start_date',
            'end_date',
            'is_permanent',
            'content',
            'progress'
        )->with(['service:id,name,direction_id', 'service.direction:id,name']);

        // --- LOGIQUE DE VISIBILITÉ (FILTRAGE DES DONNÉES) ---
        if (!in_array($status, $rolesAdmin)) {
            if ($status === 'Chef de service') {
                // Voit uniquement son propre service
                $query->where('service_id', $agent->service_id);
            } elseif ($status === 'Sous-directeur') {
                // Voit tous les services de sa direction
                $query->whereHas('service', function ($q) use ($agent) {
                    $q->where('direction_id', $agent->service->direction_id);
                });
            }
        }

        // 4. Filtrage manuel par direction (réservé aux Directeurs/Admins)
        if ($request->filled('direction') && in_array($status, $rolesAdmin)) {
            $query->whereHas('service', fn($q) => $q->where('direction_id', $request->direction));
        }

        $activities = $query->orderBy('report_date', 'desc')
            ->simplePaginate(15)
            ->withQueryString();

        $services = Service::select('id', 'name')->orderBy('name')->get();

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
            'service_id'   => 'required|exists:services,id',
            'report_date'  => 'required|date',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'is_permanent' => 'nullable|boolean',
            'content'      => 'required|string|min:10',
            'progress'     => 'required|integer|min:0|max:100',
        ]);

        try {
            // Force la valeur de is_permanent à boolean (car le checkbox n'envoie rien si non coché)
            $validated['is_permanent'] = $request->has('is_permanent');

            // Si c'est une activité permanente, on s'assure que end_date est nul
            if ($validated['is_permanent']) {
                $validated['end_date'] = null;
            }

            Activity::create($validated);

            return redirect()->route('activities.index')
                ->with('success', 'L\'activité a été enregistrée avec succès !');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
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
            'service_id'   => 'required|exists:services,id',
            'report_date'  => 'required|date',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'is_permanent' => 'nullable|boolean',
            'content'      => 'required|string|min:10',
            'progress'     => 'required|integer|min:0|max:100',
        ]);

        try {
            // Transformation du checkbox en boolean
            $validated['is_permanent'] = $request->has('is_permanent');

            // Nettoyage de la date de fin si l'activité devient permanente
            if ($validated['is_permanent']) {
                $validated['end_date'] = null;
            }

            $activity->update($validated);

            return redirect()->route('activities.index')
                ->with('success', 'Le rapport d\'activité a été mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
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
        // 1. SÉCURITÉ : Récupération de l'agent et contrôle du grade
        $agent = auth::user()->agent;
        $status = $agent->status;
        $rolesAutorises = ['Chef de service', 'Sous-directeur', 'Directeur', 'Conseiller Technique', 'Conseiller Spécial', 'Administrateur'];

        // Redirection si l'utilisateur n'est pas autorisé (évite la page blanche 403)
        if (!in_array($status, $rolesAutorises)) {
            return redirect()->back()->with('error', "Désolé, vous n'avez pas le grade requis pour consulter la synthèse des activités.");
        }

        // 2. Définition des filtres de période
        $periode = $request->get('periode', 'mensuel');
        $direction_id = $request->get('direction_id');
        $date = now();
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

        // 3. LOGIQUE DE FILTRAGE DES DONNÉES (Sécurité par périmètre)
        $rolesAdmin = ['Directeur', 'Conseiller Technique', 'Conseiller Spécial', 'Administrateur'];

        // Si l'utilisateur n'est pas Admin/Directeur, on le force sur sa propre Direction
        if (!in_array($status, $rolesAdmin)) {
            $direction_id = $agent->service->direction_id;
        }

        // 4. Calcul des KPI (Global ou par Direction filtrée)
        $kpiQuery = Activity::whereBetween('report_date', [$startDate, $endDate]);
        if ($direction_id) {
            $kpiQuery->whereHas('service', fn($q) => $q->where('direction_id', $direction_id));
        }

        $totalActivites = (clone $kpiQuery)->count();
        $tauxMoyen = (clone $kpiQuery)->avg('progress') ?? 0;
        $activitesEnCours = (clone $kpiQuery)->whereBetween('progress', [1, 99])->count();
        $activitesNonDemarrees = (clone $kpiQuery)->where('progress', 0)->count();

        // 5. Top Services Actifs
        $topServices = Service::with('direction')
            ->withCount(['activities' => fn($q) => $q->whereBetween('report_date', [$startDate, $endDate])])
            ->orderBy('activities_count', 'desc')
            ->take(5)
            ->get();

        // 6. CONSTRUCTION DES DONNÉES HIÉRARCHIQUES
        $queryDirections = Direction::query();

        // Si on filtre sur une direction (soit par choix admin, soit par force rôle)
        if ($direction_id) {
            $queryDirections->where('id', $direction_id);
        }

        $statsDirections = $queryDirections->with(['services' => function ($query) use ($startDate, $endDate, $agent, $status) {
            // Un Chef de service ne voit que son propre service dans le détail de la direction
            if ($status === 'Chef de service') {
                $query->where('id', $agent->service_id);
            }
            $query->with(['activities' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('report_date', [$startDate, $endDate])->orderBy('report_date', 'desc');
            }]);
        }])
            ->withCount(['activities' => fn($q) => $q->whereBetween('report_date', [$startDate, $endDate])])
            ->withAvg(['activities as avg_progress' => fn($q) => $q->whereBetween('report_date', [$startDate, $endDate])], 'progress')
            ->get();

        $isDetailView = $direction_id ? true : false;

        // Liste des directions pour le select (limitée si non admin)
        $directions = in_array($status, $rolesAdmin) ? Direction::all() : Direction::where('id', $agent->service->direction_id)->get();

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
        // 1. SÉCURITÉ : Récupération de l'agent et contrôle du grade
        $agent = auth::user()->agent;
        $status = $agent->status;
        $rolesAutorises = ['Chef de service', 'Sous-directeur', 'Directeur', 'Conseiller Technique', 'Conseiller Spécial', 'Administrateur'];

        // Redirection si l'utilisateur n'est pas autorisé
        if (!in_array($status, $rolesAutorises)) {
            return redirect()->back()->with('error', "Désolé, vous n'avez pas le grade requis pour consulter le reporting des activités.");
        }

        $annee = $request->get('annee', date('Y'));
        $type = $request->get('type', 'mois');

        // 2. FILTRAGE DES DIRECTIONS (Sécurité par périmètre)
        $rolesAdmin = ['Directeur', 'Conseiller Technique', 'Conseiller Spécial', 'Administrateur'];

        $queryDirections = Direction::query();

        // Si l'utilisateur n'est pas Admin/Directeur, il ne voit que sa direction et ses services
        if (!in_array($status, $rolesAdmin)) {
            $queryDirections->where('id', $agent->service->direction_id);
        }

        $directions = $queryDirections->with(['services' => function ($q) use ($status, $agent) {
            // Si c'est un Chef de Service, on ne garde que son propre service dans le tableau
            if ($status === 'Chef de service') {
                $q->where('id', $agent->service_id);
            }
        }])->get();

        // 3. RÉCUPÉRATION DES STATS (Groupées par service)
        $query = Activity::whereYear('report_date', $annee);

        if ($type == 'semaine') {
            $stats = $query->selectRaw('service_id, WEEK(report_date) as periode, COUNT(*) as total')
                ->groupBy('service_id', 'periode')
                ->get();
            $colonnes = range(1, 52);
            $labelPeriode = "Semaine";
        } else {
            $stats = $query->selectRaw('service_id, MONTH(report_date) as periode, COUNT(*) as total')
                ->groupBy('service_id', 'periode')
                ->get();
            $colonnes = range(1, 12);
            $labelPeriode = "Mois";
        }

        // 4. Construction de la matrice [service_id][periode]
        $matrix = [];
        foreach ($stats as $s) {
            $matrix[$s->service_id][$s->periode] = $s->total;
        }

        return view('activities.reporting', compact('directions', 'matrix', 'colonnes', 'type', 'annee', 'labelPeriode'));
    }
}
