<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Autorisation d'Absence - {{ $absence->agent->last_name }}</title>
    <style>
        @page { margin: 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; }

        /* Correction Header Table */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .inst-title { font-weight: bold; font-size: 14px; }
        .inst-sub { font-weight: bold; font-size: 11px; }
        .republique { font-weight: bold; font-size: 13px; }
        .devise { font-style: italic; font-size: 11px; }
        .separator { margin: 5px 0; }

        /* LE TITRE ENFIN CENTRÉ */
        .title {
            width: 100%;
            text-align: center;
            margin: 40px 0 20px 0;
            padding: 15px 0;
            border-top: 2px solid #0056b3;
            border-bottom: 2px solid #0056b3;
            background-color: #f8f9fa;
            color: #0056b3;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .section { margin-bottom: 20px; line-height: 1.6; }

        /* Signature et Footer */
        .footer { margin-top: 50px; width: 100%; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-img { max-width: 180px; max-height: 100px; margin-top: 10px; }
    </style>
</head>
<body>
    <!-- En-tête -->
    <table class="header-table">
        <tr>
            <td style="width: 60%; text-align: center; vertical-align: top;">
                <div class="inst-title">DIRECTION GÉNÉRALE DES IMPÔTS</div>
                <div class="separator">------------------</div>
                <div class="inst-sub">DIRECTION DE LA STRATÉGIE, DES ÉTUDES<br>ET DES STATISTIQUES FISCALES</div>
                <div class="separator">------------------</div>
                <div class="inst-sub" style="font-weight: normal;">SERVICE EN CHARGE DE LA GESTION DU PERSONNEL</div>
            </td>
            <td style="width: 40%; text-align: center; vertical-align: top;">
                <div class="republique">RÉPUBLIQUE DE CÔTE D'IVOIRE</div>
                <div class="devise">Union - Discipline - Travail</div>
                <div class="separator">------------------</div>
                <div style="margin-top: 15px; font-weight: bold;">Abidjan, le {{ date('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- TITRE CENTRÉ -->
    <div class="title">AUTORISATION D'ABSENCE</div>

    <div class="section" style="margin-top: 30px;">
        Je soussigné, <strong>{{ optional($absence->agent->service->chef)->first_name ?? 'Le Responsable' }} {{ optional($absence->agent->service->chef)->last_name ?? '' }}</strong>,<br>
        Chef du Service <strong>{{ $absence->agent->service->name }}</strong>, autorise :<br><br>

        M./Mme : <strong>{{ $absence->agent->first_name }} {{ $absence->agent->last_name }}</strong><br>
        Matricule : <strong>{{ $absence->agent->matricule }}</strong><br>
        Emploi/Grade : <strong>{{ $absence->agent->Emploi }} / {{ $absence->agent->Grade }}</strong><br><br>

        À s'absenter pour une durée de <strong>{{ \Carbon\Carbon::parse($absence->date_debut)->diffInDays($absence->date_fin) + 1 }} jour(s)</strong><br>
        Période du : <strong>{{ \Carbon\Carbon::parse($absence->date_debut)->format('d/m/Y') }}</strong> au <strong>{{ \Carbon\Carbon::parse($absence->date_fin)->format('d/m/Y') }}</strong>.
    </div>

    <div class="section">
        <strong>Motif / Commentaire :</strong><br>
        {{ $absence->comment_absence_chef ?? 'Autorisé pour convenances personnelles.' }}
    </div>

    <div class="footer">
        <div style="float: left; width: 40%;">
            Fait à Abidjan, le {{ date('d/m/Y') }}
        </div>
        <div class="signature-box">
            <strong>P. Le Chef de Service</strong><br>

            @php
                $signaturePath = optional($absence->agent->service->chef->user)->signature_path;
                $fullPath = storage_path('app/public/' . $signaturePath);
            @endphp

            @if($signaturePath && file_exists($fullPath))
                {{-- Conversion en Base64 pour garantir l'affichage --}}
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($fullPath)) }}" class="signature-img">
            @else
                <div style="margin-top: 40px; border: 1px dashed #ccc; padding: 10px;">
                    (Signature et Cachet)
                </div>
            @endif
            <br>
            <strong>{{ optional($absence->agent->service->chef)->first_name }} {{ optional($absence->agent->service->chef)->last_name }}</strong>
        </div>
    </div>
</body>
</html>
