<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Courrier Signé - {{ $courrier->reference }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; color: #666; text-transform: uppercase; font-size: 10px; }
        .content { margin-top: 5px; font-size: 14px; }

        /* Style du Bordereau de Signature */
        .bordereau {
            margin-top: 50px;
            border: 1px solid #0d6efd;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        .signature-img { max-height: 100px; margin-top: 10px; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>COURRIER OFFICIEL</h1>
        <p>Référence : <strong>{{ $courrier->reference }}</strong></p>
    </div>

    <div class="section">
        <div class="label">Objet :</div>
        <div class="content"><strong>{{ $courrier->objet }}</strong></div>
    </div>

    <div class="section">
        <div class="label">Description :</div>
        <div class="content" style="white-space: pre-line;">{{ $courrier->description }}</div>
    </div>

    {{-- PAGE DE SIGNATURE (Bordereau) --}}
    <div class="bordereau">
        <h2 style="color: #0d6efd; margin-top: 0;">BORDEREAU DE CERTIFICATION</h2>
        <table width="100%">
            <tr>
                <td width="60%">
                    <p><strong>Signataire :</strong> {{ $courrier->signataire->name }}</p>
                    <p><strong>Date de signature :</strong> {{ \Carbon\Carbon::parse($courrier->signed_at)->format('d/m/Y à H:i') }}</p>
                    <p><strong>Statut :</strong> <span style="color: green; font-weight: bold;">DOCUMENT SIGNÉ NUMÉRIQUEMENT</span></p>
                </td>
                <td width="40%" style="text-align: center;">
                    <div class="label">Empreinte de signature</div>
                    @if($courrier->signataire->signature_path)
                        {{-- Note: DomPDF préfère les chemins absolus avec public_path() --}}
                        
                        <img src="{{ public_path('signatures/' . $courrier->signataire->signature_path) }}" width="150">


                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement par le système de gestion des courriers le {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
