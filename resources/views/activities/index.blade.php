@extends('layouts.app')

@section('content')
<!-- Import des icônes Bootstrap pour des visuels nets -->
<link rel="stylesheet" href="https://jsdelivr.net">

<div class="container py-5">

    <!-- Header Premium avec Dégradé Vibrant -->
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

    <!-- Grille de Statistiques Éclatantes -->
    <div class="row g-4 mb-5 text-center text-md-start">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 border-start border-primary border-5">
                <div class="card-body p-4">
                    <div class="text-uppercase small fw-black text-primary mb-2 tracking-wider">Aujourd'hui</div>
                    <div class="h2 fw-black mb-0 text-dark">{{ $activities->where('report_date', today())->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 border-start border-purple border-5">
                <div class="card-body p-4">
                    <div class="text-uppercase small fw-black text-purple mb-2 tracking-wider">Total Dossiers</div>
                    <div class="h2 fw-black mb-0 text-dark">{{ $activities->total() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table de Données Organisée -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <h2 class="h5 fw-black text-dark mb-0 uppercase">Rapports Récents</h2>
            <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 fw-bold">Dernière mise à jour : {{ now()->format('H:i') }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-black text-secondary tracking-widest">Service & Structure</th>
                        <th class="py-3 text-uppercase small fw-black text-secondary tracking-widest">Date Rapport</th>
                        <th class="py-3 text-uppercase small fw-black text-secondary tracking-widest">Aperçu Contenu</th>
                        <th class="pe-4 py-3 text-uppercase small fw-black text-secondary text-end tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr class="transition-hover">
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-dark h6 mb-1">{{ $activity->service->name }}</div>
                                <div class="badge bg-soft-indigo text-indigo text-uppercase fw-bold" style="font-size: 0.65rem;">
                                    <i class="bi bi-building me-1"></i> {{ $activity->service->direction->name }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    <i class="bi bi-calendar3 text-primary me-2"></i>
                                    {{ $activity->report_date->format('d M Y') }}
                                </div>
                            </td>
                            <td class="text-secondary small">
                                <div class="p-3 bg-light rounded-3 italic border-start border-2" style="max-width: 300px; line-height: 1.4;">
                                    "{{ Str::limit($activity->content, 80) }}"
                                </div>
                            </td>



                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Voir (Oeil Bleu) -->
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-outline-primary border-0 px-2" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Modifier (Stylo Jaune/Orange) -->
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-outline-warning border-0 px-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Supprimer (Corbeille Rouge) -->
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0 px-2" onclick="return confirm('Confirmer la suppression ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-clipboard-x display-4 text-light"></i>
                                    <p class="text-muted mt-3 fw-medium">Aucune activité enregistrée pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Épurée -->
        @if($activities->hasPages())
            <div class="card-footer bg-white border-top border-light p-4">
                <div class="d-flex justify-content-center">
                    {{ $activities->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    @import url('https://googleapis.com');

    body { background-color: #f8f9fc; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }
    .fw-black { font-weight: 800 !important; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Couleurs personnalisées Soft */
    .bg-soft-primary { background-color: #e0e7ff; }
    .bg-soft-indigo { background-color: #eef2ff; }
    .bg-soft-warning { background-color: #fef3c7; }
    .text-indigo { color: #4361ee; }
    .text-purple { color: #7209b7; }
    .border-purple { border-color: #7209b7 !important; }

    /* Boutons Icônes */
    .btn-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; border: none; }
    .btn-soft-primary { background-color: #e0e7ff; color: #4361ee; }
    .btn-soft-primary:hover { background-color: #4361ee; color: white; }
    .btn-soft-warning { background-color: #fef3c7; color: #d97706; }
    .btn-soft-warning:hover { background-color: #d97706; color: white; }

    /* Effets Hover */
    .transition-hover:hover { background-color: #f1f5f9; transform: scale(1.002); }
    .transition-hover { transition: all 0.2s ease-in-out; }

    /* Pagination Bootstrap Fix */
    .pagination { margin-bottom: 0; gap: 5px; }
    .page-link { border-radius: 10px; border: none; background-color: #f1f5f9; color: #475569; font-weight: 600; }
    .page-item.active .page-link { background-color: #4361ee; color: white; }
        .btn-soft-danger {
        background-color: #fee2e2; /* Rouge très clair */
        color: #dc2626; /* Rouge vif */
        border: none;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-soft-danger:hover {
        background-color: #dc2626;
        color: white !important;
        transform: translateY(-2px);
    }
    .btn-soft-danger i:hover { color: white !important; }

</style>
@endsection
