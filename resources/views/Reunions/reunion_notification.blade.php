<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
        .header { background: linear-gradient(45deg, #6366f1, #818cf8); color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #ffffff; }
        .footer { background-color: #f8fafc; padding: 15px; text-align: center; font-size: 0.8rem; color: #64748b; }
        .details { background-color: #f1f5f9; border-radius: 6px; padding: 15px; margin: 15px 0; }
        .badge { background-color: #ef4444; color: white; padding: 3px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;">Convocation Réunion</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous êtes informé(e) qu'une réunion a été programmée/mise à jour. Voici les détails importants :</p>

            <div class="details">
                <p><strong>📌 OBJET :</strong> {{ $reunion->objet }}</p>
                <p><strong>📅 DATE :</strong> {{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F Y') }}</p>
                <p><strong>🕒 HEURE :</strong> {{ \Carbon\Carbon::parse($reunion->date_heure)->format('H:i') }}</p>
                <p><strong>📍 LIEU :</strong> {{ $reunion->lieu }}</p>
                @if($reunion->ordre_du_jour)
                    <p><strong>📝 ORDRE DU JOUR :</strong><br>{{ $reunion->ordre_du_jour }}</p>
                @endif
            </div>

            <p>Merci de prendre vos dispositions pour être présent(e) à l'heure indiquée.</p>
        </div>
        <div class="footer">
            Ceci est un message automatique envoyé par <strong>GestCourrier</strong>.<br>
            Veuillez ne pas répondre à cet email directement.
        </div>
    </div>
</body>
</html>
