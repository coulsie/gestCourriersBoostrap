@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <!-- Diagnostic des erreurs -->
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-start border-4 border-danger mb-4">
                    <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Erreurs de saisie :</h6>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    <h4 class="mb-0 font-weight-bold">
                        <i class="fas fa-file-signature me-2"></i>
                        {{ request('parent_id') ? 'FORMULAIRE DE RÉIMPUTATION' : "FORMULAIRE D'IMPUTATION OFFICIELLE (2026)" }}
                    </h4>
                </div>

                <div class="card-body p-4" style="background-color: #f8fafc;">


                    <form id="formImputation" action="{{ route('imputations.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <!-- CHAMPS TECHNIQUES -->
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
                        {{-- Cette ligne est CRUCIALE pour récupérer le fichier lors de la réimputation --}}
                        <input type="hidden" name="chemin_fichier" value="{{ request('chemin_fichier', $courrierSelectionne->fichier_chemin ?? '') }}">



                        @php
                            $userRole = auth()->user()->role;
                            $niveauEnum = match($userRole) {
                                'Directeur' => 'tertiaire',
                                'Chef de Service' => 'secondaire',
                                default => 'primaire'
                            };

                            // Détection forcée du fichier
                            $fichierAffiche = request('chemin_fichier') ?: ($courrierSelectionne->fichier_chemin ?? null);
                        @endphp

                        <input type="hidden" name="niveau" value="{{ $niveauEnum }}">
                        <input type="hidden" name="chemin_fichier" value="{{ $fichierAffiche }}">

                        <div class="row">
                            <!-- SECTION 1 : DOCUMENTS & DATES -->
                            <!-- SECTION 1 : DOCUMENTS & DATES -->
<div class="col-md-5 mb-4">
    <div class="p-4 bg-white rounded-4 shadow-sm h-100 border-top border-4 border-primary">
        <h5 class="text-primary mb-4 border-bottom pb-2 fw-bold">
            <i class="fas fa-folder-open me-2"></i> 1. Référence & Chronologie
        </h5>

        {{-- BLOC INFO COURRIER --}}
        @if(isset($courrierSelectionne) || request('courrier_id'))
            @php
                $cId = request('courrier_id', $courrierSelectionne->id ?? '');
                $cRef = $courrierSelectionne->reference ?? 'Réimputation';
            @endphp
            <div class="mb-4 rounded-4 overflow-hidden border-0 shadow-sm">
                <div class="bg-primary text-white p-2 px-3 d-flex justify-content-between align-items-center text-uppercase small fw-bold">
                    <span><i class="fas fa-file-alt me-2"></i>Document Source</span>
                    <span class="badge bg-white text-primary">Réf: {{ $cRef }}</span>
                </div>
                <div class="p-3 bg-light border-start border-end border-bottom rounded-bottom-4">
                    <label class="small fw-bold text-muted text-uppercase mb-1 d-block">Objet du courrier</label>
                    <div class="fw-bold text-dark mb-2" style="font-size: 0.95rem; line-height: 1.4;">
                        {{ $courrierSelectionne->objet ?? 'Chargement du document...' }}
                    </div>
                    <input type="hidden" name="courrier_id" value="{{ $cId }}">

                    {{-- Action Fichier --}}
                    @if($fichierAffiche)
                        <a href="{{ asset($fichierAffiche) }}" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm mt-1">
                            <i class="fas fa-file-pdf me-1"></i> Consulter le document
                        </a>
                    @else
                        <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i> Aucun fichier joint</span>
                    @endif
                </div>
            </div>
        @else
            <div class="mb-4">
                <label class="form-label fw-black text-dark small text-uppercase">Sélectionner le Courrier *</label>
                <select name="courrier_id" class="form-select border-primary shadow-sm @error('courrier_id') is-invalid @enderror select2" required>
                    <option value="">-- Choisir un dossier --</option>
                    @foreach($courriers as $courrier)
                        <option value="{{ $courrier->id }}" {{ old('courrier_id') == $courrier->id ? 'selected' : '' }}>
                            [{{ $courrier->reference }}] - {{ Str::limit($courrier->objet, 50) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- BLOC DATES & SUPERVISION --}}
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold small text-muted text-uppercase">Date Imputation *</label>
                <input type="date" name="date_imputation" class="form-control border-0 bg-light fw-bold" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-danger text-uppercase">Échéancier *</label>
                @php
                    $dateHeritee = null;
                    if(request('parent_id')) {
                        $parente = \App\Models\Imputation::find(request('parent_id'));
                        $dateHeritee = $parente ? $parente->echeancier : null;
                    }
                    if (!$dateHeritee && isset($courrierSelectionne)) {
                        $dateHeritee = $courrierSelectionne->echeancier;
                    }
                    $finalDate = old('echeancier', $dateHeritee ?? request('echeancier', date('Y-m-d')));
                    $valueFormatted = \Carbon\Carbon::parse($finalDate)->format('Y-m-d');
                @endphp
                <input type="date" name="echeancier"
                       class="form-control fw-bold {{ request('parent_id') ? 'bg-light border-0 text-muted' : 'border-danger' }}"
                       value="{{ $valueFormatted }}" required>
            </div>

            <div class="col-12 mt-3">
                <div class="p-3 rounded-3" style="background-color: #f0f7ff; border-left: 4px solid #007bff;">
                    <label class="form-label fw-bold small text-primary text-uppercase">
                        <i class="fas fa-user-shield me-1"></i> Supervisé / Suivi par
                    </label>
                    <select name="suivi_par" class="form-select border-0 bg-transparent fw-bold @error('suivi_par') is-invalid @enderror select2">
                        <option value="">-- Responsable du suivi (Optionnel) --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('suivi_par') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>


                            {{-- Reste du formulaire (Agents et Section 3 Instructions) --}}
                            <!-- ... -->

                         <!-- SECTION 2 : DESTINATAIRES (AGENTS) -->
                           <!-- SECTION 2 : ATTRIBUTION AUX AGENTS -->
