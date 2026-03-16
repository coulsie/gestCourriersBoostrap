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
                            <div class="col-md-5 mb-4">
                                <div class="p-4 bg-white rounded-3 shadow-sm h-100 border-top border-4 border-primary">
                                    <h5 class="text-primary mb-4 border-bottom pb-2 fw-bold">
                                        <i class="fas fa-folder-open me-2"></i> 1. Référence & Chronologie
                                    </h5>

                                    @if(isset($courrierSelectionne) || request('courrier_id'))
                                        @php
                                            $cId = request('courrier_id', $courrierSelectionne->id ?? '');
                                            $cRef = $courrierSelectionne->reference ?? 'Réimputation';
                                        @endphp
                                        <div class="mb-3 p-0 rounded-3 overflow-hidden border border-dark shadow-sm">
                                            <div class="bg-dark text-white p-2 px-3 d-flex justify-content-between align-items-center text-uppercase small fw-bold">
                                                <span><i class="fas fa-file-alt me-2"></i>Document</span>
                                                <span class="badge bg-primary shadow-sm">Réf: {{ $cRef }}</span>
                                            </div>
                                            <div class="p-3 text-white" style="background-color: #1e40af;">
                                                <label class="small fw-bold opacity-75 text-uppercase">Objet</label>
                                                <div class="fw-bold fs-6 text-truncate">
                                                    {{ $courrierSelectionne->objet ?? 'Chargement du document...' }}
                                                </div>
                                                <input type="hidden" name="courrier_id" value="{{ $cId }}">

                                                {{-- Affichage du bouton de consultation --}}
                                                @if($fichierAffiche)
                                                    <div class="mt-2 pt-2 border-top border-white-50">
                                                        <a href="{{ asset($fichierAffiche) }}" target="_blank" class="badge bg-danger text-decoration-none p-2 shadow-sm">
                                                            <i class="fas fa-file-pdf me-1"></i> CONSULTER LE FICHIER PRINCIPAL
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mt-2 small text-warning italic">
                                                        <i class="fas fa-exclamation-circle"></i> Aucun fichier lié
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Sélectionner le Courrier *</label>
                                            <select name="courrier_id" class="form-select border-primary shadow-sm @error('courrier_id') is-invalid @enderror" required>
                                                <option value="">-- Choisir --</option>
                                                @foreach($courriers as $courrier)
                                                    <option value="{{ $courrier->id }}" {{ old('courrier_id') == $courrier->id ? 'selected' : '' }}>
                                                        [{{ $courrier->reference }}] - {{ Str::limit($courrier->objet, 40) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Date Imputation *</label>
                                            <input type="date" name="date_imputation" class="form-control bg-light" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <!-- Champ Suivi Par -->
                                        <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase">
                                            <i class="fas fa-user-shield me-1 text-primary"></i> Supervisé / Suivi par
                                        </label>
                                        <select name="suivi_par" class="form-select border-primary shadow-sm @error('suivi_par') is-invalid @enderror">
                                            <option value="">-- Sélectionner un superviseur (Optionnel) --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('suivi_par') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('suivi_par')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase text-danger">Échéancier *</label>

                                        @php
                                            // 1. Chercher d'abord si on a une imputation parente (réimputation)
                                            // On suppose que $imputationParente est passée à la vue si request('parent_id') existe
                                            $dateHeritee = null;
                                            if(request('parent_id')) {
                                                $parente = \App\Models\Imputation::find(request('parent_id'));
                                                $dateHeritee = $parente ? $parente->echeancier : null;
                                            }

                                            // 2. Sinon, on prend l'échéance du courrier sélectionné
                                            if (!$dateHeritee && isset($courrierSelectionne)) {
                                                $dateHeritee = $courrierSelectionne->echeancier;
                                            }

                                            // 3. Définition de la valeur finale (Priorité : Session Old > Héritage > URL > Aujourd'hui)
                                            $finalDate = old('echeancier', $dateHeritee ?? request('echeancier', date('Y-m-d')));

                                            // Formatage pour l'input HTML
                                            $valueFormatted = \Carbon\Carbon::parse($finalDate)->format('Y-m-d');
                                        @endphp

                                        <input type="date"
                                            name="echeancier"
                                            class="form-control shadow-sm {{ request('parent_id') ? 'bg-light border-secondary text-muted fw-bold' : 'border-danger' }}"
                                            value="{{ $valueFormatted }}"
                                            @if(request('parent_id')) readonly @endif
                                            required>

                                        @if(request('parent_id'))
                                            <small class="text-danger fw-bold d-block mt-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-lock me-1"></i> ÉCHÉANCE HÉRITÉE DE L'IMPUTATION PRÉCÉDENTE
                                            </small>
                                        @endif
                                    </div>



                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Statut d'imputation *</label>
                                        <select name="statut" class="form-select bg-white border-primary shadow-sm" required>
                                            <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>🟠 En attente</option>
                                            <option value="en_cours" {{ request('parent_id') || old('statut') == 'en_cours' ? 'selected' : '' }}>🔵 En cours</option>
                                            <option value="termine" {{ old('statut') == 'termine' ? 'selected' : '' }}>🟢 Terminé</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Reste du formulaire (Agents et Section 3 Instructions) --}}
                            <!-- ... -->

                                                      <!-- SECTION 2 : DESTINATAIRES (AGENTS) -->
                            <div class="col-md-7 mb-4">
                                <div class="p-4 bg-white rounded-3 shadow-sm h-100 border-top border-4 border-warning">
                                    <h5 class="text-warning mb-4 border-bottom pb-2 fw-bold">
                                        <i class="fas fa-users me-2"></i> 2. Attribution aux Agents
                                    </h5>

                                    {{-- La suite de votre code pour les agents reste ici --}}

                                     <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Direction</label>
                                            <select id="filter_direction" class="form-select shadow-sm border-warning">
                                                <option value="">Toutes les Directions</option>
                                                @foreach($directions as $dir)
                                                    <option value="{{ $dir->id }}">{{ $dir->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Service</label>
                                            <select id="filter_service" class="form-select shadow-sm border-warning">
                                                <option value="">Tous les Services</option>
                                                @foreach($services as $ser)
                                                    <option value="{{ $ser->id }}" data-dir="{{ $ser->direction_id }}">{{ $ser->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Choisir l'Agent (ou les Agents) *</label>
                                        {{-- CORRECTION : Changement de user_id[] vers agent_ids[] --}}
                                        <select name="agent_ids[]" id="agent_select" class="form-select border-primary shadow-sm @error('agent_ids') is-invalid @enderror" multiple style="height: 160px;" required>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}"
                                                        data-dir="{{ $agent->service->direction_id ?? '' }}"
                                                        data-ser="{{ $agent->service_id ?? '' }}"
                                                        {{ (collect(old('agent_ids'))->contains($agent->id)) ? 'selected':'' }}>
                                                    {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                                    ({{ $agent->service->name ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-primary italic mt-1 d-block"><i class="fas fa-info-circle me-1"></i>Maintenez CTRL pour une sélection multiple.</small>
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
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Fichier Principal</label>
                                            <div class="p-2 bg-light border rounded small">
                                                <i class="fas fa-file-pdf text-danger me-1"></i>
                                                @if(request('chemin_fichier'))
                                                    Fichier lié : <a href="{{ asset(request('chemin_fichier')) }}" target="_blank" class="fw-bold">Voir le document original</a>
                                                @else
                                                    <span class="text-muted">Aucun fichier principal détecté</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <<div class="d-flex justify-content-between mt-4 pt-3 border-top">
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
    // --- 1. VOTRE SCRIPT DE FILTRAGE EXISTANT ---
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

    // --- 2. NOUVELLE LOGIQUE DE VÉRIFICATION DES INTÉRIMS ---

    // --- 2. LOGIQUE DE VÉRIFICATION DES INTÉRIMS ---

const formImputation = document.getElementById('formImputation');

formImputation.addEventListener('submit', function(e) {
    // 1. On empêche la soumission immédiate
    e.preventDefault();

    const formData = new FormData(this);

    // 2. Appel AJAX vers votre route de contrôle
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
        // 3. Si des intérims sont trouvés, on affiche la modale
        if (data.replacements && data.replacements.length > 0) {
            let html = `
                <div class="alert alert-warning border-0 shadow-sm mb-3">
                    <i class="fas fa-user-clock me-2"></i>
                    <strong>Attention :</strong> Des agents sélectionnés sont actuellement absents.
                </div>`;

            data.replacements.forEach(item => {
                html += `
                    <div class="p-3 mb-2 bg-light border-start border-4 border-primary rounded shadow-sm">
                        Compte tenu de l'absence de <strong>${item.titulaire}</strong>,
                        l'intérim est assuré par <strong>${item.interimaire}</strong>
                        du <span class="badge bg-secondary text-white">${item.debut}</span>
                        au <span class="badge bg-secondary text-white">${item.fin}</span>.
                    </div>`;
            });

            document.getElementById('interimInfoBody').innerHTML = html;

            // Affichage de la modale Bootstrap
            const interimModal = new bootstrap.Modal(document.getElementById('confirmInterimModal'));
            interimModal.show();
        } else {
            // 4. Aucun intérim : on soumet le formulaire normalement
            this.submit();
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        this.submit(); // En cas de bug, on laisse passer par sécurité
    });
});

/**
 * Fonction appelée par le bouton "OK" de votre modale
 */
function submitImputationForm() {
    document.getElementById('formImputation').submit();
}
</script>
@endsection


