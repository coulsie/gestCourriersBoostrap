@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe;">

    {{-- Rappel pour la sélection multiple --}}
    <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
            <i class="fas fa-edit text-warning"></i>
        </div>
        <div>
            <span class="fw-bold">Mode Édition :</span> Modifiez les détails ci-dessous. N'oubliez pas de maintenir <kbd class="bg-white text-dark shadow-sm">Ctrl</kbd> pour modifier la liste des participants.
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #1e293b;">
            <h6 class="m-0 font-weight-bold text-white fs-5">
                <i class="fas fa-pen-fancy me-2 text-warning"></i> Modifier la réunion : {{ $reunion->objet }}
            </h6>
            <a href="{{ route('reunions.hebdo') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Retour</a>
        </div>

        <div class="card-body p-4 bg-white">
            {{-- ATTENTION : Ajout de enctype pour les fichiers --}}
            <form action="{{ route('reunions.update', $reunion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Objet -->
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark text-uppercase small">Objet de la réunion</label>
                        <input type="text" name="objet" class="form-control border-0 bg-light fw-bold" value="{{ $reunion->objet }}" required>
                    </div>

                    <!-- Date et Heure -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-danger text-uppercase small">Date et Heure</label>
                        <input type="datetime-local" name="date_heure" class="form-control border-0 shadow-sm text-danger fw-bold"
                               value="{{ \Carbon\Carbon::parse($reunion->date_heure)->format('Y-m-d\TH:i') }}" required style="background-color: #fff1f2;">
                    </div>

                    <!-- Lieu de la réunion -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark text-uppercase small">Lieu de la réunion</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <button type="button" class="input-group-text bg-white border-0 text-danger"
                                    onclick="ouvrirMaCarte()" title="Localiser sur Google Maps">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>
                            <input type="text" name="lieu" id="input-lieu-edit"
                                class="form-control border-0 bg-light fw-bold"
                                value="{{ $reunion->lieu }}"
                                placeholder="ex: Hôtel de Ville, Bouaké..." required>
                        </div>
                    </div>

                    <!-- Animateur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #eef2ff; border-left: 5px solid #6366f1;">
                            <label class="form-label fw-bold text-indigo"><i class="fas fa-microphone me-2"></i> Animateur</label>
                            <select name="animateur_id" class="form-select select2 border-0" required>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $reunion->animateur_id == $agent->id ? 'selected' : '' }}>
                                        {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Rédacteur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #ecfdf5; border-left: 5px solid #10b981;">
                            <label class="form-label fw-bold text-success"><i class="fas fa-pen-nib me-2"></i> Rédacteur</label>
                            <select name="redacteur_id" class="form-select select2 border-0" required>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $reunion->redacteur_id == $agent->id ? 'selected' : '' }}>
                                        {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Participants Internes -->
                    <!-- Participants Internes (Mode Cases à Cocher) -->

                    <!-- Participants Internes (Corrigé) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary"><i class="fas fa-users me-2"></i> Participants Internes</label>
                        <div class="card border shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-3">
                                <input type="text" id="searchAgent" class="form-control form-control-sm mb-3 border-0 bg-light" placeholder="🔍 Rechercher un agent...">

                                <div id="agents-list" style="max-height: 250px; overflow-y: auto; padding-left: 10px;">
                                    {{-- Tri alphabétique direct dans la vue --}}
                                    @foreach($agents->sortBy('last_name') as $agent)
                                        <div class="form-check mb-2 agent-item d-flex align-items-center">
                                            {{-- Case à cocher forcée avec style visible --}}
                                            <input class="form-check-input agent-checkbox" type="checkbox" name="participants[]"
                                                value="{{ $agent->id }}" id="agent_{{ $agent->id }}"
                                                style="width: 1.2em; height: 1.2em; cursor: pointer; border: 2px solid #6366f1;"
                                                {{ $reunion->participants->contains($agent->id) ? 'checked' : '' }}>

                                            <label class="form-check-label ms-3 fw-medium text-dark" for="agent_{{ $agent->id }}" style="cursor: pointer; flex-grow: 1;">
                                                <span class="fw-bold">{{ strtoupper($agent->last_name) }}</span> {{ $agent->first_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Footer avec Blanc sur Rouge en gras --}}
                            <div class="card-footer bg-light border-0 py-2 d-flex justify-content-between align-items-center">
                                <span class="small fw-bold text-muted">SÉLECTIONNÉS</span>
                                <span id="total-agents-count" class="badge rounded-pill px-3 py-2 fw-black shadow-sm"
                                    style="background-color: #ef4444; color: white; font-size: 1rem; min-width: 40px;">
                                    0
                                </span>
                            </div>
                        </div>
                    </div>



                    <!-- Participants Externes -->
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold text-warning">
                                <i class="fas fa-user-plus me-2"></i> Participants Externes
                            </label>
                            <button type="button" class="btn btn-sm btn-warning rounded-pill text-white fw-bold shadow-sm" onclick="addExterneRow()">
                                <i class="fas fa-plus me-1"></i> Ajouter
                            </button>
                        </div>

                        <div id="externes-container" class="p-2 border rounded-3 bg-white" style="max-height: 400px; overflow-y: auto;">
                            @foreach($reunion->listeExternes as $externe)
                                <div class="externe-row border-bottom mb-3 pb-3">
                                    {{-- ID pour la mise à jour --}}
                                    <input type="hidden" name="externes[{{ $externe->id }}][id]" value="{{ $externe->id }}">

                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Nom complet</label>
                                            <input type="text" name="externes[{{ $externe->id }}][nom_complet]" value="{{ $externe->nom_complet }}" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Structure / Origine</label>
                                            <input type="text" name="externes[{{ $externe->id }}][origine]" value="{{ $externe->origine }}" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Email</label>
                                            <input type="email" name="externes[{{ $externe->id }}][email]" value="{{ $externe->email }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="small text-muted fw-bold">Téléphone</label>
                                            <input type="text" name="externes[{{ $externe->id }}][telephone]" value="{{ $externe->telephone }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="this.closest('.externe-row').remove()" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ordre du jour -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark">Ordre du jour / Notes</label>
                        <textarea name="ordre_du_jour" class="form-control border-0 shadow-sm bg-light" rows="4">{{ $reunion->ordre_du_jour }}</textarea>
                    </div>

                    <hr class="my-4">

                    <!-- SECTION CLÔTURE (FICHIERS) -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark text-uppercase small">Statut de la réunion</label>
                        <select name="status" class="form-select border-0 shadow-sm fw-bold {{ $reunion->status == 'terminee' ? 'text-success' : 'text-primary' }}" style="background-color: #f8fafc;">
                            <option value="programmee" {{ $reunion->status == 'programmee' ? 'selected' : '' }}>📅 Programmée</option>
                            <option value="terminee" {{ $reunion->status == 'terminee' ? 'selected' : '' }}>✅ Terminée / Exécutée</option>
                            <option value="annulee" {{ $reunion->status == 'annulee' ? 'selected' : '' }}>❌ Annulée</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary text-uppercase small">Liste de présence (PDF/Scan)</label>
                        <input type="file" name="presence_file" class="form-control border-0 bg-light">

                        @if($reunion->presence_file)
                            <small class="text-success"><i class="fas fa-check"></i> Fichier actuel enregistré</small>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-success text-uppercase small">Rapport / Compte-rendu</label>
                        <input type="file" name="report_file" class="form-control border-0 bg-light">
                        @if($reunion->report_file)
                            <small class="text-success"><i class="fas fa-check"></i> Rapport déjà déposé</small>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Supprimer
                    </button>
                    <button type="submit" class="btn px-5 py-3 rounded-pill shadow-lg text-white fw-bold" style="background: linear-gradient(45deg, #3b82f6, #2563eb);">
                        <i class="fas fa-sync-alt me-2"></i> ENREGISTRER LES MODIFICATIONS
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// On initialise le compteur avec le nombre actuel d'externes présents en PHP
// On utilise Date.now() pour garantir que les nouveaux index ne télescopent jamais les anciens
let externeCounter = {{ $reunion->listeExternes->count() + 100 }};

function addExterneRow() {
    const container = document.getElementById('externes-container');
    const id = 'new_' + (externeCounter++); // Génère un ID unique comme "new_105"

    const html = `
        <div class="row g-2 mb-3 externe-row border-bottom pb-3 animate__animated animate__fadeIn">
            <!-- Pas d'ID pour les nouveaux, donc pas de champ caché 'id' -->

            <div class="col-md-4">
                <label class="small fw-bold text-muted">Nom complet</label>
                <input type="text" name="externes[${id}][nom_complet]" class="form-control form-control-sm border-0 shadow-sm" required>
            </div>
            <div class="col-md-4">
                <label class="small fw-bold text-muted">Structure / Origine</label>
                <input type="text" name="externes[${id}][origine]" class="form-control form-control-sm border-0 shadow-sm" required>
            </div>
            <div class="col-md-4">
                <label class="small fw-bold text-muted">Fonction</label>
                <input type="text" name="externes[${id}][fonction]" class="form-control form-control-sm border-0 shadow-sm">
            </div>

            <div class="col-md-5">
                <label class="small fw-bold text-muted">Email</label>
                <input type="email" name="externes[${id}][email]" class="form-control form-control-sm border-0 shadow-sm">
            </div>
            <div class="col-md-5">
                <label class="small fw-bold text-muted">Téléphone</label>
                <input type="text" name="externes[${id}][telephone]" class="form-control form-control-sm border-0 shadow-sm">
            </div>
            <div class="col-md-2 d-flex align-items-end justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-danger border-0 mb-1" onclick="this.closest('.externe-row').remove()">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    container.scrollTop = container.scrollHeight;
}
</script>


@push('scripts')
<script>
    function ouvrirMaCarte() {
        var lieuSaisi = document.getElementById('input-lieu-edit').value;
        if (lieuSaisi && lieuSaisi.trim() !== "") {
            var url = "https://google.com" + encodeURIComponent(lieuSaisi);
            window.open(url, '_blank');
        } else {
            alert("Veuillez saisir un lieu avant de cliquer.");
            document.getElementById('input-lieu-edit').focus();
        }
    }

    // Fonction pour mettre à jour le total des agents cochés
    function updateAgentCount() {
        const checkedCount = document.querySelectorAll('.agent-checkbox:checked').length;
        const display = document.getElementById('total-agents-count');
        if(display) {
            display.innerText = checkedCount;
            display.className = checkedCount > 0 ? 'badge bg-primary rounded-pill fs-6' : 'badge bg-danger rounded-pill fs-6';
        }
    }

    $(document).ready(function() {
    function updateAgentCount() {
        // Compte toutes les cases qui ont l'attribut 'checked'
        const checkedCount = $('.agent-checkbox:checked').length;
        $('#total-agents-count').text(checkedCount);
    }

    // Recherche instantanée
    $('#searchAgent').on('keyup', function() {
        const val = $(this).val().toLowerCase();
        $('.agent-item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(val));
        });
    });

    // Écouteur de changement sur les cases
    $('.agent-checkbox').on('change', function() {
        updateAgentCount();
    });

    // Lancer au démarrage pour les déjà cochés
    updateAgentCount();
});
</script>
@endpush

<style>
    .hover-bg-light:hover { background-color: #f8f9fa; }
    #agents-list::-webkit-scrollbar { width: 5px; }
    #agents-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>


@endsection
