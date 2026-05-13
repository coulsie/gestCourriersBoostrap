<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; line-height: 1.6; background-color: #f4f7fe; margin: 0; padding: 20px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(99, 102, 241, 0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; background-color: #ffffff; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 0.8rem; color: #64748b; border-top: 1px solid #f1f5f9; }
        .details { background: linear-gradient(to right, #f8fafc, #f1f5f9); border-left: 5px solid #6366f1; border-radius: 0 12px 12px 0; padding: 20px; margin: 20px 0; }
        .details p { margin: 0 0 12px 0; font-size: 0.95rem; color: #334155; }
        .details p:last-child { margin-bottom: 0; }
        .badge { background: #fef2f2; color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 900; border: 1px solid #fee2e2; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-link { display: inline-block; background: linear-gradient(90deg, #1e293b 0%, #0284c7 100%); color: #ffffff !important; text-decoration: none; padding: 12px 30px; border-radius: 25px; font-weight: bold; margin-top: 15px; text-transform: uppercase; font-size: 0.8rem; shadow: 0 4px 12px rgba(2, 132, 199, 0.2); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; text-transform: uppercase; letter-spacing: 2px; font-weight: 900; font-size: 1.8rem; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">Convocation Réunion</h1>
        </div>
        <div class="content">
            <p style="font-size: 1.05rem; fw-medium">Bonjour,</p>
            <p>Vous êtes informé(e) qu'une réunion d'envergure a été planifiée dans le système. Veuillez retrouver l'ensemble des détails logistiques ci-dessous :</p>

            <div class="details">
                <p><strong>📌 OBJET :</strong> <span style="color: #4f46e5; font-weight: 700;">{{ strtoupper($reunion->objet) }}</span></p>
                <p><strong>📅 DATE :</strong> <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F Y') }}</span></p>
                <p><strong>🕒 HEURE :</strong> <span class="badge">{{ \Carbon\Carbon::parse($reunion->date_heure)->format('H:i') }}</span></p>
                <p><strong>📍 LIEU :</strong> <span style="font-weight: 600;">{{ $reunion->lieu }}</span></p>
                @if($reunion->ordre_du_jour)
                    <p style="margin-top: 15px; border-top: 1px dashed #cbd5e1; pt-3;">
                        <strong style="color: #6366f1; d-block mb-1">📝 ORDRE DU JOUR :</strong><br>
                        <span style="font-style: italic; color: #475569;">{!! nl2br(e($reunion->ordre_du_jour)) !!}</span>
                    </p>
                @endif
            </div>

            <p>Merci de prendre toutes vos dispositions professionnelles pour assurer votre présence effective à l'heure indiquée.</p>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ route('reunions.hebdo') }}" class="btn-link">Ouvrir le Calendrier de l'Application</a>
            </div>
        </div>
        <div class="footer">
            Ceci est un message automatique sécurisé envoyé par la plateforme <strong>GestCourrier</strong>.<br>
            Direction de la Stratégie, des Etudes et des Statistiques Fiscales — DSESF.
        </div>
    </div>
</body>
</html>
