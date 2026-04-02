<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Presence;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Horaire; // <--- AJOUTER CET IMPORT
use Carbon\Carbon;      // <--- AJOUTER CET IMPORT
use App\Models\Absence;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Holiday; // N'oubliez pas d'importer le modèle


class PresenceController extends Controller
{
    /**
     * Affiche une liste des ressources (présences).
     */



 public function index(Request $request)
{
    // 1. Initialisation avec la relation agent
    $query = Presence::with('agent');

    // 2. FILTRE : Recherche par nom ou prénom
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('agent', function($q) use ($search) {
            $q->where(function($subQuery) use ($search) {
                $subQuery->where('last_name', 'like', "%{$search}%")
                         ->orWhere('first_name', 'like', "%{$search}%");
            });
        });
    }

    // 3. FILTRE : Par statut
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    // 4. FILTRE : Par date exacte
    if ($request->filled('date')) {
        $query->whereDate('heure_arrivee', $request->date);
    }

    // 5. LOGIQUE DE TRI DYNAMIQUE
    $sort = $request->get('sort', 'heure_arrivee'); // Colonne par défaut
    $direction = $request->get('direction', 'desc'); // Ordre par défaut (plus récent en haut)

    if ($sort === 'nom') {
        // Pour trier par le nom de l'agent, une jointure est nécessaire
        $query->join('agents', 'presences.agent_id', '=', 'agents.id')
              ->select('presences.*') // Important pour garder les IDs de la table presences
              ->orderBy('agents.last_name', $direction)
              ->orderBy('agents.first_name', $direction);
    } else {
        // Tri sur les colonnes de la table presences (heure_arrivee, id, etc.)
        // On vérifie que la colonne existe pour éviter les erreurs SQL
        $allowedSorts = ['id', 'heure_arrivee', 'heure_depart', 'statut'];
        $sortColumn = in_array($sort, $allowedSorts) ? $sort : 'heure_arrivee';
        $query->orderBy($sortColumn, $direction);
    }

    // 6. Exécution avec pagination et conservation des paramètres d'URL
    $presences = $query->paginate(30)->withQueryString();

    return view('presences.index', compact('presences'));
}

    /**
     * Affiche le formulaire de création d'une nouvelle ressource (présence).
     */
   public function create(): View
{
    // Récupère les agents triés par NOM de famille, puis par Prénom
    $agents = Agent::orderBy('last_name', 'asc')
                   ->orderBy('first_name', 'asc')
                   ->get();

    return view('presences.create', compact('agents'));
}


    /**
     * Stocke une nouvelle ressource (présence) dans la base de données.
                            */
