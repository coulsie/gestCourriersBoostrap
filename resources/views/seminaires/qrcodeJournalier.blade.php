@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 p-5">
                <h2 class="fw-bold text-primary mb-2">{{ $seminaire->titre }}</h2>
                <h4 class="text-muted mb-4 text-uppercase fw-light">Émargement Journalier</h4>

                <div class="alert alert-warning border-0 rounded-pill d-inline-block px-4 mb-4">
                    <i class="fas fa-calendar-day me-2"></i>
                    Aujourd'hui : <strong>{{ now()->translatedFormat('l d F Y') }}</strong>
                </div>

                <!-- AFFICHAGE DU QR CODE -->
                <div class="my-4 p-4 d-inline-block bg-white shadow-sm rounded-4 border">
                    {!! $qrCode !!}
                </div>

                <div class="mt-4">
                    <p class="lead fw-bold mb-1">Scannez ce code pour valider votre présence</p>
                    <p class="text-muted small">Ouvrez votre appareil photo ou une application de scan QR Code</p>
                </div>

                <div class="mt-4 no-print">
                    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 me-2">
                        <i class="fas fa-print me-2"></i>Imprimer le code
                    </button>
                    <a href="{{ route('seminaires.emargement', $seminaire->id) }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-list-check me-2"></i>Voir les présences
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print, nav, footer { display: none !important; }
        .container { padding: 0 !important; }
        .card { shadow: none !important; border: none !important; }
    }
</style>
@endsection
