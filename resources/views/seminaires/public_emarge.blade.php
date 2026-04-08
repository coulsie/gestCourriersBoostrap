<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Émargement Numérique - {{ $seminaire->titre }}</title>

    <!-- Correctif des liens CDN (Indispensables pour le style et les icônes) -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    <link rel="stylesheet" href="https://cloudflare.com">
    <!-- Animation pour le message de succès -->
    <link rel="stylesheet" href="https://cloudflare.com"/>

    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .card-emargement { border-radius: 24px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .btn-validate { border-radius: 50px; padding: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s; border: none; }
        .btn-validate:active { transform: scale(0.96); }
        .form-control-lg, .form-select-lg { border-radius: 12px; font-size: 1rem; border: 1px solid #e2e8f0; padding: 12px 15px; }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .bg-gradient-primary { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            <!-- En-tête -->
            <div class="text-center mb-4 mt-2">
                <div class="bg-gradient-primary d-inline-block p-3 rounded-circle text-white mb-3 shadow-lg">
                    <i class="fas fa-user-check fa-2x"></i>
                </div>
                <h2 class="fw-bold h4 mb-1">ÉMARGEMENT</h2>
                <p class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">{{ $seminaire->titre }}</p>
            </div>

            <div class="card card-emargement shadow">
                <div class="card-body p-4 p-md-5">

                    <!-- Gestion des erreurs de validation -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 animate__animated animate__shakeX">
                            <ul class="mb-0 small fw-bold">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Message de Succès (Style Apple/Modern) -->
                    @if(session('success'))
                        <div class="text-center py-4 animate__animated animate__fadeIn">
                            <div class="mb-4">
                                <i class="fas fa-check-circle fa-5x text-success animate__animated animate__bounceIn animate__delay-1s"></i>
                            </div>
                            <h3 class="fw-bold text-dark">Merci !</h3>
                            <p class="text-muted fs-5">{{ session('success') }}</p>
                            <div class="bg-light p-3 rounded-4 mt-4">
                                <small class="text-secondary d-block">Heure d'enregistrement : <strong>{{ date('H:i') }}</strong></small>
                                <small class="text-secondary">Vous pouvez maintenant fermer cette page.</small>
                            </div>
                        </div>
                    @else

                        <form action="{{ route('seminaires.public.valider', $seminaire->uuid) }}" method="POST">
                            @csrf

                            <!-- Recherche rapide -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-primary text-uppercase">1. Trouver votre nom</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3"><i class="fas fa-search"></i></span>
                                    <input type="text" id="nameSearch" class="form-control border-start-0 rounded-end-3" placeholder="Tapez pour filtrer la liste...">
                                </div>
                            </div>

                            <!-- Sélection du nom -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-primary text-uppercase">2. Confirmer votre identité</label>
                                <select name="participant_id" id="participantSelect" class="form-select form-select-lg shadow-sm" required>
                                    <option value="" disabled selected>-- Cliquez pour choisir --</option>
                                    @foreach($participants as $p)
                                        <option value="{{ $p->id }}">
                                            @if($p->agent_id)
                                                {{ $p->nom_agent ?? $p->nom_complet }}
                                            @else
                                                {{ $p->nom_externe }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Téléphone -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-primary text-uppercase">3. Contact (Mobile)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white text-muted"><i class="fas fa-phone-alt"></i></span>
                                    <input type="tel" name="telephone" class="form-control shadow-sm"
                                           placeholder="Ex: 0700000000" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-primary text-uppercase">4. Email (Optionnel)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white text-muted"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control shadow-sm"
                                           placeholder="votre@email.com">
                                </div>
                            </div>

                            <!-- Bouton Validation -->
                            <button type="submit" class="btn btn-primary bg-gradient-primary btn-validate w-100 shadow-lg mt-3">
                                Valider ma présence <i class="fas fa-arrow-right ms-2"></i>
                            </button>

                        </form>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-5 opacity-50">
                <small class="fw-bold">© {{ date('Y') }} - {{ config('app.name') }}</small>
            </div>

        </div>
    </div>
</div>

<!-- Scripts (Correction lien + Filtre de recherche) -->
<script src="https://jsdelivr.net"></script>

<script>
    // Filtre de recherche temps réel
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