<div class="col-md-7 mb-4">
    <div class="p-4 bg-white rounded-4 shadow-sm h-100 border-top border-4 border-warning">
        <h5 class="text-warning mb-4 border-bottom pb-2 fw-bold">
            <i class="fas fa-users me-2"></i> 2. Attribution & Destinataires
        </h5>

        {{-- FILTRES RAPIDES --}}
        <div class="row g-2 mb-3 p-2 rounded-3 bg-light">
            <div class="col-md-6">
                <select id="filter_direction" class="form-select form-select-sm border-0 shadow-sm">
                    <option value="">Toutes les Directions</option>
                    @foreach($directions as $dir)
                        <option value="{{ $dir->id }}">{{ $dir->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select id="filter_service" class="form-select form-select-sm border-0 shadow-sm">
                    <option value="">Tous les Services</option>
                    @foreach($services as $ser)
                        <option value="{{ $ser->id }}" data-dir="{{ $ser->direction_id }}">{{ $ser->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- LISTE DES AGENTS --}}
        <div class="mb-0">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label fw-black text-dark small text-uppercase mb-0">Choisir les Agents *</label>
                <span class="badge bg-warning text-dark rounded-pill" id="selected-count">0 sélection</span>
            </div>

            <div id="agent-checkbox-list" class="border rounded-3 p-2 bg-white" style="max-height: 320px; overflow-y: auto;">
                @foreach($agents->sortBy('last_name') as $agent)
                    <div class="agent-item p-2 mb-1 rounded-2 border-bottom transition-all"
                         data-dir="{{ $agent->service->direction_id ?? '' }}"
                         data-ser="{{ $agent->service_id ?? '' }}"
                         style="cursor: pointer;">
                        <div class="form-check custom-checkbox d-flex align-items-center">
                            <input class="form-check-input agent-checkbox me-3" type="checkbox"
                                   name="agent_ids[]" value="{{ $agent->id }}" id="ag_{{ $agent->id }}"
                                   {{ (collect(old('agent_ids'))->contains($agent->id)) ? 'checked' : '' }}>
                            <label class="form-check-label w-100 mb-0" for="ag_{{ $agent->id }}" style="cursor: pointer;">
                                <div class="fw-bold text-dark">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</div>
                                <div class="text-muted small italic">{{ $agent->service->name ?? 'N/A' }}</div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


                        </div>

                        <!-- 3 : TRAITEMENT -->
                        <!--  3 : TRAITEMENT -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-4 bg-white rounded-3 shadow-sm border-top border-4 border-success">
                                    <h5 class="text-success mb-3 border-bottom pb-2 fw-bold">
                                        <i class="fas fa-edit me-2"></i> 3. Instructions & Annexes
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Instructions</label>
                                            {{-- On récupère les instructions de l'URL si elles existent --}}
                                            <textarea name="instructions" class="form-control mb-3" rows="3" placeholder="Directives à suivre...">{{ request('instructions', old('instructions')) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Observations</label>
                                            <textarea name="observations" class="form-control mb-3" rows="3" placeholder="Remarques éventuelles...">{{ old('observations') }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Documents Annexes</label>
                                            <input type="file" name="documents_annexes" class="form-control shadow-sm">

                                            {{-- Affichage de l'annexe parente si elle existe --}}
                                            @if(request('doc_annexe'))
                                                <div class="mt-2 p-2 bg-light border rounded small">
                                                    <i class="fas fa-paperclip text-primary me-1"></i>
                                                    Annexe actuelle : <a href="{{ asset(request('doc_annexe')) }}" target="_blank" class="fw-bold">Consulter l'annexe</a>
                                                    <input type="hidden" name="old_annexe" value="{{ request('doc_annexe') }}">
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Rappel du fichier principal --}}
                                        {{-- Rappel du fichier principal --}}
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                            {{-- Définit le statut par défaut à 'En attente' pour valider le store --}}

                            {{-- Utilisez la valeur exacte définie dans votre ENUM (minuscules et underscore) --}}
                            <input type="hidden" name="statut" value="en_attente">


                            {{-- Champ user_id également requis par votre validation --}}
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            {{-- Champ niveau (sera recalculé dans le store, mais requis pour passer la validation) --}}
                            <input type="hidden" name="niveau" value="autre">
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('courriers.index') }}" class="btn btn-outline-secondary px-4 fw-bold">ANNULER</a>

                            <!-- Nouveau bouton qui déclenche la vérification JavaScript -->
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                <i class="fas fa-check-circle me-1"></i> Enregistrer l'imputation
                            </button>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modale de confirmation (à placer idéalement juste avant le ) -->
<div class="modal fade" id="confirmInterimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-info-circle me-2"></i> Information d'Intérim
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="interimInfoBody" class="modal-body py-4">
                <!-- Le message dynamique sera injecté ici -->
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal" data-dismiss="modal">
                    Annuler
                </button>

                <button type="button" onclick="submitImputationForm()" class="btn btn-warning fw-bold px-4 shadow-sm">
                    OK, CONTINUER
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- 1. SCRIPT DE FILTRAGE EXISTANT ---
    const dirF = document.getElementById('filter_direction');
    const serF = document.getElementById('filter_service');
    const agS = document.getElementById('agent_select');
    const agOpts = Array.from(agS.options);

    function filter() {
        const d = dirF.value;
        const s = serF.value;

        Array.from(serF.options).forEach(o => {
            if(o.value === "") return;
            o.style.display = (d === "" || o.dataset.dir === d) ? "block" : "none";
        });

        agOpts.forEach(o => {
            const mD = d === "" || o.dataset.dir === d;
            const mS = s === "" || o.dataset.ser === s;
            o.style.display = (mD && mS) ? "block" : "none";
        });
    }

    dirF.addEventListener('change', () => { serF.value = ""; filter(); });
    serF.addEventListener('change', filter);

    // --- 2. LOGIQUE DE VÉRIFICATION DES INTÉRIMS (MODIFIÉE) ---
    const formImputation = document.getElementById('formImputation');

    formImputation.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("{{ route('imputations.check-interim') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.replacements && data.replacements.length > 0) {
                let html = `
                    <div class="alert alert-warning border-0 shadow-sm mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Des absences avec intérim ont été détectées.
                    </div>`;

                data.replacements.forEach(item => {
                    html += `
                        <div class="p-3 mb-2 bg-light border-start border-4 border-warning rounded shadow-sm">
                            Compte tenu de l'absence de <strong>${item.titulaire}</strong>,
                            l'intérim est assuré par <strong>${item.interimaire}</strong>
                            du <span class="badge bg-danger text-white px-2 fw-bold">${item.debut}</span>
                            au <span class="badge bg-danger text-white px-2 fw-bold">${item.fin}</span>.
                        </div>`;
                });

                document.getElementById('interimInfoBody').innerHTML = html;

                // Initialisation et affichage du modal
                const interimModal = new bootstrap.Modal(document.getElementById('confirmInterimModal'));
                interimModal.show();
            } else {
                this.submit();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            this.submit();
        });
    });

    /**
     * Fonction appelée par le bouton "OK" de la modale
     */
    function submitImputationForm() {
        document.getElementById('formImputation').submit();
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dirFilter = document.getElementById('filter_direction');
    const serFilter = document.getElementById('filter_service');
    const agentItems = document.querySelectorAll('.agent-item');
    const checkboxes = document.querySelectorAll('.agent-checkbox');
    const counter = document.getElementById('selected-count');

    // Fonction de filtrage
    function filterAgents() {
        const selectedDir = dirFilter.value;
        const selectedSer = serFilter.value;

        agentItems.forEach(item => {
            const itemDir = item.getAttribute('data-dir');
            const itemSer = item.getAttribute('data-ser');

            const matchDir = selectedDir === "" || itemDir === selectedDir;
            const matchSer = selectedSer === "" || itemSer === selectedSer;

            if (matchDir && matchSer) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    // Mise à jour du compteur
    function updateCounter() {
        const checkedCount = document.querySelectorAll('.agent-checkbox:checked').length;
        counter.textContent = `${checkedCount} sélectionné(s)`;
    }

    dirFilter.addEventListener('change', function() {
        // Filtrer aussi la liste des services
        const selectedDir = this.value;
        Array.from(serFilter.options).forEach(option => {
            if (option.value === "" || option.getAttribute('data-dir') === selectedDir) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
        serFilter.value = ""; // Reset service
        filterAgents();
    });

    serFilter.addEventListener('change', filterAgents);
    checkboxes.forEach(cb => cb.addEventListener('change', updateCounter));

    // Initialisation
    updateCounter();
});
</script>

@endsection


