@extends('layouts.app')

@section('content')

<div class="container-fluid py-4" style="background-color: #f0f2f5;">

    {{-- Alertes de Statut --}}
    <div class="row mb-4 no-print">
        <div class="col-md-12">
            <div class="alert bg-white border-0 shadow-sm rounded-4 d-flex align-items-center p-3">
                <div class="icon-circle bg-primary-subtle text-primary me-3 p-3 rounded-circle">
                    <i class="fas fa-info-circle fa-lg"></i>
                </div>
                <div>
                    <span class="fw-bold d-block">Indicateurs de suivi :</span>
                    <span class="badge bg-info-subtle text-info rounded-pill">Permanent</span> activités cycliques |
                    <span class="badge bg-danger-subtle text-danger rounded-pill">Retard</span> échéance dépassée & < 100%
                </div>
            </div>
        </div>
    </div>

   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark fw-bolder">🚀 Suivi des Activités</h1>
        <div class="d-flex gap-2 flex-wrap no-print">
            <!-- FILTRE PAR DIRECTION -->
            <form action="{{ route('activities.index') }}" method="GET" class="d-flex gap-2">
                <select name="direction" class="form-select shadow-sm border-0 rounded-pill px-3" onchange="this.form.submit()">
                    <option value="">🌍 Toutes les Directions</option>
                    @foreach($directions as $d)
                        <option value="{{ $d->id }}" {{ request('direction') == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
                @if(request('direction'))
                    <a href="{{ route('activities.index') }}" class="btn btn-light rounded-pill shadow-sm border-0">
                        <i class="fas fa-times text-danger"></i>
                    </a>
                @endif
            </form>

            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-dark shadow-sm px-3 py-2 rounded-pill border-0 fw-bold">
                <i class="fas fa-print me-1 text-warning"></i> Imprimer
            </a>

            <a href="{{ route('activities.create') }}" class="btn shadow-lg px-4 py-2 rounded-pill border-0 text-white fw-bold" style="background: linear-gradient(45deg, #6366f1, #a855f7);">
                <i class="fas fa-plus-circle me-1"></i> Nouvelle Activité
            </a>
        </div>
    </div>

    {{-- Tableau des activités --}}
    <div class="card shadow-lg mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 bg-white border-0 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold" style="color: #6366f1;">
                <i class="fas fa-list-ul me-2 text-warning"></i>Journal de planification et d'exécution
            </h6>
            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Total: {{ $activities->count() }} lignes</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #1e293b; color: #f8fafc;">
                        <tr class="text-uppercase small fw-bold">
                            <th class="ps-4 py-3">Période & Statut</th>
                            <th>Entité & Service</th>
                            <th>Détails de l'activité</th>
                            <th class="text-center">Progression</th>
                            <th class="text-end pe-4 no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            @php
                                // Vérification du retard (seulement si non permanent et s'il y a une date de fin)
                                $isOverdue = !$activity->is_permanent
                                            && $activity->end_date
                                            && now()->gt($activity->end_date)
                                            && $activity->progress < 100;
                            @endphp
                        <tr class="{{ $isOverdue ? 'bg-soft-danger' : '' }}">
                            {{-- 1. PÉRIODE & STATUT --}}
                            <<td class="ps-4">
                                <div class="d-flex flex-column">
                                    <div class="fw-bold text-dark small mb-1">
                                        <i class="far fa-calendar-alt text-primary me-1"></i>
                                        {{-- Date de début --}}
                                        {{ ($activity->start_date ?? $activity->report_date)->format('d/m/y') }}

                                        {{-- Date de fin : On l'affiche SI elle existe et SI ce n'est pas permanent --}}
                                        @if($activity->end_date && !$activity->is_permanent)
                                            <i class="fas fa-long-arrow-alt-right mx-1 opacity-50 text-danger"></i>
                                            <span class="text-danger">{{ $activity->end_date->format('d/m/y') }}</span>
                                        @endif
                                    </div>


                                    {{-- Logique des Badges de Statut --}}
                                    @if($activity->is_permanent)
                                        <span class="badge bg-info-subtle text-info rounded-pill w-fit px-2" style="font-size: 0.7rem;">
                                            <i class="fas fa-sync-alt me-1"></i> Permanent
                                        </span>
                                    @elseif($isOverdue)
                                        <span class="badge bg-danger text-white rounded-pill w-fit px-2 shadow-sm animate-pulse" style="font-size: 0.7rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i> En Retard
                                        </span>
                                    @elseif($activity->progress == 100)
                                        <span class="badge bg-success-subtle text-success rounded-pill w-fit px-2" style="font-size: 0.7rem;">
                                            <i class="fas fa-check-circle me-1"></i> Terminé
                                        </span>
                                    @else
                                        <small class="text-muted italic" style="font-size: 0.75rem;">
                                            @if($activity->end_date)
                                                <i class="far fa-hourglass me-1"></i> Échéance {{ $activity->end_date->diffForHumans() }}
                                            @else
                                                <i class="fas fa-spinner fa-spin me-1"></i> En cours
                                            @endif
                                        </small>
                                    @endif
                                </div>
                            </td>


                            {{-- 2. DIRECTION ET SERVICE --}}
                            <td>
                                <span class="badge text-white px-2 py-1 mb-1" style="background-color: #6366f1; font-size: 0.65rem;">
                                    {{ $activity->service->direction->name }}
                                </span>
                                <div class="fw-bold text-dark small">
                                    {{ $activity->service->name }}
                                </div>
                            </td>

                            {{-- 3. CONTENU --}}
                            <td style="max-width: 300px;">
                                <div class="text-dark small lh-base">
                                    <span class="fw-bold">{{ Str::limit($activity->content, 100) }}</span>
                                </div>
                            </td>

                            {{-- 4. PROGRESSION --}}
                            <td class="text-center">
                                @php
                                    $progress = $activity->progress;
                                    $color = $progress == 100 ? '#10b981' : ($isOverdue ? '#ef4444' : ($progress > 50 ? '#f59e0b' : '#3b82f6'));
                                @endphp
                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <span class="fw-bold mb-1 small" style="color: {{ $color }};">{{ $progress }}%</span>
                                    <div class="progress w-100 shadow-sm" style="height: 6px; border-radius: 10px; background-color: #e2e8f0;">
                                        <div class="progress-bar progress-bar-striped {{ $progress < 100 && !$isOverdue ? 'progress-bar-animated' : '' }}"
                                             role="progressbar"
                                             style="width: {{ $progress }}%; background-color: {{ $color }}; border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 5. ACTIONS --}}
                            <td class="text-end pe-4 no-print">
                                <div class="btn-group shadow-sm rounded-pill overflow-hidden border bg-white">
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm px-3" title="Voir"><i class="fas fa-eye text-primary"></i></a>
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm px-3" title="Modifier"><i class="fas fa-edit text-warning"></i></a>
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm px-3" onclick="return confirm('Supprimer cette activité ?')"><i class="fas fa-trash-alt text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Aucune activité trouvée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.05); }
    .w-fit { width: fit-content; }
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
    .fa-spin-hover:hover { animation: fa-spin 2s infinite linear; }
</style>

<style>
    /* Masquer les éléments à l'impression */
    @media print {
        .no-print, .btn-group, .pagination, .alert { display: none !important; }
        .container-fluid { background: white !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .table { border: 1px solid #eee; }
    }
    .italic { font-style: italic; font-size: 0.8rem; }
    .btn-white { background: #fff; transition: background 0.2s; }
    .btn-white:hover { background: #f8fafc; }
</style>

@endsection
