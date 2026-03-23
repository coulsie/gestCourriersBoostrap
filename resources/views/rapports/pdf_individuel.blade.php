<!DOCTYPE html>
<html>
<head>
    <title>Rapport de Présence</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px; }

        /* Layout des stats */
        .stats-container { margin: 20px 0; width: 100%; }
        .stats-table { width: 100%; border: none; }
        .stats-table td { border: none; vertical-align: middle; }

        /* Le Cercle de Statistiques (CSS pur compatible PDF) */
        .chart-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #e9ecef; /* Fond par défaut */
            display: inline-block;
            border: 1px solid #ddd;
        }

        /* Légende des stats */
        .legend-item { margin-bottom: 5px; font-weight: bold; }
        .dot { height: 10px; width: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .bg-present { background-color: #28a745; }
        .bg-retard { background-color: #ffc107; }
        .bg-absent { background-color: #dc3545; }
        .bg-justifie { background-color: #17a2b8; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fc; color: #4e73df; text-transform: uppercase; font-size: 10px; }

        .footer { margin-top: 30px; text-align: right; font-style: italic; font-size: 10px; }
        .info-agent { margin-bottom: 5px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; color: #4e73df;">BILAN DE PRÉSENCE MENSUEL</h1>
        <h3 style="margin: 5px 0;">Mois : {{ strtoupper($nomMois) }}   </h3>
    </div>

    <div class="info-agent">
        <strong>Agent :</strong> {{ strtoupper($agent->last_name) }} {{ $agent->first_name }} <br>
        <strong>Matricule :</strong> {{ $agent->matricule }} |
        <strong>Service :</strong> {{ $agent->service->libelle ?? 'N/A' }}
    </div>

    <!-- Remplacer la section stats-container par celle-ci -->
    <div class="stats-container" style="margin-top: 20px; padding: 15px; background-color: #f8f9fc; border-radius: 10px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; border: none; padding-right: 20px;">
                    <h4 style="color: #4e73df; margin-top: 0;">RÉSUMÉ DE LA PÉRIODE</h4>

                    @php
                        $total = $agent->presences->count();
                        $nbP = $agent->presences->where('statut', 'Présent')->count();
                        $nbR = $agent->presences->where('statut', 'En Retard')->count();
                        $nbA = $agent->presences->where('statut', 'Absent')->count();
                        $nbJ = $agent->presences->where('statut', 'Absence Justifiée')->count();

                        $p = $total > 0 ? ($nbP / $total) * 100 : 0;
                        $r = $total > 0 ? ($nbR / $total) * 100 : 0;
                        $a = $total > 0 ? ($nbA / $total) * 100 : 0;
                        $j = $total > 0 ? ($nbJ / $total) * 100 : 0;
                    @endphp

                    <!-- Barre de Présence -->
                    <div style="margin-bottom: 10px;">
                        <small>Présents ({{ $nbP }})</small>
                        <div style="width: 100%; background: #ddd; height: 12px; border-radius: 5px;">
                            <div style="width: {{ $p }}%; background: #28a745; height: 12px; border-radius: 5px;"></div>
                        </div>
                    </div>

                    <!-- Barre de Retard -->
                    <div style="margin-bottom: 10px;">
                        <small>Retards ({{ $nbR }})</small>
                        <div style="width: 100%; background: #ddd; height: 12px; border-radius: 5px;">
                            <div style="width: {{ $r }}%; background: #ffc107; height: 12px; border-radius: 5px;"></div>
                        </div>
                    </div>
                </td>
                <td style="width: 50%; border: none;">
                    <!-- Barre d'Absence -->
                    <div style="margin-bottom: 10px;">
                        <small>Absents ({{ $nbA }})</small>
                        <div style="width: 100%; background: #ddd; height: 12px; border-radius: 5px;">
                            <div style="width: {{ $a }}%; background: #dc3545; height: 12px; border-radius: 5px;"></div>
                        </div>
                    </div>

                    <!-- Barre Justifiée -->
                    <div style="margin-bottom: 10px;">
                        <small>Justifiés ({{ $nbJ }})</small>
                        <div style="width: 100%; background: #ddd; height: 12px; border-radius: 5px;">
                            <div style="width: {{ $j }}%; background: #17a2b8; height: 12px; border-radius: 5px;"></div>
                        </div>
                    </div>

                    <div style="margin-top: 15px; font-weight: bold; text-align: center; border: 1px dashed #4e73df; padding: 5px;">
                        TOTAL : {{ $total }} JOURS POINTÉS
                    </div>
                </td>
            </tr>
        </table>
    </div>


    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th style="text-align: center;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agent->presences->sortBy('heure_arrivee') as $presence)
            <tr>
                <td>{{ \Carbon\Carbon::parse($presence->heure_arrivee)->locale('fr')->translatedFormat('d F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($presence->heure_arrivee)->format('H:i') }}</td>
                <td>{{ $presence->heure_depart ? \Carbon\Carbon::parse($presence->heure_depart)->format('H:i') : '--:--' }}</td>
                <td style="text-align: center; font-weight: bold; color: {{ $presence->statut == 'Présent' ? '#28a745' : ($presence->statut == 'En Retard' ? '#f39c12' : '#dc3545') }};">
                    {{ $presence->statut }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Généré informatiquement le {{ date('d/m/Y à H:i') }}</p>
        <p>Signature et Cachet : __________________________</p>
    </div>
</body>
</html>
