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
        $periode = $request->get('periode', Carbon::now()->format('Y-m'));
        $date = Carbon::parse($periode);
        $mois = $date->month;
        $annee = $date->year;

        // 2. Récupérer les agents avec relations filtrées par mois/année
        $agents = Agent::with(['service',
            'presences' => function($query) use ($mois, $annee) {
                $query->whereMonth('heure_arrivee', $mois)->whereYear('heure_arrivee', $annee);
            },
            'absences' => function($query) use ($mois, $annee) {
                $query->where(function($q) use ($mois, $annee) {
                      $q->whereMonth('date_debut', $mois)->whereYear('date_debut', $annee)
                        ->orWhereMonth('date_fin', $mois)->whereYear('date_fin', $annee);
                  });
            }
        ])->orderBy('last_name', 'asc')->get();

        // 3. Calculer les jours ouvrés réels du mois
        $joursOuvres = 0;
        $tempDate = $date->copy()->startOfMonth();
        while ($tempDate <= $date->copy()->endOfMonth()) {
            if (!$tempDate->isWeekend()) $joursOuvres++;
            $tempDate->addDay();
        }

        // 4. Formater les données pour Blade & DataTables
        $donneesRapport = $agents->map(function($agent) use ($joursOuvres) {
            $nbPresents = $agent->presences->where('statut', 'Présent')->count();
            $nbRetards = $agent->presences->where('statut', 'En Retard')->count();

            // FILTRE CRITIQUE : Seules les absences avec approuvee == 2 sont "Justifiées"
            $nbAbsencesJustifiees = $agent->absences->where('approuvee', 2)->sum(function($abs) {
                return Carbon::parse($abs->date_debut)->diffInDays(Carbon::parse($abs->date_fin)) + 1;
            });

            // Calcul par déduction pour les "Injustifiées"
            $totalPointes = $nbPresents + $nbRetards + $nbAbsencesJustifiees;
            $nbAbsencesInjustifiees = max(0, $joursOuvres - $totalPointes);

            // Taux basé sur les jours ouvrés
            $taux = $joursOuvres > 0 ? (($nbPresents + $nbRetards) / $joursOuvres) * 100 : 0;

            return (object)[
                'agent' => $agent,
                'presents' => $nbPresents,
                'retards' => $nbRetards,
                'absences_justifiees' => $nbAbsencesJustifiees, // Pour la colonne Justifiées
                'absences' => $nbAbsencesInjustifiees,           // Pour la colonne Injustifiées
                'taux' => round($taux, 1),
                'total_jours' => $joursOuvres
            ];
        });

        return view('rapports.mensuel', [
            'rapports' => $donneesRapport,
            'periode' => $periode,
            'annee' => $annee,
            'mois' => $mois,
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

    public function syntheseMensuelle(Request $request)
    {
        $periode = $request->input('periode', date('Y-m'));
        $debut = Carbon::parse($periode)->startOfMonth();
        $fin = Carbon::parse($periode)->endOfMonth();

        $donnees = Presence::with('agent.service')
            ->whereBetween('created_at', [$debut, $fin])
            ->get();

        return view('rapports.synthesemensuelle', compact('donnees', 'debut', 'fin'));
    }
}
