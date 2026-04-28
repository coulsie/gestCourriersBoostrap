
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- En-tête avec dégradé ambre/orange -->
                <div class="card-header text-dark py-4 d-flex justify-content-between align-items-center"
                     style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);">
                    <h4 class="mb-0 fw-black text-uppercase" style="letter-spacing: 1px;">
                        <i class="fas fa-edit me-2"></i> Modification de l'Imputation #{{ $imputation->id }}
                    </h4>
                    <span class="badge bg-dark rounded-pill px-4 py-2 shadow-sm">
                        <i class="fas fa-layer-group me-1"></i> NIVEAU : {{ strtoupper($imputation->niveau) }}
                    </span>
                </div>

                <div class="card-body p-4 bg-white">
                    <form action="{{ route('imputations.update', $imputation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Champs cachés nécessaires --}}
                        <input type="hidden" name="user_id" value="{{ $imputation->user_id }}">
                        <input type="hidden" name="courrier_id" value="{{ $imputation->courrier_id }}">
                        <input type="hidden" name="date_imputation" value="{{ $imputation->date_imputation }}">
                        <input type="hidden" name="niveau" value="{{ $imputation->niveau }}">

                        <!-- SECTION 1 : RAPPEL COURRIER -->
                        <div class="mb-4 p-3 rounded-4 border-start border-5 border-warning shadow-sm" style="background-color: #fffbeb;">
                            <label class="form-label fw-bold text-warning-700 small text-uppercase mb-2">
                                <i class="fas fa-info-circle me-1"></i> Document en cours de traitement
                            </label>
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <span class="badge bg-primary px-3 py-2 w-100">Réf: {{ $imputation->courrier->reference }}</span>
                                </div>
                                <div class="col-md-9">
                                    <p class="mb-0 fw-bold text-dark">{{ $imputation->courrier->objet }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- SECTION 2 : RÉAFFECTATION DES AGENTS (Version Checkbox) -->
                            <div class="col-md-7 mb-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm border-top border-4 border-success h-100">
                                    <h6 class="fw-black text-success text-uppercase mb-4">
                                        <i class="fas fa-users-cog me-2"></i> 1. Destinataires de l'action
                                    </h6>

                                    {{-- Filtres de recherche --}}
                                    <div class="row g-2 mb-3 bg-light p-2 rounded-3">
                                        <div class="col-md-12">
                                            <select id="service_filter" class="form-select border-0 shadow-sm">
                                                <option value="">-- Filtrer par tous les services --</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}">[{{ $service->code }}] {{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label small fw-bold text-muted text-uppercase mb-0">Sélectionner les Agents *</label>
                                            <span class="badge rounded-pill shadow-sm"
                                                id="selected-count"
                                                style="background-color: #dc3545; color: #ffffff; font-weight: 900; border: 1px solid #ffffff;">
                                                0 sélectionné(s)
                                            </span>

                                        </div>

                                        {{-- Liste des agents avec cases à cocher --}}
                                        <div id="agent-checkbox-list" class="border rounded-3 p-2 bg-light shadow-inner" style="max-height: 280px; overflow-y: auto;">
                                            @php
                                                $selectedAgents = $imputation->agents->pluck('id')->toArray();
                                            @endphp
                                            @foreach($agents->sortBy('last_name') as $agent)
                                                <div class="agent-item p-2 mb-1 rounded bg-white border shadow-sm transition-all"
                                                     data-service="{{ $agent->service_id }}">
                                                    <div class="form-check custom-checkbox">
                                                        <input class="form-check-input agent-checkbox" type="checkbox"
                                                               name="agent_ids[]"
                                                               value="{{ $agent->id }}"
                                                               id="ag_{{ $agent->id }}"
                                                               {{ in_array($agent->id, $selectedAgents) ? 'checked' : '' }}>
                                                        <label class="form-check-label w-100 cursor-pointer mb-0" for="ag_{{ $agent->id }}">
                                                            <span class="fw-bold text-dark">{{ strtoupper($agent->last_name) }}</span> {{ $agent->first_name }}
                                                            <br>
                                                            <small class="text-muted italic" style="font-size: 0.75rem;">
                                                                <i class="fas fa-briefcase me-1"></i>{{ $agent->service->name ?? 'N/A' }}
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('agent_ids')
                                            <div class="text-danger small fw-bold mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3 : ÉCHÉANCIER & STATUT -->
                            <div class="col-md-5 mb-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm border-top border-4 border-primary h-100">
                                    <h6 class="fw-black text-primary text-uppercase mb-4"><i class="fas fa-tasks me-2"></i> 2. Suivi & Délais</h6>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-danger small text-uppercase">
                                            <i class="fas fa-calendar-alt me-1"></i> Échéancier (Date Limite)
                                        </label>
                                        <input type="date" name="echeancier" class="form-control border-danger shadow-sm fw-bold"
                                            value="{{ old('echeancier', $imputation->echeancier ? $imputation->echeancier->format('Y-m-d') : '') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary small text-uppercase">Statut de l'Imputation</label>
                                        <select name="statut" class="form-select border-primary shadow-sm fw-bold">
                                            <option value="en_attente" {{ $imputation->statut == 'en_attente' ? 'selected' : '' }}>🔴 En attente</option>
                                            <option value="en_cours" {{ $imputation->statut == 'en_cours' ? 'selected' : '' }}>🔵 En cours</option>
                                            <option value="termine" {{ $imputation->statut == 'termine' ? 'selected' : '' }}>🟢 Terminé</option>
                                        </select>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-bold text-muted small text-uppercase">Observations</label>
                                        <textarea name="observations" class="form-control shadow-sm" rows="3" placeholder="Note interne...">{{ old('observations', $imputation->observations) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4 : INSTRUCTIONS -->
                        <div class="mb-4 p-4 bg-white rounded-4 shadow-sm border-top border-4 border-warning">
                            <label class="form-label fw-black text-warning text-uppercase mb-3">
                                <i class="fas fa-comment-dots me-1"></i> 3. Instructions & Recommandations
                            </label>
                            <textarea name="instructions" class="form-control border-warning shadow-sm" rows="4" required>{{ old('instructions', $imputation->instructions) }}</textarea>
                        </div>

                        <!-- BOUTONS ACTIONS -->
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('imputations.index') }}" class="btn btn-outline-secondary rounded-pill px-5 fw-bold">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-warning rounded-pill px-5 fw-black shadow-lg text-dark">
                                <i class="fas fa-sync-alt me-2"></i> METTRE À JOUR L'IMPUTATION
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const serviceFilter = document.getElementById('service_filter');
    const agentItems    = document.querySelectorAll('.agent-item');
    const checkboxes    = document.querySelectorAll('.agent-checkbox');
    const counter       = document.getElementById('selected-count');

    /**
     * Met à jour le badge affichant le nombre d'agents cochés
     */
    function updateCounter() {
        const checkedCount = document.querySelectorAll('.agent-checkbox:checked').length;
        if (counter) {
            counter.textContent = `${checkedCount} sélectionné(s)`;
            // Change la couleur du badge si au moins un est sélectionné
            counter.className = checkedCount > 0 ? 'badge bg-success rounded-pill' : 'badge bg-secondary rounded-pill';
        }
    }

    /**
     * Filtre les agents visibles dans la liste selon le service choisi
     */
    if (serviceFilter) {
        serviceFilter.addEventListener('change', function() {
            const selectedService = this.value;

            agentItems.forEach(item => {
                const itemService = item.getAttribute('data-service');

                // On affiche si "Tous" est sélectionné ou si le service correspond
                if (selectedService === "" || itemService === selectedService) {
                    item.style.display = "block";
                    item.classList.add('animate__animated', 'animate__fadeIn'); // Optionnel : animation
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // Écouteur sur chaque checkbox pour le compteur
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCounter);
    });

    // Initialisation au chargement (pour les agents déjà cochés en mode edit)
    updateCounter();
});
</script>
<style>
    /* Typographie et Couleurs */
    .fw-black { font-weight: 900; }
    .text-warning-700 { color: #b45309; }
    .bg-success-subtle { background-color: #d1fae5; }

    /* Design des éléments */
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease; }

    /* Hover et Focus */
    .agent-item:hover { background-color: #f8fafc !important; transform: translateX(5px); }
    .form-select:focus, .form-control:focus {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.2) !important;
    }

    /* Personnalisation de la scrollbar pour la liste */
    #agent-checkbox-list::-webkit-scrollbar { width: 6px; }
    #agent-checkbox-list::-webkit-scrollbar-track { background: #f1f1f1; }
    #agent-checkbox-list::-webkit-scrollbar-thumb { background: #ffc107; border-radius: 10px; }
</style>


@endsection
