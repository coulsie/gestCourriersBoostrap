<!DOCTYPE html>
<html>
<head>
    <title>Rapport de Présence</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4e73df; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fc; color: #4e73df; }
        .footer { margin-top: 50px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BILAN DE PRÉSENCE MENSUEL</h1>
        <h3>Mois : {{ strtoupper($nomMois) }}</h3>
    </div>

    <p><strong>Agent :</strong> {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</p>
    <p><strong>Matricule :</strong> {{ $agent->matricule }}</p>
    <p><strong>Service :</strong> {{ $agent->service->libelle ?? 'N/A' }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agent->presences as $presence)
            <tr>
                <td>{{ \Carbon\Carbon::parse($presence->heure_arrivee)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($presence->heure_arrivee)->format('H:i') }}</td>
                <td>{{ $presence->heure_depart ? \Carbon\Carbon::parse($presence->heure_depart)->format('H:i') : '--:--' }}</td>
                <td>{{ $presence->statut }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Document généré le {{ date('d/m/Y à H:i') }}</p>
        <p>Signature de la Direction : ____________________</p>
    </div>
</body>
</html>