public function store(Request $request)
{
    $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'heure_arrivee' => 'nullable|date',
    ]);

    // 1. Déterminer la date
    $heureArrivee = $request->filled('heure_arrivee')
        ? \Carbon\Carbon::parse($request->heure_arrivee)
        : \Carbon\Carbon::now();

    $dateJour = $heureArrivee->toDateString();

    // 2. VÉRIFICATION JOUR FÉRIÉ (BLOQUANT)
    $ferie = \App\Models\Holiday::where('holiday_date', $dateJour)->first();

    if ($ferie) {
        return redirect()->route('presences.index')
            ->with('error', "Enregistrement de présence impossible : le " . $heureArrivee->format('d/m/Y') . " est un jour férié (" . $ferie->name . ").");
    }

    // 3. VÉRIFICATION DE DOUBLON
    $dejaPointe = \App\Models\Presence::where('agent_id', $request->agent_id)
        ->whereDate('heure_arrivee', $dateJour)
        ->exists();

    if ($dejaPointe) {
        return redirect()->back()
            ->withInput()
            ->with('error', "Attention : Cet agent a déjà effectué son pointage pour la journée du " . $heureArrivee->format('d/m/Y') . ".");
    }

    // 4. Logique des horaires
    $joursFr = [
        'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'
    ];
    $jourFr = $joursFr[$heureArrivee->format('l')];

    $horaireFixe = \App\Models\Horaire::where('jour', $jourFr)->first();
    $statut = 'Présent';
    $debugNote = "";

    if (!$horaireFixe) {
        $debugNote = "ERREUR : Aucun horaire configuré pour le jour $jourFr. ";
    } else {
        $minArrivee = ($heureArrivee->hour * 60) + $heureArrivee->minute;
        $debutTheorique = \Carbon\Carbon::parse($horaireFixe->heure_debut);
        $tolerance = (int)$horaireFixe->tolerance_retard;
        $minLimite = ($debutTheorique->hour * 60) + $debutTheorique->minute + $tolerance;

        if ($minArrivee > $minLimite) {
            $statut = 'En Retard';
        }
        $debugNote = "Calculé pour $jourFr (Limite: {$minLimite}m, Arrivée: {$minArrivee}m). ";
    }

    // 5. Création de l'enregistrement
    \App\Models\Presence::create([
        'agent_id'      => $request->agent_id,
        'heure_arrivee' => $heureArrivee,
        'statut'        => $statut,
        'notes'         => $debugNote . ($request->notes ?? ''),
        'heure_depart'  => $request->heure_depart ?: null
    ]);

    return redirect()->route('presences.index')->with('success', "Pointage enregistré : $statut");
}

    /**
     * Affiche la ressource (présence) spécifiée.
     */
    public function show(Presence $presence): View
    {
        return view('presences.show', compact('presence'));
    }

    /**
     * Affiche le formulaire d'édition de la ressource (présence) spécifiée.
     */
    public function edit(Presence $presence): View
    {
        $agents = Agent::all();
        return view('presences.edit', compact('presence', 'agents'));
    }

    /**
     * Met à jour la ressource (présence) spécifiée dans la base de données.
     */


  public function update(Request $request, Presence $presence): RedirectResponse
{
    $validatedData = $request->validate([
        'agent_id'      => 'required|integer|exists:agents,id',
        'heure_arrivee' => 'required|date',
        'heure_depart'  => 'nullable|date|after:heure_arrivee',
        'notes'         => 'nullable|string|max:1000',
    ], [
        'agent_id.required'      => 'L\'agent est obligatoire.',
        'heure_arrivee.required' => 'L\'heure d\'arrivée est requise.',
        'heure_depart.after'     => 'L\'heure de départ doit être après l\'heure d\'arrivée.',
    ]);

    try {
        // 1. Récupération de l'horaire (ex: lié à l'agent ou au service)
        $horaire = \App\Models\Horaire::first();

        if ($horaire && !empty($horaire->heure_debut)) {
            // Conversion sécurisée en objet Carbon pour la comparaison
            $arrivee = \Carbon\Carbon::parse($validatedData['heure_arrivee']);

            // Nettoyage de l'heure de référence (ex: "08:00:00") pour éviter l'erreur de "Separation symbol"
            $reference = \Carbon\Carbon::parse($horaire->heure_debut);

            // 2. Comparaison des heures uniquement (H:i:s)
            if ($arrivee->format('H:i:s') > $reference->format('H:i:s')) {
                $validatedData['statut'] = 'En Retard';
            } else {
                $validatedData['statut'] = 'Présent';
            }
        } else {
            // Statut par défaut si aucun horaire n'est défini
            $validatedData['statut'] = 'Présent';
        }

        $presence->update($validatedData);

        return redirect()->route('presences.index')
                         ->with('success', 'Présence et statut mis à jour avec succès.');

    } catch (\Exception $e) {
        // Log de l'erreur réelle pour le développeur
        \Illuminate\Support\Facades\Log::error("Erreur Format Heure: " . $e->getMessage());

        return back()->with('error', 'Erreur de format de l\'heure de référence dans la table horaires.');
    }
}

    /**
     * Supprime la ressource (présence) spécifiée de la base de données.
     */
    public function destroy(Presence $presence): RedirectResponse
    {
        $presence->delete();

        // Redirection avec un message de succès
        return redirect()->route('presences.index')
                         ->with('success', 'Présence supprimée avec succès.');
    }





 public function indexValidationHebdo()
{
    $debutSemaine = now()->subWeek()->startOfWeek();
    // On s'arrête au vendredi pour ignorer le weekend
    $finSemaine = now()->subWeek()->startOfWeek()->addDays(4);

    // 1. Forcer le format string 'Y-m-d' pour les jours fériés
    $joursFeries = \App\Models\Holiday::whereBetween('holiday_date', [
            $debutSemaine->toDateString(),
            $finSemaine->toDateString()
        ])
        ->pluck('holiday_date')
        ->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d'))
        ->toArray();

    $agents = Agent::all();
    $absencesDetectees = [];

    foreach ($agents as $agent) {
        $currentDate = $debutSemaine->copy();

        while ($currentDate <= $finSemaine) {
            $dateStr = $currentDate->toDateString();

            // 2. EXCLUSION STRICTE : Si férié, on saute DIRECTEMENT au jour suivant
            if (in_array($dateStr, $joursFeries)) {
                $currentDate->addDay();
                continue;
            }

            // 3. Vérifier si une présence (peu importe le statut) existe déjà
            $dejaPointe = Presence::where('agent_id', $agent->id)
                                 ->whereDate('heure_arrivee', $dateStr)
                                 ->exists();

            if (!$dejaPointe) {
                // On cherche si une permission (statut 1) couvre ce jour
                $justif = \App\Models\Absence::where('agent_id', $agent->id)
                    ->where('approuvee', 1) // On utilise votre statut validé
                    ->whereDate('date_debut', '<=', $dateStr)
                    ->whereDate('date_fin', '>=', $dateStr)
                    ->first();

                $absencesDetectees[] = [
                    'agent_id'     => $agent->id,
                    'nom'          => strtoupper($agent->last_name) . ' ' . $agent->first_name,
                    'date'         => $dateStr,
                    'est_justifie' => !is_null($justif),
                    'motif'        => $justif ? $justif->motif : 'Non justifié',
                ];
            }
            $currentDate->addDay();
        }
    }

    return view('presences.validation-hebdo', compact('absencesDetectees'));
}


