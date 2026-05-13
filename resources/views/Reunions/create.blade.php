@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe; min-height: 100vh;">

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert border-0 shadow-sm rounded-4 mb-4" style="background-color: #fef2f2; color: #dc2626; border-left: 6px solid #dc2626 !important;">
            <div class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs suivantes :</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden animate__animated animate__fadeIn">
        <div class="card-header py-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
            <h5 class="m-0 text-white fw-900 text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-calendar-plus me-2 text-info"></i> Programmer une nouvelle réunion
            </h5>
            <span class="badge bg-info text-dark rounded-pill px-4 py-2 fw-bold shadow-sm">SESSION DE PLANIFICATION</span>
        </div>

        <div class="card-body p-4 bg-white">
            <form action="{{ route('reunions.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <!-- Objet -->
                    <div class="col-md-8">
                        <label class="form-label fw-black text-dark text-uppercase small"><i class="fas fa-tag me-1 text-primary"></i> Objet de la réunion *</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0 text-primary"><i class="fas fa-quote-left"></i></span>
                            <input type="text" name="objet" class="form-control border-0 bg-light fw-bold text-dark p-3" value="{{ old('objet') }}" placeholder="ex: Comité de Direction Annuel" required>
                        </div>
                    </div>

                    <!-- Date et Heure -->
                    <div class="col-md-4">
                        <label class="form-label fw-black text-danger text-uppercase small"><i class="fas fa-clock me-1"></i> Date et Heure *</label>
                        <input type="datetime-local" name="date_heure" class="form-control border-0 shadow-sm text-danger fw-bold p-3" value="{{ old('date_heure') }}" required style="background-color: #fff1f2; border-radius: 8px;">
                    </div>

                    <!-- Lieu de la réunion -->
                    <div class="col-12">
                        <label class="form-label fw-black text-dark text-uppercase small"><i class="fas fa-map-marker-alt me-1 text-secondary"></i> Lieu de la réunion *</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0 text-secondary"><i class="fas fa-building"></i></span>
                            <input type="text" name="lieu" id="lieu_reunion" class="form-control border-0 bg-light fw-bold text-dark p-3" value="{{ old('lieu') }}" placeholder="ex: Salle de conférence principale ou Bouaké Belleville..." required>
                            <span class="btn btn-outline-danger bg-white border-0 d-flex align-items-center px-4" style="cursor: pointer !important;" onclick="openGoogleMaps()">
                                <i class="fab fa-google text-danger me-2"></i> Maps
                            </span>
                        </div>
                    </div>

                    <!-- Animateur -->
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 shadow-sm h-100" style="background-color: #eef2ff; border-left: 6px solid #6366f1;">
                            <label class="form-label fw-black text-indigo text-uppercase small"><i class="fas fa-microphone me-2"></i> Animateur Principal *</label>
                            <select name="animateur_id" class="form-select select2 border-0 bg-white fw-bold shadow-sm" required style="border-radius: 8px;">
                                <option value="">-- Choisir un collaborateur --</option>
                                @foreach($agents->sortBy('last_name') as $agent)
                                    <option value="{{ $agent->id }}" {{ old('animateur_id') == $agent->id ? 'selected' : '' }}>
                                        {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Rédacteur -->
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 shadow-sm h-100" style="background-color: #ecfdf5; border-left: 6px solid #10b981;">
                            <label class="form-label fw-black text-success text-uppercase small"><i class="fas fa-pen-nib me-2"></i> Rédacteur du Secrétariat *</label>
                            <select name="redacteur_id" class="form-select select2 border-0 bg-white fw-bold shadow-sm" required style="border-radius: 8px;">
                                <option value="">-- Choisir le rapporteur --</option>
                                @foreach($agents->sortBy('last_name') as $agent)
                                    <option value="{{ $agent->id }}" {{ old('redacteur_id') == $agent->id ? 'selected' : '' }}>
                                        {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Ordre du jour -->
                    <div class="col-12">
                        <label class="form-label fw-black text-dark text-uppercase small"><i class="fas fa-list-ol me-1 text-warning"></i> Ordre du jour / Contexte</label>
                        <textarea name="ordre_du_jour" class="form-control border-2 shadow-sm p-3" rows="3" placeholder="Saisissez les différents points à aborder..." style="border-radius: 12px; border-color: #e2e8f0;">{{ old('ordre_du_jour') }}</textarea>
                    </div>

                    <!-- Participants Internes -->
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-4 shadow-sm border border-primary h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-black text-primary text-uppercase small mb-0">
                                    <i class="fas fa-users-cog me-2"></i> 1. Participants Internes
                                </label>
                                <span class="badge bg-primary text-white rounded-pill px-3" id="count-internes">0 sélection</span>
                            </div>

                            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-2">
                                <div class="card-header border-0 py-2 px-3" style="background: linear-gradient(45deg, #6366f1, #818cf8);">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-0 text-muted"><i class="fas fa-search"></i></span>
                                        <input type="text" id="searchAgent" class="form-control border-0" placeholder="Filtrer par nom de collaborateur...">
                                    </div>
                                </div>
                                <div class="card-body p-2 bg-light">
                                    <div id="agents-list" style="max-height: 250px; overflow-y: auto; padding-right: 4px;">
                                        @foreach($agents->sortBy('last_name') as $agent)
                                            <div class="agent-item d-flex align-items-center p-2 mb-2 rounded-3 bg-white border shadow-sm transition-all" style="border-left: 4px solid #6366f1 !important;">
                                                <div class="form-check m-0 px-3 d-flex align-items-center">
                                                    <input class="form-check-input agent-checkbox me-2" type="checkbox" name="participants[]" value="{{ $agent->id }}" id="agent_{{ $agent->id }}" {{ (collect(old('participants'))->contains($agent->id)) ? 'checked' : '' }} style="width: 1.25em; height: 1.25em; border: 2px solid #6366f1; cursor: pointer;">
                                                    <label class="form-check-label fw-bold text-dark cursor-pointer text-truncate" for="agent_{{ $agent->id }}" style="font-size: 0.9rem;">
                                                        {{ strtoupper($agent->last_name) }} <span class="fw-normal text-secondary">{{ $agent->first_name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Participants Externes Dynamique -->
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-4 shadow-sm border border-danger h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-black text-danger text-uppercase small mb-0">
                                    <i class="fas fa-user-plus me-2"></i> 2. Invités Externes (Hors Structure)
                                </label>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold shadow-sm" id="btn-add-externe">
                                    <i class="fas fa-plus me-1"></i> Ajouter une ligne
                                </button>
                            </div>

                            <div id="externes-container" style="max-height: 295px; overflow-y: auto; padding-right: 4px;">
                                {{-- Conteneur initialisé vide, alimenté par le JavaScript --}}
                                <div class="text-center py-4 text-muted border border-dashed rounded-3 bg-light shadow-inner" id="empty-externes-msg">
                                    <i class="fas fa-user-shield fa-2x opacity-25 mb-2"></i>
                                    <p class="small mb-0 italic">Aucun participant externe renseigné pour le moment.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons de soumission -->
                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <a href="{{ route('reunions.hebdo') }}" class="btn btn-outline-secondary rounded-pill px-5 fw-bold">
                        <i class="fas fa-arrow-left me-2"></i> Retour au calendrier
                    </a>
                    <button type="submit" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow-lg border-0" style="background: linear-gradient(90deg, #1e293b 0%, #0284c7 100%); transition: all 0.3s ease;">
                        <i class="fas fa-paper-plane me-2"></i> CONFIRMER ET LIER LA RÉUNION
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // === 1. GESTION DES PARTICIPANTS INTERNES ===
    const searchInput = document.getElementById('searchAgent');
    const agentItems = document.querySelectorAll('.agent-item');
    const internesCheckboxes = document.querySelectorAll('.agent-checkbox');
    const countInternesBadge = document.getElementById('count-internes');

    // Mise à jour du compteur
    function updateInternesCount() {
        const count = document.querySelectorAll('.agent-checkbox:checked').length;
        if(countInternesBadge) {
            countInternesBadge.textContent = `${count} sélection(s)`;
            countInternesBadge.style.backgroundColor = count > 0 ? '#ef4444' : '#64748b';
        }
    }

    // Recherche instantanée
    if(searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase().trim();
            agentItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? 'flex' : 'none';
            });
        });
    }

    // Écouteur changement sur checkbox
    internesCheckboxes.forEach(cb => cb.addEventListener('change', updateInternesCount));
    updateInternesCount(); // Initialisation


    // === 2. GESTION DES PARTICIPANTS EXTERNES ===
    const btnAddExterne = document.getElementById('btn-add-externe');
    const externesContainer = document.getElementById('externes-container');
    const emptyMsg = document.getElementById('empty-externes-msg');
    let externeIndex = Date.now(); // ID unique basé sur le temps

    function checkEmptyState() {
        const rows = externesContainer.querySelectorAll('.externe-row');
        if(emptyMsg) emptyMsg.style.display = rows.length === 0 ? 'block' : 'none';
    }

    if(btnAddExterne) {
        btnAddExterne.addEventListener('click', function() {
            const htmlRow = `
                <div class="externe-row card border-0 shadow-sm p-3 mb-3 bg-light rounded-3 position-relative animate__animated animate__fadeIn"
                     style="border-left: 4px solid #ef4444 !important;" id="externe_block_${externeIndex}">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 btn-remove-externe" style="font-size:0.8rem;"></button>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">NOM COMPLET *</label>
                            <input type="text" name="externes[${externeIndex}][nom_complet]" class="form-control form-control-sm bg-white border-1 fw-bold" placeholder="Nom de l'invité" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-black text-danger small mb-1"><i class="fas fa-university me-1"></i> ORIGINE / ORGANISME *</label>
                            <input type="text" name="externes[${externeIndex}][origine]" class="form-control form-control-sm bg-white border-danger-subtle fw-bold text-danger" placeholder="Organisme de provenance" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">TÉLÉPHONE</label>
                            <input type="text" name="externes[${externeIndex}][telephone]" class="form-control form-control-sm bg-white border-1" placeholder="Numéro de contact">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">EMAIL</label>
                            <input type="email" name="externes[${externeIndex}][email]" class="form-control form-control-sm bg-white border-1" placeholder="exemple@mail.com">
                        </div>
                    </div>
                </div>`;

            if(emptyMsg) emptyMsg.style.display = 'none';
            externesContainer.insertAdjacentHTML('beforeend', htmlRow);
            externeIndex++;
        });

        // Suppression dynamique
        externesContainer.addEventListener('click', function(e) {
            if(e.target.classList.contains('btn-remove-externe')) {
                const row = e.target.closest('.externe-row');
                row.classList.replace('animate__fadeIn', 'animate__fadeOut');
                setTimeout(() => {
                    row.remove();
                    checkEmptyState();
                }, 300);
            }
        });
    }
});

