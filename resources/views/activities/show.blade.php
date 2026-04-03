@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5; min-height: 100vh;">

    <!-- BARRE D'ACTIONS -->
    <div class="d-flex align-items-center justify-content-between mb-4 no-print">
        <a href="{{ route('activities.index') }}" class="btn btn-white shadow-sm rounded-pill px-4 border fw-bold text-muted">
            <i class="fas fa-arrow-left me-2 text-primary"></i> Retour
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print();" class="btn btn-dark shadow-sm px-4 py-2 rounded-pill border-0 fw-bold">
                <i class="fas fa-print me-2 text-warning"></i> Imprimer la fiche
            </button>
            <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-warning shadow-sm px-4 py-2 rounded-pill border-0 fw-bold text-dark">
                <i class="fas fa-edit me-2"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- CARTE PRINCIPALE -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- HEADER STYLE REUNION -->
                <div class="card-header p-4 border-0 text-white" style="background: linear-gradient(45deg, #1e293b, #334155);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge rounded-pill px-3 py-2 mb-2 shadow-sm" style="background-color: #22d3ee; color: #083344;">
                                <i class="fas fa-calendar-alt me-2"></i> Activité du {{ \Carbon\Carbon::parse($activity->report_date)->translatedFormat('l d F Y') }}
                            </span>
                            <h3 class="fw-bolder mb-0 mt-2 text-uppercase">Détails de l'exécution</h3>
                        </div>
                        <div class="text-end">
                            <small class="text-white-50 d-block">ID de l'activité</small>
                            <span class="fw-bold">#ACT-00{{ $activity->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- SECTION INFOS CLÉS -->
                    <div class="row g-0 border-bottom">
                        <div class="col-md-6 border-end p-4">
                            <label class="text-muted small fw-bold text-uppercase mb-2 d-block">Direction Responsable</label>
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary-subtle text-primary rounded-3 p-3 me-3">
                                    <i class="fas fa-building fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $activity->service->direction->name }}</h6>
                                    <small class="text-muted">Code: {{ $activity->service->direction->code ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-4">
                            <label class="text-muted small fw-bold text-uppercase mb-2 d-block">Service Concerné</label>
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-info-subtle text-info rounded-3 p-3 me-3">
                                    <i class="fas fa-layer-group fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $activity->service->name }}</h6>
                                    <small class="text-muted">Opérationnel</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION CONTENU -->
                    <div class="p-4 bg-white">
                        <label class="text-muted small fw-bold text-uppercase mb-3 d-block">Rapport détaillé de l'activité</label>
                        <div class="p-4 rounded-4 shadow-sm border-start border-4 border-primary" style="background-color: #f8fafc; min-height: 150px;">
                            <p class="text-dark lh-lg fs-5 mb-0" style="white-space: pre-line;">
                                {{ $activity->content }}
                            </p>
                        </div>
                    </div>

                    <!-- SECTION PROGRESSION -->
                    <div class="p-4 border-top" style="background-color: #f1f5f9;">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h6 class="fw-bold mb-1 text-dark">Niveau d'achèvement</h6>
                                <p class="small text-muted mb-md-0">Mise à jour le {{ $activity->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $color = $activity->progress == 100 ? '#10b981' : ($activity->progress > 50 ? '#f59e0b' : '#ef4444');
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 shadow-sm" style="height: 15px; border-radius: 20px; background-color: #e2e8f0;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar"
                                             style="width: {{ $activity->progress }}%; background-color: {{ $color }}; border-radius: 20px;">
                                        </div>
                                    </div>
                                    <span class="ms-3 fw-bolder fs-4" style="color: {{ $color }};">{{ $activity->progress }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER / SIGNATURE -->
                <div class="card-footer bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center small text-muted italic">
                        <span>Généré par le système de gestion des activités</span>
                        <span class="fw-bold">Direction Générale</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
    .bg-primary-subtle { background-color: #e0e7ff; }
    .bg-info-subtle { background-color: #e0f2fe; }
    .italic { font-style: italic; }

    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .progress { border: 1px solid #ccc; }
    }
</style>
@endsection
