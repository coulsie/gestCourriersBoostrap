@extends('layouts.app')

@section('content')
<!-- Import des icônes Bootstrap -->
<link rel="stylesheet" href="https://jsdelivr.net">

<div class="container py-5">
    <!-- Barre d'outils supérieure -->
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <a href="{{ route('activities.index') }}" class="btn btn-light rounded-pill shadow-sm px-4 fw-bold text-secondary transition-hover">
            <i class="bi bi-arrow-left-circle-fill me-2 text-indigo"></i> Journal
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-warning rounded-pill shadow-sm px-4 fw-bold text-white border-0" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="bi bi-pencil-square me-1"></i> Modifier
            </a>
        </div>
    </div>

    <!-- Carte Principale Éclatante -->
    <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white">

        <!-- Header à fort impact visuel -->
        <div class="card-header p-4 p-md-5 border-0 text-white" style="background: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);">
            <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
                <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-2 text-uppercase fw-black" style="font-size: 0.75rem; letter-spacing: 1px; backdrop-filter: blur(5px);">
                    <i class="bi bi-building me-1"></i> {{ $activity->service->direction->name }}
                </span>
                <span class="text-white opacity-50 fw-bold">/</span>
                <span class="text-white small fw-bold text-uppercase tracking-wider">{{ $activity->service->name }}</span>
            </div>

            <h1 class="display-5 fw-black text-white mb-0 tracking-tighter">
                Rapport du <br class="d-md-none">
                <span class="text-white opacity-100">{{ $activity->report_date->translatedFormat('j F Y') }}</span>
            </h1>
        </div>

        <!-- Corps du rapport (Lisibilité accrue) -->
        <div class="card-body p-4 p-md-5 bg-white">
            <div class="row">
                <div class="col-lg-10">
                    <label class="d-block small fw-black text-uppercase text-indigo mb-4 tracking-widest">
                        <i class="bi bi-journal-text me-2"></i> Réalisations détaillées
                    </label>

                    <!-- Encadré de contenu avec bordure néon -->
                    <div class="p-4 p-md-5 rounded-4 border-start border-indigo border-5 bg-light bg-opacity-50 shadow-sm" style="min-height: 200px;">
                        <p class="h5 fw-medium text-dark mb-0" style="white-space: pre-line; line-height: 2; color: #1e293b !important;">
                            {{ $activity->content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pied de page avec contrastes temporels -->
        <div class="card-footer bg-light border-0 px-4 px-md-5 py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    <i class="bi bi-clock-history text-indigo me-1"></i> Enregistré le {{ $activity->created_at->format('d/m/Y à H:i') }}
                </div>

                @if($activity->updated_at > $activity->created_at)
                    <div class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill small fw-bold text-uppercase" style="font-size: 0.65rem;">
                        <i class="bi bi-info-circle me-1"></i> Mis à jour le {{ $activity->updated_at->format('d/m/Y') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://googleapis.com');

    body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-black { font-weight: 800 !important; }
    .text-indigo { color: #4361ee !important; }
    .border-indigo { border-color: #4361ee !important; }
    .rounded-5 { border-radius: 2rem !important; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .tracking-tighter { letter-spacing: -0.05em; }
    .tracking-widest { letter-spacing: 0.15em; }

    .transition-hover:hover {
        background-color: #ffffff !important;
        transform: translateY(-2px);
        color: #4361ee !important;
    }

    /* Style spécifique pour la lead text */
    .h5.fw-medium { font-size: 1.15rem; }

    @media (max-width: 768px) {
        .display-5 { font-size: 2rem; }
    }
</style>
@endsection
