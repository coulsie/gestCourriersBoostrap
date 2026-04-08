<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Émargement Numérique - {{ $seminaire->titre }}</title>

    <!-- Corrections des liens CDN (Indispensables pour le style et les icônes) -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    <link rel="stylesheet" href="https://cloudflare.com">

    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-emargement { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-validate { border-radius: 50px; padding: 15px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s; }
        .btn-validate:active { transform: scale(0.98); }
        .form-control-lg, .form-select-lg { border-radius: 12px; font-size: 1rem; border: 1px solid #dee2e6; }
        .form-control:focus { border-color: #0d6efd; box-shadow: none; }
        .search-container { position: relative; }
        .search-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #adb5bd; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            <!-- En-tête -->
            <div class="text-center mb-4">
                <div class="bg-primary d-inline-block p-3 rounded-circle text-white mb-3 shadow">
                    <i class="fas fa-user-check fa-2x"></i>
                </div>
                <h2 class="fw-bold h4">ÉMARGEMENT</h2>
                <p class="text-muted small text-uppercase">{{ $seminaire->titre }}</p>
            </div>

            <div class="card card-emargement shadow">
                <div class="card-body p-4">

                    <!-- Gestion des erreurs de validation (Nouveau) -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-3 text-center py-4">
                            <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"></i>
                            <h5 class="fw-bold">{{ session('success') }}</h5>
                            <p class="mb-0 small">Votre présence a été enregistrée à {{ date('H:i') }}.</p>
                        </div>
                    @else

                        <form action="{{ route('seminaires.public.valider', $seminaire->uuid) }}" method="POST">
                            @csrf

                            <!-- Recherche rapide (Nouveau : Très utile sur mobile) -->
                            <div class="mb-3 search-container">
                                <label class="form-label fw-bold small text-secondary">TROUVER MON NOM</label>
                                <input type="text" id="nameSearch" class="form-control mb-2" placeholder="Tapez votre nom pour filtrer...">
                            </div>

                            <!-- Sélection du nom -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">
                                    <i class="fas fa-list me-1"></i> CONFIRMER VOTRE IDENTITÉ
                                </label>
                                <select name="participant_id" id="participantSelect" class="form-select form-select-lg shadow-sm" required>
                                    <option value="" disabled selected>-- Choisir dans la liste --</option>
                                    @foreach($participants as $p)
                                        <option value="{{ $p->id }}">
                                            @if($p->agent_id)
                                                {{ $p->nom_agent ?? 'Agent '.$p->agent_id }}
                                            @else
                                                {{ $p->nom_externe }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Téléphone -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">
                                    <i class="fas fa-phone me-1"></i> NUMÉRO DE TÉLÉPHONE
                                </label>
                                <input type="tel" name="telephone" class="form-control form-control-lg shadow-sm"
                                       placeholder="Ex: 0700000000" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">
                                    <i class="fas fa-envelope me-1"></i> EMAIL (OPTIONNEL)
                                </label>
                                <input type="email" name="email" class="form-control form-control-lg shadow-sm"
                                       placeholder="nom@exemple.com">
                            </div>

                            <!-- Bouton Validation -->
                            <button type="submit" class="btn btn-primary btn-validate w-100 shadow mt-2">
                                Valider ma présence
                            </button>

                        </form>
                    @endif
                </div>
            </div>

            <!-- Footer discret -->
            <div class="text-center mt-5 opacity-50">
                <small>© {{ date('Y') }} - {{ config('app.name') }}</small>
            </div>

        </div>
    </div>
</div>

<!-- Scripts (Correction lien + Filtre de recherche) -->
<script src="https://jsdelivr.net"></script>

<script>
    // Petit script pour filtrer la liste déroulante en tapant son nom
    document.getElementById('nameSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let select = document.getElementById('participantSelect');
        let options = select.options;

        for (let i = 1; i < options.length; i++) {
            let text = options[i].text.toLowerCase();
            options[i].style.display = text.includes(filter) ? "" : "none";
        }
    });
</script>

</body>
</html>
