<?php

namespace App\Http\Controllers;



use App\Models\Agent;
use App\Models\Presence;
use App\Models\Absence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;



class RapportController extends Controller
{
     public function mensuel(Request $request)
{
    // 1. Définir la période
    $periode = $request->get('periode', \Carbon\Carbon::now()->format('Y-m'));
    $date = \Carbon\Carbon::parse($periode);
    $mois = $date->month;
    $annee = $date->year;

    // 2. Récupérer les jours fériés du mois (format Y-m-d)
    $feries = \App\Models\Holiday::whereYear('holiday_date', $annee)
                    ->whereMonth('holiday_date', $mois)
                    ->pluck('holiday_date')
                    ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
                    ->toArray();

    // 3. Calculer les jours ouvrables réels (Hors weekends ET hors fériés)
    $joursOuvrablesMois = 0;
    $tempDate = $date->copy()->startOfMonth();
    $finMois = $date->copy()->endOfMonth();

    while ($tempDate <= $finMois) {
        // Un jour est ouvrable s'il n'est pas un weekend ET n'est pas un jour férié
        if (!$tempDate->isWeekend() && !in_array($tempDate->format('Y-m-d'), $feries)) {
            $joursOuvrablesMois++;
        }
        $tempDate->addDay();
    }

    // 4. Récupérer les agents avec relations filtrées
    $agents = \App\Models\Agent::with(['service',
        'presences' => function($query) use ($mois, $annee) {
            $query->whereMonth('heure_arrivee', $mois)->whereYear('heure_arrivee', $annee);
        },
        'absences' => function($query) use ($mois, $annee) {
            $query->where('approuvee', 2) // Uniquement les justifiées (approuvées)
                  ->where(function($q) use ($mois, $annee) {
                      $q->whereMonth('date_debut', $mois)->whereYear('date_debut', $annee)
                        ->orWhereMonth('date_fin', $mois)->whereYear('date_fin', $annee);
                  });
        }
    ])->orderBy('last_name', 'asc')->get();

    // 5. Formater les données
    $donneesRapport = $agents->map(function($agent) use ($joursOuvrablesMois) {
        $nbPresents = $agent->presences->where('statut', 'Présent')->count();
        $nbRetards = $agent->presences->where('statut', 'En Retard')->count();

        // Calcul des jours d'absence justifiée (approuvée == 2)
        $nbAbsencesJustifiees = $agent->absences->sum(function($abs) {
            $debut = \Carbon\Carbon::parse($abs->date_debut);
            $fin = \Carbon\Carbon::parse($abs->date_fin);
            return $debut->diffInDays($fin) + 1;
        });

        // Calcul strict par déduction pour que la somme soit égale aux jours ouvrables
        // Somme = Présents + Retards + Justifiés + Injustifiés
        $totalActivite = $nbPresents + $nbRetards + $nbAbsencesJustifiees;
        $nbAbsencesInjustifiees = max(0, $joursOuvrablesMois - $totalActivite);

        // Taux d'assiduité (Présences / Capacité réelle)
        $taux = $joursOuvrablesMois > 0 ? (($nbPresents + $nbRetards) / $joursOuvrablesMois) * 100 : 0;

        return (object)[
            'agent' => $agent,
            'presents' => $nbPresents,
            'retards' => $nbRetards,
            'absences_justifiees' => $nbAbsencesJustifiees,
            'absences' => $nbAbsencesInjustifiees, // Injustifiées
            'taux' => round($taux, 1),
            'total_jours' => $joursOuvrablesMois
        ];
    });

    return view('rapports.mensuel', [
        'rapports' => $donneesRapport,
        'periode' => $periode,
        'annee' => $annee,
        'mois' => $mois,
        'joursOuvrables' => $joursOuvrablesMois, // Variable envoyée pour le badge
        'nomMois' => $date->translatedFormat('F Y')
    ]);
}


    public function exportPDF($agent_id, $periode)
    {
        $date = Carbon::parse($periode);
        $agent = Agent::with(['service', 'presences' => function($q) use ($date) {
            $q->whereMonth('heure_arrivee', $date->month)->whereYear('heure_arrivee', $date->year);
        }])->findOrFail($agent_id);

        $nomMois = $date->translatedFormat('F Y');
        $pdf = Pdf::loadView('rapports.pdf_individuel', compact('agent', 'nomMois', 'date'));

        return $pdf->download("Rapport_{$agent->last_name}_{$periode}.pdf");
    }




}
