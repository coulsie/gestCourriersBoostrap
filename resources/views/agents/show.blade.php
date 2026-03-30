@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <!-- Carte principale -->
            <div class="card shadow-lg border-0 rounded-xl overflow-hidden">

                {{-- Header Sombre & Contrasté --}}
                <div class="card-header bg-dark py-3 d-flex align-items-center justify-content-between border-bottom border-primary border-5">
                    <h5 class="mb-0 text-white fw-bold text-uppercase tracking-wider">
                        <i class="fas fa-id-badge me-2 text-warning"></i> Profil : {{ $agent->last_name }} {{ $agent->first_name }}
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('agents.index') }}" class="btn btn-outline-light btn-sm fw-bold">
                            <i class="fas fa-arrow-left me-1"></i> RETOUR
                        </a>

                        {{-- BOUTON MODALE INTERIM (Ajouté ici) --}}
                        @if(in_array($agent->status, ['Chef de service', 'Sous-directeur', 'Directeur']))


                            <button type="button"
                                    class="btn btn-info btn-sm fw-bold text-white shadow"
                                    data-toggle="modal"
                                    data-target="#modalInterim">
                                <i class="fas fa-user-shield me-1"></i> PROGRAMMER INTERIM
                            </button>


                        @endif



                        <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-warning btn-sm fw-bold text-dark shadow">
                            <i class="fas fa-edit me-1"></i> MODIFIER
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 bg-white">
                    {{-- Section En-tête : Photo et Identité --}}
                    <div class="row align-items-center mb-5 p-4 bg-light rounded-4 border border-2 border-primary-subtle shadow-sm">
                        <div class="col-md-3 text-center">
                            @if($agent->photo && file_exists(public_path('agents_photos/' . $agent->photo)))
                               <img src="{{ asset('agents_photos/' . $agent->photo) }}?v={{ time() }}"
                                    alt="Photo de {{ $agent->last_name }}"
                                    class="img-fluid rounded-4 border border-4 border-primary shadow-lg mb-3 mb-md-0"
                                    style="width: 180px; height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white p-5 rounded-4 mb-3 mb-md-0 mx-auto d-flex align-items-center justify-content-center shadow" style="width: 180px; height: 180px;">
                                    <i class="fas fa-user fa-5x"></i>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-9 px-md-4">
                            <h2 class="fw-bolder text-primary text-uppercase mb-1">{{ $agent->last_name }} {{ $agent->first_name }} </h2>
                            <h5 class="text-secondary fw-bold mb-4">Matricule : <span class="badge bg-dark text-white px-3">{{ $agent->matricule }}</span></h5>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="p-2 bg-white border-start border-4 border-primary rounded shadow-sm">
                                        <small class="text-muted fw-bold d-block text-uppercase">Statut Actuel</small>
                                        <span class="fw-bolder text-dark">{{ $agent->status }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-2 bg-white border-start border-4 border-info rounded shadow-sm">
                                        <small class="text-muted fw-bold d-block text-uppercase">Genre / Sexe</small>
                                        <span class="fw-bolder text-dark">{{ $agent->sexe }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Grille d'informations détaillées --}}
                    <div class="row g-4">
                        {{-- Coordonnées --}}
                        <div class="col-md-6">
                            <div class="h-100 p-4 border-start border-5 border-success bg-light rounded shadow-sm">
                                <h5 class="text-success fw-bold mb-4 border-bottom border-2 pb-2 text-uppercase">
                                    <i class="fas fa-address-book me-2"></i> Coordonnées
                                </h5>
                                <p class="mb-3"><strong><i class="fas fa-envelope me-2 text-success"></i> Email Professionnel :</strong> <span class="text-dark">{{ $agent->email_professionnel }}</span></p>
                                <p class="mb-3"><strong><i class="fas fa-envelope me-2 text-success"></i> Email :</strong> <span class="text-dark">{{ $agent->email }}</span></p>
                                <p class="mb-3"><strong><i class="fas fa-phone me-2 text-success"></i> Téléphone :</strong> <span class="text-dark fw-bold">{{ $agent->phone_number }}</span></p>
                                <p class="mb-0"><strong><i class="fas fa-map-marker-alt me-2 text-success"></i> Adresse :</strong> <span class="text-dark">{{ $agent->address }}</span></p>
                            </div>
                        </div>

                        {{-- Poste & Service --}}
                        <div class="col-md-6">
                            <div class="h-100 p-4 border-start border-5 border-primary bg-light rounded shadow-sm">
                                <h5 class="text-primary fw-bold mb-4 border-bottom border-2 pb-2 text-uppercase">
                                    <i class="fas fa-briefcase me-2"></i> Poste & Service
                                </h5>
                                <p class="mb-2"><strong>Service :</strong>
                                    @if($agent->service)
                                        <span class="badge bg-primary text-white px-2 py-1">{{ $agent->service->name }}</span>
                                    @else
                                        <span class="text-danger fw-bold">Non affecté</span>
                                    @endif
                                </p>
                                <p class="mb-2"><strong>Emploi :</strong> <span class="text-dark fw-bold">{{ $agent->Emploi }}</span></p>
                                <p class="mb-2"><strong>Grade :</strong> <span class="badge bg-success text-white">{{ $agent->Grade ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALE DE PROGRAMMATION D'INTERIM --}}
{{-- MODALE DE PROGRAMMATION D'INTERIM --}}
{{-- MODALE DE PROGRAMMATION D'INTERIM --}}
<form id="formInterimReal" action="{{ route('interims.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="modalInterim" tabindex="-1" aria-labelledby="modalInterimLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold" id="modalInterimLabel">
                        <i class="fas fa-user-shield me-2"></i> Programmer un Intérim
                    </h5>
                    {{-- Bouton X de fermeture --}}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-start">
                    {{-- AFFICHAGE DES ERREURS DE VALIDATION (Laravel) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0 small fw-bold">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- ID du titulaire (caché) -->
                    <input type="hidden" name="agent_id" value="{{ $agent->id }}">

                    <div class="alert alert-light border mb-4">
                        <small class="text-muted d-block text-uppercase fw-bold">Titulaire remplacé :</small>
                        <span class="text-dark fw-bold">{{ $agent->last_name }} {{ $agent->first_name }} ({{ $agent->status }})</span>
                    </div>

                    <!-- Choix de l'intérimaire -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Choisir l'intérimaire</label>
                        <select name="interimaire_id" id="select_interimaire" class="form-select shadow-sm border-primary" required>
                            <option value="">-- Sélectionner l'agent remplaçant --</option>
                            @foreach($tousLesAgents as $autre)
                                @if($autre->id !== $agent->id)
                                    <option value="{{ $autre->id }}">
                                        {{ $autre->last_name }} {{ $autre->first_name }} ({{ $autre->status }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Dates de l'intérim -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Date de début</label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control shadow-sm" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Date de fin</label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control shadow-sm" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    {{-- BOUTON ANNULER CORRIGÉ (Double data pour compatibilité BS4/BS5) --}}
                    <button type="button" class="btn btn-secondary fw-bold shadow-sm" data-bs-dismiss="modal" data-dismiss="modal">ANNULER</button>

                    <!-- Bouton de soumission lié au script JS -->
                    <button type="button" id="btnSubmitInterimForce" class="btn btn-info text-white fw-bold shadow-sm px-4">
                        <i class="fas fa-check-circle me-1"></i> CONFIRMER L'INTÉRIM
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    $(document).on('click', '#btnSubmitInterimForce', function(e) {
        e.preventDefault();

        const form = document.getElementById('formInterimReal');
        const agent = document.getElementById('select_interimaire').value;
        const debut = document.getElementById('date_debut').value;
        const fin = document.getElementById('date_fin').value;

        // VALIDATION JAVASCRIPT AVANT ENVOI
        if (!agent || !debut || !fin) {
            alert("⚠️ Champs obligatoires : Veuillez sélectionner un intérimaire et définir les dates de début et de fin.");
            return false;
        }

        // Si tout est rempli, on soumet le formulaire
        form.submit();
    });
</script>
@endpush




@endsection
