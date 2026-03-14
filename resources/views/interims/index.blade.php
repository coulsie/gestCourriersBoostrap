@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-5">
    <!-- Header avec Titre et Bouton de Création -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-badge shadow-sm p-2 rounded bg-white me-2 text-primary"></i>Suivi des Intérims
            </h2>
            <p class="text-muted small mb-0">Gestion et historique des délégations de signature</p>
        </div>
        <a href="{{ route('interims.create') }}" class="btn btn-primary shadow-sm fw-bold">
            <i class="bi bi-plus-circle me-2"></i> Nouvel Intérim
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">Titulaire (Absent)</th>
                            <th>Intérimaire (Remplaçant)</th>
                            <th>Période de validité</th>
                            <th>Statut Actuel</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($interims as $interim)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-primary">{{ $interim->agent->last_name }} {{ $interim->agent->first_name }}</div>
                                    <small class="badge bg-light text-dark border">{{ $interim->agent->status }}</small>
                                </td>

                                <td>
                                    @if($interim->interimaire)
                                        <div class="fw-bold text-dark">{{ $interim->interimaire->last_name }} {{ $interim->interimaire->first_name }}</div>
                                        <small class="text-muted"><i class="bi bi-person-check me-1"></i>{{ $interim->interimaire->status }}</small>
                                    @else
                                        <span class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle me-1"></i>Agent non trouvé</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="small">
                                        <span class="d-block"><strong>Du:</strong> {{ \Carbon\Carbon::parse($interim->date_debut)->format('d/m/Y') }}</span>
                                        <span class="d-block"><strong>Au:</strong> {{ \Carbon\Carbon::parse($interim->date_fin)->format('d/m/Y') }}</span>
                                    </div>
                                </td>

                                <td>
                                    @php
                                        $today = now()->startOfDay();
                                        $debut = \Carbon\Carbon::parse($interim->date_debut)->startOfDay();
                                        $fin = \Carbon\Carbon::parse($interim->date_fin)->endOfDay();
                                    @endphp

                                    @if(!$interim->is_active)
                                        <span class="badge rounded-pill px-3 py-2 bg-danger text-white shadow-sm w-100 text-uppercase">
                                            <i class="bi bi-x-circle me-1"></i> Annulé
                                        </span>
                                    @elseif($today->between($debut, $fin))
                                        <span class="badge rounded-pill px-3 py-2 bg-success text-white shadow-sm w-100 text-uppercase">
                                            <i class="bi bi-check-circle me-1"></i> Actif
                                        </span>
                                    @elseif($today->lt($debut))
                                        <span class="badge rounded-pill px-3 py-2 bg-info text-white shadow-sm w-100 text-uppercase">
                                            <i class="bi bi-clock-history me-1"></i> Programmé
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 bg-secondary text-white shadow-sm w-100 text-uppercase">
                                            <i class="bi bi-archive me-1"></i> Terminé
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center pe-4">
    <div class="d-flex justify-content-center align-items-center gap-2">
        {{-- Bouton VOIR (Bleu Info) --}}
        <a href="{{ route('interims.show', $interim->id) }}"
           class="btn btn-info btn-sm shadow-sm"
           title="Voir les détails"
           style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-eye" style="font-size: 1rem; color: white;"></i>
        </a>

        {{-- Bouton MODIFIER (Jaune/Orange) --}}
        <a href="{{ route('interims.edit', $interim->id) }}"
           class="btn btn-warning btn-sm shadow-sm text-dark"
           title="Modifier l'intérim"
           style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-edit" style="font-size: 1rem;"></i>
        </a>

        {{-- Bouton ARRÊTER (Sombre) --}}
        @if($interim->is_active && $today->lte($fin))
            <form action="{{ route('interims.stop', $interim->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="btn btn-dark btn-sm shadow-sm"
                        title="Arrêter l'intérim"
                        onclick="return confirm('Arrêter cet intérim prématurément ?')"
                        style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-stop-circle" style="font-size: 1rem;"></i>
                </button>
            </form>
        @endif

        {{-- Bouton SUPPRIMER (Rouge) --}}
        <form action="{{ route('interims.destroy', $interim->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn btn-danger btn-sm shadow-sm"
                    title="Supprimer définitivement"
                    onclick="return confirm('Attention : La suppression supprimera également l\'absence liée. Confirmer ?')"
                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-trash" style="font-size: 1rem;"></i>
            </button>
        </form>
    </div>
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-person-x display-4 d-block mb-3 opacity-25"></i>
                                        <p class="fw-bold">Aucun intérim enregistré dans le système.</p>
                                        <a href="{{ route('interims.create') }}" class="btn btn-sm btn-primary mt-2">Créer le premier intérim</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($interims, 'links') && $interims->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $interims->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .badge {
        font-size: 0.7rem;
        letter-spacing: 0.3px;
        font-weight: 700;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.03);
    }
    .btn-group-sm > .btn, .btn-sm {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
    }
</style>
@endsection
