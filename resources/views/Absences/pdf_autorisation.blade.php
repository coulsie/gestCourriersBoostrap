<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Autorisation d'Absence - {{ $agent->last_name }}</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: "Times New Roman", serif; font-size: 12pt; line-height: 1.6; color: #000; }

        /* En-tête */
        .header-table { width: 100%; border: none; margin-bottom: 50px; }
        .inst-title { font-weight: bold; text-transform: uppercase; font-size: 11pt; margin-bottom: 0; }
        .inst-sub { font-size: 9pt; font-weight: bold; text-transform: uppercase; margin-top: 5px; }
        .republique { font-weight: bold; text-transform: uppercase; font-size: 11pt; }
        .devise { font-style: italic; font-size: 9pt; }
        .separator { font-size: 10pt; margin: 5px 0; }

        /* Titre Document */
        .doc-title { text-align: center; margin: 40px 0; }
        .doc-title h2 {
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Corps */
        .content { margin-top: 30px; text-align: justify; }
        .details-box { margin: 30px 0 30px 40px; }
        .label { font-weight: bold; width: 200px; display: inline-block; }
        .value { font-weight: bold; text-transform: uppercase; }

        /* Signatures */
        .signature-table { width: 100%; margin-top: 60px; border: none; }
        .signature-title { font-weight: bold; text-decoration: underline; font-size: 10pt; }
        .signature-space { height: 100px; }
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
                <div style="margin-top: 15px; font-weight: bold;">Abidjan, le {{ now()->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- Titre -->
    <div class="doc-title">
        <h2>AUTORISATION D'ABSENCE</h2>
    </div>

    <!-- Corps -->
    <div class="content">
        <p>Je soussigné, Monsieur/Madame le Responsable du Service en charge de la Gestion du Personnel, autorise par la présente l'agent ci-dessous désigné :</p>

        <div class="details-box">
            <div style="margin-bottom: 10px;">
                <span class="label">NOM & PRÉNOMS :</span>
                <span class="value">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</span>
            </div>
            <div style="margin-bottom: 10px;">
                <span class="label">MATRICULE :</span>
                <span class="value">{{ $absence->agent->matricule ?? 'N/A' }}</span>
            </div>
            <div style="margin-bottom: 10px;">
                <span class="label">FONCTION :</span>
                <span class="value">{{ $agent->fonction ?? 'Agent' }}</span>
            </div>
            <div style="margin-bottom: 10px;">
                <span class="label">MOTIF DE L'ABSENCE :</span>
                <span class="value">{{ strtoupper($absence->type->nom_type) }}</span>
            </div>
        </div>

        <p>
            à s'absenter de son poste de travail pour la période allant du
            <strong>{{ \Carbon\Carbon::parse($absence->date_debut)->format('d/m/Y') }}</strong> au
            <strong>{{ \Carbon\Carbon::parse($absence->date_fin)->format('d/m/Y') }}</strong> inclus.
        </p>

        <p style="margin-top: 20px;">
            L'intéressé(e) est tenu(e) de reprendre son service dès l'expiration de la présente autorisation.
        </p>
    </div>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div class="signature-title">L'Agent</div>
                <div class="signature-space"></div>
                <div style="font-size: 9pt; font-style: italic;">(Signature)</div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div class="signature-title">Le Responsable Hiérarchique</div>
                <div class="signature-space"></div>
                <div style="font-size: 9pt; font-style: italic;">(Signature et Cachet)</div>
            </td>
        </tr>
    </table>

</body>
</html>
