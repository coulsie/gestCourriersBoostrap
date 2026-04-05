@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe; min-height: 100vh;">

    <!-- EN-TÊTE DE SYNTHÈSE -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">📊 Synthèse des Activités</h3>
            <p class="text-muted small">Situation analysée pour <span class="text-primary fw-bold">{{ $label }}</span></p>
        </div>
        <div class="d-flex gap-2 no-print">
            <button onclick="window.print()" class="btn btn-white shadow-sm rounded-pill border px-3">
                <i class="fas fa-print text-dark me-2"></i>Imprimer
            </button>
            <a href="{{ route('activities.index') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-list me-2"></i>Journal Complet
            </a>
        </div>
    </div>

    <!-- FILTRES DYNAMIQUES (Période + Direction) - NO PRINT -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 no-print">
        <form action="{{ route('activities.synthese') }}" method="GET" class="row g-3 align-items-center">
            <!-- Choix de la Période -->
            <div class="col-md-5">
                <label class="small fw-bold text-muted mb-1 d-block"><i class="fas fa-calendar-alt me-1"></i> Période d'analyse</label>
                <div class="btn-group w-100 p-1 bg-light rounded-pill border">
                    @foreach(['hebdomadaire' => 'Semaine', 'mensuel' => 'Mois', 'trimestriel' => 'Trim.', 'annuel' => 'Année'] as $key => $text)
                        <a href="{{ route('activities.synthese', ['periode' => $key, 'direction_id' => $direction_id]) }}"
                           class="btn btn-sm rounded-pill fw-bold {{ $periode == $key ? 'btn-primary shadow-sm' : 'text-muted border-0' }}">
                            {{ $text }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Choix de la Direction (Le Focus) -->
            <div class="col-md-5">
                <label class="small fw-bold text-muted mb-1 d-block"><i class="fas fa-building me-1"></i> Filtrer par Direction</label>
                <select name="direction_id" class="form-select border-0 bg-light rounded-pill" onchange="this.form.submit()">
                    <option value="">📊 TOUTES LES DIRECTIONS (Compil Global)</option>
                    @foreach($directions as $d)
                        <option value="{{ $d->id }}" {{ $direction_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="periode" value="{{ $periode }}">
            </div>

            <div class="col-md-2 mt-4">
                <a href="{{ route('activities.synthese') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- CARTES DE PERFORMANCE (KPI) -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-gradient-primary text-white h-100" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                <small class="opacity-75 fw-bold text-uppercase">Activités (Période)</small>
                <h2 class="fw-bold mb-0">{{ $totalActivites }}</h2>
                <i class="fas fa-tasks position-absolute opacity-25" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-4 border-success">
                <small class="text-muted fw-bold text-uppercase">Taux d'Achèvement</small>
                <h2 class="fw-bold mb-0 text-success">{{ round($tauxMoyen, 1) }}%</h2>
                <div class="progress mt-2" style="height: 6px; border-radius: 10px;">
                    <div class="progress-bar bg-success" style="width: {{ $tauxMoyen }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-4 border-warning">
                <small class="text-muted fw-bold text-uppercase">En cours</small>
                <h2 class="fw-bold mb-0 text-warning">{{ $activitesEnCours }}</h2>
                <small class="text-muted italic">Progression 1-99%</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-4 border-danger">
                <small class="text-muted fw-bold text-uppercase">Non démarrées</small>
                <h2 class="fw-bold mb-0 text-danger">{{ $activitesNonDemarrees }}</h2>
                <small class="text-muted italic">Retard potentiel</small>
            </div>
        </div>
    </div>


     <div class="row">
    <!-- COLONNE GAUCHE : JOURNAL DES ACTIVITÉS (Largeur 7) -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-list-ul me-2"></i>
                    Journal des Activités par Direction et Service
                </h6>
            </div>
            <div class="card-body">
                @forelse($statsDirections as $direction)
                    <!-- TITRE DIRECTION -->
                    <div class="bg-light p-3 rounded-3 mb-3 border-start border-4 border-danger shadow-sm">
                        <h5 class="fw-bold text-dark mb-0 text-uppercase d-flex justify-content-between align-items-center" style="font-size: 0.9rem;">
                            <span><i class="fas fa-building me-2 text-danger"></i>{{ $direction->name }}</span>
                            <span class="badge rounded-pill px-3 py-2 fw-bolder text-white shadow"
                                style="background-color: #ef4444; border: 1px solid #dc2626; font-size: 0.75rem; box-shadow: 0 0 10px rgba(239, 68, 68, 0.3) !important;">
                                {{ $direction->activities_count }} ACTIVITÉ(S)
                            </span>
                        </h5>
                    </div>

                    <div class="ps-2 mb-4">
                        @foreach($direction->services as $service)
                            @if($service->activities->count() > 0)
                            <div class="mb-3">
                                <h6 class="fw-bold text-secondary border-bottom pb-1 small">
                                    <i class="fas fa-chevron-right me-1 small"></i>{{ $service->name }}
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle mb-0">
                                        <tbody>
                                            @foreach($service->activities as $act)
                                                <tr>
                                                    <td class="small text-muted" style="width: 20%">
                                                        {{ \Carbon\Carbon::parse($act->report_date)->format('d/m/y') }}
                                                    </td>
                                                    <td class="text-dark small py-1" style="white-space: pre-line;">{{ $act->content }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted small">Aucune activité enregistrée.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- COLONNE DROITE : TOP SERVICES & INFOS (Largeur 5) -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header py-3 border-0" style="background-color: #1e293b;">
                <h6 class="m-0 fw-bold text-white"><i class="fas fa-trophy me-2 text-warning"></i>Top Services Actifs</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topServices as $index => $service)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-light">
                        <div class="d-flex align-items-center">
                            <div class="rank-number me-3" style="width: 25px; height: 25px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">{{ $index + 1 }}</div>
                            <div>
                                <h6 class="mb-0 fw-bold small text-dark">{{ $service->name }}</h6>
                                <small class="text-muted text-uppercase" style="font-size: 0.6rem;">{{ $service->direction_name }}</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 fw-bolder text-white shadow"
                            style="background-color: #10b981; border: 1px solid #059669; letter-spacing: 0.5px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.5) ! Franco-African;">
                            {{ $service->activities_count }} act.
                        </span>

                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted small">Aucune donnée</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- ASTUCE / INFO -->
        <div class="card border-0 shadow-sm rounded-4 text-white p-3 no-print" style="background: linear-gradient(45deg, #475569, #1e293b);">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3 opacity-50"></i>
                <div>
                    <h6 class="fw-bold mb-1 small">Guide d'analyse</h6>
                    <p class="mb-0 opacity-80" style="font-size: 0.75rem;">Utilisez les filtres en haut de page pour ajuster la période. Les totaux en rouge indiquent le volume de production par entité.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-info-subtle { background-color: #e0f2fe; color: #0369a1; }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1); }
    .rank-number {
        width: 28px; height: 28px; background: #f8fafc; border: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; font-weight: bold; color: #64748b; font-size: 0.8rem;
    }
    .italic { font-style: italic; font-size: 0.75rem; }

    @media print {
        .no-print { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background: white !important; }
    }
</style>
@endsection
