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
                    {{-- Affiche le nombre d'éléments chargés sur la page (ex: 15) --}}
                    <div class="h3 fw-black mb-0 text-dark">{{ $activities->count() }}</div>


                </div>
            </div>
        </div>
    </div>

    <!-- Table de Données Optimisée -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="card-header bg-white border-bottom-0 py-3 px-4 d-flex justify-content-between align-items-center">
        <h2 class="h6 fw-black text-dark mb-0 text-uppercase">Rapports Récents</h2>
        {{-- Utilisation de count() au lieu de total() pour la rapidité --}}
        <span class="badge bg-primary text-white rounded-pill px-3 py-2">
            {{ $activities->count() }} éléments affichés
        </span>
    </div>

    <div class="table-responsive">
        {{-- Ajout de table-layout: fixed pour accélérer le rendu du navigateur --}}
        <table class="table table-hover align-middle mb-0" style="table-layout: fixed;">
            <thead class="bg-light text-muted">
                <tr>
                    <th class="ps-4 py-3 small fw-black text-uppercase" style="width: 25%;">Service</th>
                    <th class="py-3 small fw-black text-uppercase" style="width: 15%;">Date</th>
                    <th class="py-3 small fw-black text-uppercase" style="width: 45%;">Contenu</th>
                    <th class="pe-4 py-3 text-end small fw-black text-uppercase" style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr class="transition-hover">
                        <td class="ps-4">
                            {{-- On vérifie l'existence des relations pour éviter les erreurs 500 --}}
                            <div class="fw-bold text-dark text-truncate">{{ $activity->service->name ?? 'N/A' }}</div>
                            <div class="badge bg-light text-primary text-uppercase" style="font-size: 0.6rem;">
                                {{ $activity->service->direction->name ?? 'Direction inconnue' }}
                            </div>
                        </td>
                        <td>
                            <div class="small text-dark fw-medium text-nowrap">
                                <i class="bi bi-calendar3 text-primary me-1"></i>
                                {{ optional($activity->report_date)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td>
                            {{-- Str::limit est crucial pour la RAM si content est un TEXT long --}}
                            <div class="p-2 bg-light rounded-3 small text-muted text-truncate" title="{{ $activity->content }}">
                                {{ Str::limit($activity->content, 80) }}
                            </div>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <!-- Bouton Voir -->
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-light border d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" title="Voir">
                                    <svg xmlns="http://w3.org" width="16" height="16" fill="currentColor" class="bi bi-eye-fill text-primary" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </a>

                                <!-- Bouton Modifier -->
                                <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-light border d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" title="Modifier">
                                    <svg xmlns="http://w3.org" width="16" height="16" fill="currentColor" class="bi bi-pencil-square text-warning" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce rapport ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light border d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" title="Supprimer">
                                        <svg xmlns="http://w3.org" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill text-danger" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                            Aucune activité enregistrée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination simple (Précédent/Suivant) pour la performance --}}
    @if($activities->hasPages())
        <div class="card-footer bg-white border-top-0 p-3">
            <div class="d-flex justify-content-center">
                {{ $activities->links() }}
            </div>
        </div>
    @endif
</div>
</div>

<style>
    /* Accélère le rendu en évitant les recalculs de largeur de colonnes */
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .transition-hover:hover { background-color: #f8f9fa !important; }
</style>
@endsection
