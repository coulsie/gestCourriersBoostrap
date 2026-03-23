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

    // 2. Récupérer les agents avec leurs présences filtrées sur le mois
    $agents = \App\Models\Agent::with(['service', 'presences' => function($query) use ($mois, $annee) {
        $query->whereMonth('heure_arrivee', $mois)
              ->whereYear('heure_arrivee', $annee);
    }])->orderBy('last_name', 'asc')->get();

    // 3. Calculer les jours ouvrables (pour le taux et le badge uniquement)
    $joursOuvrablesMois = 0;
    $tempDate = $date->copy()->startOfMonth();
    $finMois = $date->copy()->endOfMonth();
    $feries = \App\Models\Holiday::whereYear('holiday_date', $annee)
                ->whereMonth('holiday_date', $mois)
                ->pluck('holiday_date')->toArray();

    while ($tempDate <= $finMois) {
        if (!$tempDate->isWeekend() && !in_array($tempDate->format('Y-m-d'), $feries)) {
            $joursOuvrablesMois++;
        }
        $tempDate->addDay();
    }

    // 4. Formater les données en suivant la logique du PDF
    $donneesRapport = $agents->map(function($agent) use ($joursOuvrablesMois) {
        // Logique identique au PDF
        $presences = $agent->presences;

        $nbP = $presences->where('statut', 'Présent')->count();
        $nbR = $presences->where('statut', 'En Retard')->count();
        $nbA = $presences->where('statut', 'Absent')->count();
        $nbJ = $presences->where('statut', 'Absence Justifiée')->count();

        // Le total des jours pointés dans la base pour cet agent
        $totalPointes = $presences->count();

        // Calcul du taux : (Présents + Retards) / Jours Ouvrables du mois
        // Note: On divise par joursOuvrablesMois pour avoir un taux réel par rapport au calendrier
        $taux = $joursOuvrablesMois > 0 ? (($nbP + $nbR) / $joursOuvrablesMois) * 100 : 0;

        return (object)[
            'agent' => $agent,
            'presents' => $nbP,
            'retards' => $nbR,
            'absences' => $nbA, // Injustifiées
            'absences_justifiees' => $nbJ,
            'taux' => round($taux, 1),
            'total_pointes' => $totalPointes
        ];
    });

    return view('rapports.mensuel', [
        'rapports' => $donneesRapport,
        'periode' => $periode,
        'annee' => $annee,
        'mois' => $mois,
        'joursOuvrables' => $joursOuvrablesMois,
        'nomMois' => $date->translatedFormat('F Y')
    ]);
}



    public function exportPDF($agent_id, $periode)
    {
        $date = Carbon::parse($periode);
        $agent = Agent::with(['service', 'presences' => function($q) use ($date) {
            $q->whereMonth('heure_arrivee', $date->month)
            ->whereYear('heure_arrivee', $date->year);
        }])->findOrFail($agent_id);

        $nomMois = $date->translatedFormat('F Y');

        // 1. Charger la vue
        $pdf = Pdf::loadView('rapports.pdf_individuel', [
            'agent'   => $agent,
            'nomMois' => $nomMois,
            'date'    => $date,
            'annee'   => $date->year
        ]);

        // 2. ACTIVER LE CHARGEMENT DES IMAGES (C'est cette ligne qui règle le problème)
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);

        return $pdf->download("Rapport_{$agent->last_name}_{$periode}.pdf");
    }



}
