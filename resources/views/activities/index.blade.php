@extends('layouts.app')

@section('content')

<div class="container-fluid py-4" style="background-color: #f0f2f5;">

    {{-- Message d'information dynamique --}}
    <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center mb-4">
        <i class="fas fa-chart-line fa-lg me-3"></i>
        <div>
            <strong>Suivi en temps réel :</strong> Les activités avec une progression de 100% sont automatiquement marquées comme terminées.
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
                <i class="fas fa-list-ul me-2 text-warning"></i>Journal des activités récentes
            </h6>
            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Total: {{ $activities->count() }} lignes</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #1e293b; color: #f8fafc;">
                        <tr class="text-uppercase small fw-bold">
                            <th class="ps-4 py-3">Date & Période</th>
                            <th>Entité & Service</th>
                            <th>Contenu de l'activité</th>
                            <th class="text-center">Progression</th>
                            <th class="text-end pe-4 no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            {{-- 1. DATE --}}
                            <td class="ps-4">
                                <span class="badge rounded-pill px-3 py-2 mb-1 shadow-sm" style="background-color: #22d3ee; color: #083344;">
                                    {{ \Carbon\Carbon::parse($activity->report_date)->translatedFormat('l d F Y') }}
                                </span><br>
                                <small class="text-muted italic ps-1">
                                    <i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($activity->report_date)->diffForHumans() }}
                                </small>
                            </td>

                            {{-- 2. DIRECTION ET SERVICE --}}
                            <td>
                                <div class="mb-1">
                                    <span class="badge shadow-sm text-white px-2 py-1 mb-1" style="background-color: #6366f1; font-size: 0.7rem;">
                                        <i class="fas fa-building me-1"></i>{{ $activity->service->direction->name }}
                                    </span>
                                </div>
                                <div class="fw-bold text-dark small">
                                    <i class="fas fa-layer-group text-info me-1"></i>{{ $activity->service->name }}
                                </div>
                            </td>

                            {{-- 3. CONTENU --}}
                            <td style="max-width: 350px;">
                                <div class="text-dark small lh-base" style="text-align: justify;">
                                    {{ Str::limit($activity->content, 150) }}
                                </div>
                            </td>

                            {{-- 4. PROGRESSION --}}
                            <td class="text-center" style="min-width: 180px;">
                                @php
                                    $progress = $activity->progress;
                                    $color = $progress == 100 ? '#10b981' : ($progress > 50 ? '#f59e0b' : '#ef4444');
                                @endphp
                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <span class="fw-bold mb-1" style="color: {{ $color }};">{{ $progress }}%</span>
                                    <div class="progress w-75 shadow-sm" style="height: 8px; border-radius: 10px; background-color: #e2e8f0;">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $progress }}%; background-color: {{ $color }}; border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 5. ACTIONS --}}
                            <td class="text-end pe-4 no-print">
                                <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-white btn-sm px-3 border-0" title="Voir">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-white btn-sm px-3 border-0" title="Modifier">
                                        <i class="fas fa-edit text-warning"></i>
                                    </a>
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm px-3 border-0" onclick="return confirm('Supprimer cette activité ?')" title="Supprimer">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                                <p class="text-muted fw-bold">Aucune activité trouvée pour cette période.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($activities->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $activities->links() }}
        </div>
        @endif
    </div>
</div>

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
