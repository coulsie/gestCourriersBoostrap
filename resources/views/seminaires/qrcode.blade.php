@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 text-uppercase fw-bold">Scan pour émargement</h5>
                </div>
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-1 text-primary">{{ $seminaire->titre }}</h3>
                    <p class="text-muted mb-4 small">
                        Session du {{ \Carbon\Carbon::parse($seminaire->date_debut)->format('d/m/Y') }}
                    </p>

                    <!-- Génération du QR Code -->
                    <div class="d-inline-block p-4 bg-white border rounded-4 shadow-sm mb-4">
                        {!! QrCode::size(300)
                            ->style('round')
                            ->eye('square')
                            ->color(0, 0, 0)
                            ->margin(1)
                            ->generate(route('seminaires.public.scan', $seminaire->id))                        !!}
                    </div>

                    <div class="alert alert-light border-0">
                        <i class="fas fa-mobile-alt me-2 text-primary"></i>
                        Ouvrez votre appareil photo pour scanner le code et valider votre présence.
                    </div>
                </div>
                <div class="card-footer bg-light py-3">
                    <button onclick="window.print()" class="btn btn-sm btn-secondary rounded-pill px-4">
                        <i class="fas fa-print me-2"></i> Imprimer le code
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('seminaires.report') }}" class="text-decoration-none text-muted small">
                    <i class="fas fa-arrow-left me-1"></i> Retour à l'état global
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .mt-4, nav, .sidebar { display: none !important; }
        .container { margin-top: 0 !important; }
        .card { shadow: none !important; border: 1px solid #eee !important; }
    }
</style>
@endsection