public function storeValidationHebdo(Request $request)
{
    $absencesInput = $request->input('absences', []);

    foreach ($absencesInput as $data) {
        if (isset($data['selected']) && $data['selected'] == "1") {
            $agentId = $data['agent_id'];
            $dateAbsence = $data['date'];

            // Sécurité : Ne pas valider si c'est un jour férié
            $isFerie = \App\Models\Holiday::where('holiday_date', $dateAbsence)->exists();
            if ($isFerie) continue;

            $justificatif = \App\Models\Absence::where('agent_id', $agentId)
                ->whereDate('date_debut', '<=', $dateAbsence)
                ->whereDate('date_fin', '>=', $dateAbsence)
                ->first();

            $statut = $justificatif ? 'Absence Justifiée' : 'Absent';
            $note = $justificatif ? "Justifié: " . $justificatif->motif : "Absence hebdomadaire.";

            try {
                DB::statement("
                    INSERT INTO presences (agent_id, heure_arrivee, statut, notes, created_at, updated_at)
                    VALUES (?, ?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                        statut = VALUES(statut),
                        notes = VALUES(notes),
                        updated_at = NOW()
                ", [$agentId, $dateAbsence . ' 08:00:00', $statut, $note]);
            } catch (\Exception $e) {
                Log::error("Erreur storeValidationHebdo : " . $e->getMessage());
            }
        }
    }
    return redirect()->route('presences.index')->with('success', 'Traitement terminé.');
}

public function rapport(Request $request)
{
    $debut = $request->debut ?? now()->startOfMonth()->toDateString();
    $fin = $request->fin ?? now()->toDateString();

    $donnees = Presence::with(['agent', 'Absence.typeAbsence'])
                ->whereBetween('heure_arrivee', [$debut . ' 00:00:00', $fin . ' 23:59:59'])
                ->get();

    $total = $donnees->count();

    $analyses = [
        'taux_presence'   => $total > 0 ? round(($donnees->whereIn('statut', ['Présent', 'En Retard'])->count() / $total) * 100, 1) : 0,
        'taux_retard'     => $total > 0 ? round(($donnees->where('statut', 'En Retard')->count() / $total) * 100, 1) : 0,
        'taux_justifie'   => $total > 0 ? round(($donnees->where('statut', 'Absence Justifiée')->count() / $total) * 100, 1) : 0,
        'taux_injustifie' => $total > 0 ? round(($donnees->where('statut', 'Absent')->count() / $total) * 100, 1) : 0,
        'taux_ferie'      => $total > 0 ? round(($donnees->where('statut', 'Férié')->count() / $total) * 100, 1) : 0,
    ];

    return view('presences.etat_periodique', compact('donnees', 'analyses', 'debut', 'fin'));
}


// Fichier: app/Http/Controllers/PresenceController.php


/**
 * Vue pour que l'agent puisse pointer lui-même
 */

public function monPointage()
{
    $agent = Auth::user()->agent;

    if (!$agent) {
        return back()->with('error', "Aucun profil agent associé à cet utilisateur.");
    }

    $agentId = $agent->id;
    $aujourdhui = Carbon::today();

    // 1. Vérification du jour férié
    // On gère les jours récurrents (ex: 1er Janvier chaque année) et les dates spécifiques
    $ferie = Holiday::where(function($query) use ($aujourdhui) {
        $query->whereDate('holiday_date', $aujourdhui)
              ->orWhere(function($q) use ($aujourdhui) {
                  $q->where('is_recurring', true)
                    ->whereMonth('holiday_date', $aujourdhui->month)
                    ->whereDay('holiday_date', $aujourdhui->day);
              });
    })->first();

    // 2. Si c'est un jour férié, on retourne à la page précédente avec le message d'erreur
    if ($ferie) {
        $dateAffichage = $aujourdhui->format('d/m/Y');
        return back()->with('error', "Enregistrement de présence impossible : le $dateAffichage est un jour férié ($ferie->name).");
    }

    // 3. Si ce n'est pas férié, on cherche le pointage existant
    $presence = Presence::where('agent_id', $agentId)
                        ->whereDate('heure_arrivee', $aujourdhui)
                        ->first();

    return view('presences.self_pointage', compact('presence'));
}


/**
 * Logique de clic unique (Arrivée ou Départ)
 */
public function enregistrerPointage()
{
    $agentId = Auth::user()->agent->id;
    $maintenant = Carbon::now();
    $aujourdhui = Carbon::today();

    // 1. Vérifier si l'agent a déjà un pointage aujourd'hui
    $presence = Presence::where('agent_id', $agentId)
                        ->whereDate('heure_arrivee', $aujourdhui)
                        ->first();

    // CAS 1 : L'agent n'a pas encore pointé (ARRIVÉE)
    if (!$presence) {
        // --- DEBUT LOGIQUE DE RETARD EXISTANTE ---
        $joursFr = ['Monday'=>'Lundi','Tuesday'=>'Mardi','Wednesday'=>'Mercredi','Thursday'=>'Jeudi','Friday'=>'Vendredi','Saturday'=>'Samedi','Sunday'=>'Dimanche'];
        $jourFr = $joursFr[$maintenant->format('l')];
        $horaireFixe = \App\Models\Horaire::where('jour', $jourFr)->first();

        $statut = 'Présent';
        if ($horaireFixe) {
            $minArrivee = ($maintenant->hour * 60) + $maintenant->minute;
            $debutTheorique = Carbon::parse($horaireFixe->heure_debut);
            $minLimite = ($debutTheorique->hour * 60) + $debutTheorique->minute + (int)$horaireFixe->tolerance_retard;
            if ($minArrivee > $minLimite) $statut = 'En Retard';
        }
        // --- FIN LOGIQUE DE RETARD ---

        Presence::create([
            'agent_id' => $agentId,
            'heure_arrivee' => $maintenant,
            'statut' => $statut,
            'notes' => "Pointage automatique (Self-service)"
        ]);


        return redirect()->to(url()->previous())
                        ->with('success', "Pointage enregistré avec succès !");
    }

    // CAS 2 : L'agent a pointé l'arrivée mais pas le départ (DÉPART)
    if ($presence && is_null($presence->heure_depart)) {
        $presence->update([
            'heure_depart' => $maintenant
        ]);
        return back()->with('success', "Départ enregistré à " . $maintenant->format('H:i'));
    }

    // CAS 3 : L'agent a déjà fait ses deux pointages
    return back()->with('error', "Vous avez déjà terminé vos pointages pour aujourd'hui.");
}

public function monHistorique(Request $request)
{
    $agent = Auth::user()->agent;
    $query = Presence::where('agent_id', $agent->id);

    // FILTRE : Par Statut
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    // FILTRE : Par Période (Date Début et Date Fin)
    if ($request->filled('date_debut') && $request->filled('date_fin')) {
        $query->whereBetween('heure_arrivee', [$request->date_debut . ' 00:00:00', $request->date_fin . ' 23:59:59']);
    } elseif ($request->filled('date_debut')) {
        $query->whereDate('heure_arrivee', '>=', $request->date_debut);
    } elseif ($request->filled('date_fin')) {
        $query->whereDate('heure_arrivee', '<=', $request->date_fin);
    }

    $mesPresences = $query->orderBy('heure_arrivee', 'desc')
                          ->paginate(15)
                          ->withQueryString();

    return view('presences.mon_historique', compact('mesPresences'));
}



public function listeFiltree(Request $request)
{
    // 1. Chargement des relations en cascade (Eager Loading)
    // On s'assure de récupérer l'agent, son service et la direction rattachée au service
    $query = Presence::with(['agent.service.direction']);

    // 2. FILTRE : Période (Strictement pour l'année 2026)
    if ($request->filled('date_debut') && $request->filled('date_fin')) {
        $query->whereBetween('heure_arrivee', [
            $request->date_debut . ' 00:00:00',
            $request->date_fin . ' 23:59:59'
        ]);
    }

    // 3. FILTRE : Statut (Présent, Absent, En Retard)
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    // 4. FILTRE : Direction (Via la relation hiérarchique)
    if ($request->filled('direction_id')) {
        $query->whereHas('agent.service', function($q) use ($request) {
            $q->where('direction_id', $request->direction_id);
        });
    }

    // 5. FILTRE : Service
    if ($request->filled('service_id')) {
        $query->whereHas('agent', function($q) use ($request) {
            $q->where('service_id', $request->service_id);
        });
    }

    // 6. TRI ALPHABÉTIQUE ET SÉLECTION SÉCURISÉE
    // On utilise join pour le tri, mais select('presences.*') pour que Laravel
    // puisse reconstruire les relations sans conflit de colonnes 'id'
    $directionTri = $request->get('sort_agent', 'asc');

    $query->join('agents', 'presences.agent_id', '=', 'agents.id')
          ->select('presences.*')
          ->orderBy('agents.last_name', $directionTri);

        // 7. Exécution de la pagination
        // 7. Gestion de l'affichage (Tout ou Pagination)
        if ($request->has('print')) {
            // Si on demande l'impression, on récupère tout (limite haute à 5000 pour sécurité)
            $resultats = $query->take(5000)->get();
        } else {
            // Sinon, pagination classique de 25 par page
            $resultats = $query->paginate(25)->withQueryString();
        }

        // 8. Récupération des listes pour les menus déroulants des filtres
        $directions = \App\Models\Direction::orderBy('name')->get();
    $services = \App\Models\Service::orderBy('name')->get();

    return view('presences.liste_filtree', compact('resultats', 'directions', 'services'));
}



    /**
     * Affiche l'état récapitulatif des présences avec calcul des jours ouvrables.
     */

 public function statsPresences(Request $request)
{
    // 1. Récupération des filtres
    $annee = (int) $request->input('annee', date('Y'));
    $mois = $request->input('mois');
    $joursOuvrables = 0;

    // 2. Calcul des jours ouvrables (Si un mois est sélectionné)
    if (!empty($mois)) {
        $moisNum = (int)$mois;

        $feries = \App\Models\Holiday::whereYear('holiday_date', $annee)
            ->whereMonth('holiday_date', $moisNum)
            ->pluck('holiday_date')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        $dateRef = \Carbon\Carbon::createFromDate($annee, $moisNum, 1);
        $nombreJours = $dateRef->daysInMonth;

        for ($i = 1; $i <= $nombreJours; $i++) {
            $currentDay = \Carbon\Carbon::createFromDate($annee, $moisNum, $i);
            if ($currentDay->isWeekday() && !in_array($currentDay->format('Y-m-d'), $feries)) {
                $joursOuvrables++;
            }
        }
    }

    // 3. Récupération des données pour les STATISTIQUES (Toutes les données du mois)
    $allPresences = \App\Models\Presence::whereYear('heure_arrivee', $annee)
        ->when($mois, fn($q) => $q->whereMonth('heure_arrivee', $mois))
        ->get();

    // 4. Récupération des données pour le TABLEAU DÉTAILLÉ (Paginées)
    $presences = \App\Models\Presence::with('agent')
        ->whereYear('heure_arrivee', $annee)
        ->when($mois, fn($q) => $q->whereMonth('heure_arrivee', $mois))
        ->orderBy('heure_arrivee', 'desc')
        ->paginate(20) // Pagination : 20 par page
        ->withQueryString(); // Garde les filtres lors du changement de page

    // 5. Calcul des statistiques par agent (sur la totalité des données)
    $statsAgents = [];
    $agents = \App\Models\Agent::orderBy('last_name', 'asc')
                ->orderBy('first_name', 'asc')
                ->get();

    foreach ($agents as $agent) {
        $p = $allPresences->where('agent_id', $agent->id);
        $statsAgents[] = [
            'nom' => strtoupper($agent->last_name) . ' ' . $agent->first_name,
            'presents' => $p->where('statut', 'Présent')->count(),
            'retards' => $p->where('statut', 'En Retard')->count(),
            'absents' => $p->where('statut', 'Absent')->count(),
            'justifies' => $p->where('statut', 'Absence Justifiée')->count(),
            'total' => $p->count(),
        ];
    }

    return view('presences.etat', compact(
        'presences',
        'statsAgents',
        'annee',
        'mois',
        'joursOuvrables'
    ));
}


}
