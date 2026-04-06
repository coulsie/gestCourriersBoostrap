@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe;">

    {{-- Bulle d'info Flashy (Adaptée aux Séminaires) --}}
    <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: white;">
        <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
            <i class="fas fa-graduation-cap text-primary"></i>
        </div>
        <div>
            <span class="fw-bold">Gestion des participants :</span> Pour inscrire plusieurs agents à ce séminaire, maintenez la touche <kbd class="bg-white text-dark shadow-sm fw-bold border-0">Ctrl</kbd> (ou <kbd class="bg-white text-dark shadow-sm fw-bold border-0">Cmd</kbd>) enfoncée lors de la sélection.
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        {{-- Header Sombre & Info --}}
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: linear-gradient(45deg, #1e293b, #334155);">
            <h6 class="m-0 font-weight-bold text-white fs-5">
                <i class="fas fa-chalkboard-teacher me-2 text-info"></i> Organiser un nouveau séminaire
            </h6>
            <span class="badge bg-info text-dark rounded-pill px-3">Formation / Travail</span>
        </div>

        <div class="card-body p-4 bg-white">
            <form action="{{ route('seminaires.store') }}" method="POST">
                @csrf
                <div class="row g-4">

                    <!-- Titre du Séminaire -->
                    <div class="col-md-8">
                        <label class="form-label fw-black text-dark text-uppercase small">Titre / Thème du Séminaire</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-primary"><i class="fas fa-bookmark"></i></span>
                            <input type="text" name="titre" class="form-control border-start-0 ps-0 bg-light fw-bold" placeholder="ex: Renforcement des capacités sur la fiscalité numérique" required style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>

                    <!-- Période (Date Début) -->
                    <div class="col-md-4">
                        <label class="form-label fw-black text-danger text-uppercase small">Date et Heure de Début</label>
                        <input type="datetime-local" name="date_debut" class="form-control border-0 shadow-sm text-danger fw-bold" required style="background-color: #fff1f2;">
                    </div>

                    <!-- Lieu du Séminaire -->
                    <div class="col-md-8">
                        <label class="form-label fw-black text-dark text-uppercase small">Lieu du séminaire</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light border-end-0 text-secondary">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" name="lieu" id="lieu_seminaire" class="form-control border-start-0 ps-0 bg-light fw-bold" placeholder="ex: Salle de conférence, Grand-Bassam..." required>
                            <span class="btn btn-outline-danger bg-white border-start-0 d-flex align-items-center" style="cursor: pointer !important;" onclick="window.open('https://https://www.google.com/maps' + document.getElementById('lieu_seminaire').value)">
                                <i class="fab fa-google text-danger me-1"></i> Maps
                            </span>
                        </div>
                    </div>

                    <!-- Date Fin -->
                    <div class="col-md-4">
                        <label class="form-label fw-black text-primary text-uppercase small">Date et Heure de Fin</label>
                        <input type="datetime-local" name="date_fin" class="form-control border-0 shadow-sm text-primary fw-bold" required style="background-color: #eff6ff;">
                    </div>

                    <!-- Organisateur (Structure) -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #fef3c7; border-left: 5px solid #f59e0b;">
                            <label class="form-label fw-bold text-warning" style="color: #d97706 !important;"><i class="fas fa-building me-2"></i> Structure Organisatrice</label>
                            <input type="text" name="organisateur" class="form-control border-0 shadow-none bg-white fw-bold" placeholder="ex: DSESF / Partenaire extérieur" required>
                        </div>
                    </div>

                    <!-- Responsable / Animateur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #eef2ff; border-left: 5px solid #6366f1;">
                            <label class="form-label fw-bold text-indigo"><i class="fas fa-user-tie me-2"></i> Responsable DSESF</label>
                            <select name="responsable_id" class="form-select select2 shadow-none border-0" required>
                                <option value="">Sélectionner le pilote...</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Statut -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary"><i class="fas fa-info-circle me-2"></i> Statut du séminaire</label>
                        <select name="statut" class="form-select border-0 shadow-sm bg-light fw-bold">
                            <option value="planifie">📅 Planifié</option>
                            <option value="en_cours">🔄 En cours</option>
                            <option value="termine">✅ Terminé</option>
                            <option value="annule">❌ Annulé</option>
                        </select>
                    </div>
                    <!-- Effectif Attendu (Nombre de participants prévu) -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #f0fdfa; border-left: 5px solid #14b8a6;">
                            <label class="form-label fw-bold text-teal" style="color: #0d9488 !important;">
                                <i class="fas fa-users-cog me-2"></i> Effectif attendu
                            </label>
                            <div class="input-group">
                                <input type="number" name="nb_participants_prevu" class="form-control border-0 shadow-none bg-white fw-bold"
                                    placeholder="Ex: 25" min="0" required>
                                <span class="input-group-text bg-white border-0 fw-bold text-muted">Personnes</span>
                            </div>
                        </div>
                    </div>


                    <!-- Objectifs & Description -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark"><i class="fas fa-align-left me-2 text-secondary"></i> Objectifs & Description du séminaire</label>
                        <textarea name="description" class="form-control border-0 shadow-sm bg-light" rows="4" placeholder="Quels sont les objectifs et les résultats attendus ?"></textarea>
                    </div>
                </div>

                {{-- Footer & Actions --}}
                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <a href="{{ route('seminaires.index') }}" class="btn btn-link text-secondary text-decoration-none fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow-lg border-0" style="background: linear-gradient(45deg, #4361ee, #4cc9f0);">
                        <i class="fas fa-check-circle me-2"></i> ENREGISTRER LE SÉMINAIRE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Intégration du style fw-black pour la cohérence */
    .fw-black { font-weight: 900 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .text-indigo { color: #4361ee; }

    /* Animation légère sur le bouton */
    .btn-primary:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3) !important;
    }
</style>
@endsection
