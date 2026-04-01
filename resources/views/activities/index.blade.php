@extends('layouts.app')

@section('content')
<!-- Import des icônes (Fixés) -->
<link rel="stylesheet" href="https://jsdelivr.net">
<link rel="stylesheet" href="https://cloudflare.com">

<style>
    body { background-color: #f8f9fc; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }
    .fw-black { font-weight: 800 !important; }
    .rounded-4 { border-radius: 1.25rem !important; }

    /* ✅ Optimisation Performance : Rendu du tableau accéléré */
    .table-optimized {
        table-layout: fixed;
        width: 100%;
    }
    .col-service { width: 25%; }
    .col-date { width: 15%; }
    .col-content { width: 40%; }
    .col-actions { width: 20%; }

    .bg-soft-primary { background-color: #e0e7ff; }
    .bg-soft-indigo { background-color: #eef2ff; }
    .text-indigo { color: #4361ee; }
    .text-purple { color: #7209b7; }
    .border-purple { border-color: #7209b7 !important; }

    .transition-hover:hover { background-color: #fcfdff; }
</style>

<div class="container py-4">

    <!-- Header Premium -->
    <div class="card border-0 shadow-lg mb-4 overflow-hidden text-white" style="border-radius: 1.5rem; background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div>
                <h1 class="display-6 fw-black mb-1 text-white">Journal des Activités</h1>
                <p class="lead opacity-75 mb-0 fw-medium">Suivi en temps réel des prestations par service</p>
            </div>
            <a href="{{ route('activities.create') }}" class="btn btn-light btn-lg px-4 py-3 rounded-4 shadow-sm mt-4 mt-md-0 fw-bold text-primary transition-hover">
                <i class="bi bi-plus-circle-fill me-2"></i> Nouvelle Saisie
            </a>
        </div>
    </div>

    <!-- Grille de Statistiques -->
    <div class="row g-4 mb-4 text-center text-md-start">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 border-start border-primary border-5">
                <div class="card-body p-3">
                    <div class="text-uppercase small fw-black text-primary mb-1">Aujourd'hui</div>
                    {{-- ✅ Optimisation : On évite de recalculer sur la collection paginée --}}
                    <div class="h3 fw-black mb-0 text-dark">{{ $activities->count() }} <small class="text-muted fs-6">(page)</small></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 border-start border-purple border-5">
                <div class="card-body p-3">
                    <div class="text-uppercase small fw-black text-purple mb-1">Total Dossiers</div>
                    
                    {{-- ✅ Ligne 62 corrigée --}}
                    <div class="h3 fw-black mb-0 text-dark">{{ $activities->total() }}</div>

                </div>
            </div>
        </div>
    </div>

    <!-- Table de Données -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-bottom-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h2 class="h6 fw-black text-dark mb-0 text-uppercase">Rapports Récents</h2>
            <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2">Flash : {{ now()->format('H:i') }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-optimized">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 col-service small fw-black text-secondary text-uppercase">Service</th>
                        <th class="py-3 col-date small fw-black text-secondary text-uppercase">Date</th>
                        <th class="py-3 col-content small fw-black text-secondary text-uppercase">Contenu</th>
                        <th class="pe-4 py-3 col-actions text-end small fw-black text-secondary text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr class="transition-hover">
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark mb-0 text-truncate">{{ $activity->service->name }}</div>
                                <div class="badge bg-soft-indigo text-indigo text-uppercase" style="font-size: 0.6rem;">
                                    {{ $activity->service->direction->name }}
                                </div>
                            </td>
                            <td>
                                <div class="small text-dark fw-medium">
                                    <i class="bi bi-calendar3 text-primary me-1"></i>
                                    {{ $activity->report_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td>
                                <div class="p-2 bg-light rounded-3 small text-muted text-truncate" style="max-width: 100%;">
                                    {{ Str::limit($activity->content, 60) }}
                                </div>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-outline-primary border-0" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-outline-warning border-0" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce rapport ?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small">Aucune activité enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="card-footer bg-white border-top-0 p-3">
                <div class="d-flex justify-content-center">
                    {{ $activities->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