// === 3. UTILITAIRES EXTERNES ===
function openGoogleMaps() {
    const lieu = document.getElementById('lieu_reunion').value;
    if(lieu.trim() !== "") {
        window.open('https://google.com' + encodeURIComponent(lieu), '_blank');
    } else {
        alert("Veuillez d'abord renseigner le libellé du lieu.");
    }
}
</script>

<style>
    /* Typographie & Utilitaires */
    .fw-900 { font-weight: 900; }
    .fw-black { font-weight: 800; }
    .text-indigo { color: #4f46e5; }
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06); }

    /* Interaction Composants */
    .agent-item:hover { background-color: #eef2ff !important; transform: translateX(5px); }
    .btn:hover { transform: scale(1.05); transition: all 0.2s; }

    .agent-checkbox {
        width: 1.2em;
        height: 1.2em;
        cursor: pointer;
        border: 2px solid #6366f1 !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15) !important;
    }

    /* Scrollbars personnalisées */
    #agents-list::-webkit-scrollbar, #externes-container::-webkit-scrollbar { width: 6px; }
    #agents-list::-webkit-scrollbar-track, #externes-container::-webkit-scrollbar-track { background: #f1f1f1; }
    #agents-list::-webkit-scrollbar-thumb, #externes-container::-webkit-scrollbar-thumb {
        background: #6366f1;
        border-radius: 10px;
    }
</style>

@endsection

