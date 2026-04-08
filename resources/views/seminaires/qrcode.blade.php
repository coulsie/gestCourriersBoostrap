@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 text-center">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden shadow-print-none">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 text-uppercase fw-bold letter-spacing-1">
                        <i class="fas fa-qrcode me-2"></i>Émargement Numérique
                    </h5>
                </div>

                <div class="card-body p-5">
                    <h2 class="fw-bold mb-1 text-primary">{{ $seminaire->titre }}</h2>
                    <p class="text-muted mb-4">
                        <i class="far fa-calendar-alt me-1"></i>
                        Session du {{ \Carbon\Carbon::parse($seminaire->date_debut)->format('d/m/Y') }}
                    </p>

                    <!-- Génération du QR Code avec vérification de l'UUID -->
                    <div class="d-inline-block p-4 bg-white border rounded-4 shadow-sm mb-4">
                        @if($seminaire->uuid)
                            {!! QrCode::size(320)
                                ->style('round')
                                ->eye('square')
                                ->color(0, 0, 0)
                                ->margin(1)
                                ->generate(route('seminaires.public.scan', $seminaire->uuid))
                            !!}
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                UUID manquant. Veuillez rafraîchir ou régénérer l'identifiant.
                            </div>
                        @endif
                    </div>

                    <div class="alert alert-info border-0 rounded-3 py-3">
                        <h5 class="fw-bold mb-1"><i class="fas fa-mobile-alt me-2"></i>Comment émarger ?</h5>
                        <p class="mb-0 small">Ouvrez l'appareil photo de votre smartphone et scannez le code ci-dessus pour accéder au formulaire de présence.</p>
                    </div>

                    <!-- Affichage de l'URL en secours -->
                    @if($seminaire->uuid)
                        <div class="mt-3">
                            <code class="text-muted small">{{ route('seminaires.public.scan', $seminaire->uuid) }}</code>
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-light py-3 d-print-none">
                    <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-print me-2"></i>Imprimer pour la salle
                    </button>
                </div>
            </div>

            <div class="mt-4 d-print-none">
                <a href="{{ route('seminaires.etat-global') }}" class="btn btn-link text-decoration-none text-muted">
                    <i class="fas fa-arrow-left me-1"></i> Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .letter-spacing-1 { letter-spacing: 1px; }

    @media print {
        /* Masquer tout sauf le QR Code et les infos du séminaire */
        .d-print-none, nav, .sidebar, .btn, .mt-4, header, footer {
            display: none !important;
        }
        body { background-color: white !important; }
        .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .shadow-print-none { box-shadow: none !important; }
        .card-header { background-color: white !important; color: black !important; border-bottom: 2px solid #000 !important; }
        .text-primary { color: black !important; }
    }
</style>
@endsection
