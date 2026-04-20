<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.6; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px 20px; text-align: center; }
        .icon { font-size: 40px; margin-bottom: 10px; }
        .content { padding: 30px; }
        .meeting-box { background-color: #f1f5f9; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .meeting-title { color: #065f46; font-size: 1.1rem; font-weight: bold; margin-bottom: 10px; }
        .file-list { list-style: none; padding: 0; }
        .file-item { display: flex; align-items: center; margin-bottom: 8px; font-weight: 500; color: #059669; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 0.85rem; color: #64748b; border-top: 1px solid #e2e8f0; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <div class="icon">✅</div>
            <h1 style="margin:0; font-size: 1.5rem;">Réunion Clôturée</h1>
        </div>

        <!-- Contenu -->
        <div class="content">
            <p>Bonjour,</p>
            <p>La réunion mentionnée ci-dessous est désormais terminée. Le compte-rendu ainsi que la liste de présence ont été validés et archivés.</p>

            <div class="meeting-box">
                <div class="meeting-title">{{ $meeting->objet }}</div>
                <div style="font-size: 0.9rem;">
                    <strong>📅 Date :</strong> {{ \Carbon\Carbon::parse($meeting->date_heure)->translatedFormat('l d F Y') }}<br>
                    <strong>📍 Lieu :</strong> {{ $meeting->lieu }}
                </div>
            </div>

            <p><strong>📂 Documents joints à ce courriel :</strong></p>
            <ul class="file-list">
                @if($meeting->report_file)
                    <li class="file-item">📄 Compte-rendu de réunion (PV)</li>
                @endif
                @if($meeting->presence_file)
                    <li class="file-item">📝 Liste des présences signée</li>
                @endif
            </ul>

            <p style="margin-top: 25px;">Vous pouvez consulter ces documents directement en pièces jointes de ce message pour votre archivage personnel.</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            Cet email a été généré automatiquement par <strong>GestCourrier</strong>.<br>
            Direction des Études, des Statistiques et du Suivi-Évaluation (DSESF).
        </div>
    </div>
</body>
</html>
