@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe;">

    {{-- Alerte Mode Édition Orange --}}
    <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
            <i class="fas fa-edit text-warning"></i>
        </div>
        <div>
            <span class="fw-bold">Mode Édition :</span> Vous modifiez actuellement le séminaire <span class="badge bg-white text-dark shadow-sm">{{ $seminaire->titre }}</span>. Vérifiez bien les dates avant de valider.
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden text-start">
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #1e293b;">
            <h6 class="m-0 font-weight-bold text-white fs-5">
                <i class="fas fa-pen-fancy me-2 text-warning"></i> Modifier le séminaire
            </h6>
            <a href="{{ route('seminaires.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Retour à la liste</a>
        </div>

        <div class="card-body p-4 bg-white">
            <form action="{{ route('seminaires.update', $seminaire->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Thème / Titre -->
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark text-uppercase small">Thème ou Titre du séminaire</label>
                        <input type="text" name="titre" class="form-control border-0 bg-light fw-bold shadow-sm" value="{{ $seminaire->titre }}" required>
                    </div>

                    <!-- Date et Heure de Début -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-danger text-uppercase small">Date et Heure de Début</label>
                        <input type="datetime-local" name="date_debut" class="form-control border-0 shadow-sm text-danger fw-bold"
                               value="{{ \Carbon\Carbon::parse($seminaire->date_debut)->format('Y-m-d\TH:i') }}" required style="background-color: #fff1f2;">
                    </div>

                    <!-- Lieu du séminaire -->
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark text-uppercase small">Lieu de l'événement</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-0 text-danger">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" name="lieu" class="form-control border-0 bg-light fw-bold"
                                value="{{ $seminaire->lieu }}" placeholder="ex: Salle de conférence, Grand Bassam..." required>
                        </div>
                    </div>

                    <!-- Date et Heure de Fin -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark text-uppercase small opacity-75">Date et Heure de Fin</label>
                        <input type="datetime-local" name="date_fin" class="form-control border-0 shadow-sm fw-bold bg-light"
                               value="{{ \Carbon\Carbon::parse($seminaire->date_fin)->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <!-- Organisateur (Bleu Indigo) -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #eef2ff; border-left: 5px solid #6366f1;">
                            <label class="form-label fw-bold text-indigo"><i class="fas fa-building me-2"></i> Structure Organisatrice</label>
                            <input type="text" name="organisateur" class="form-control border-0 fw-bold bg-white" value="{{ $seminaire->organisateur }}" required>
                        </div>
                    </div>

                    <!-- Statut (Vert Emeraude) -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 h-100" style="background-color: #ecfdf5; border-left: 5px solid #10b981;">
                            <label class="form-label fw-bold text-success"><i class="fas fa-tasks me-2"></i> Statut actuel</label>
                            <select name="statut" class="form-select border-0 fw-bold bg-white">
                                <option value="planifie" {{ $seminaire->statut == 'planifie' ? 'selected' : '' }}>📅 Planifié</option>
                                <option value="en_cours" {{ $seminaire->statut == 'en_cours' ? 'selected' : '' }}>🔄 En Cours</option>
                                <option value="termine" {{ $seminaire->statut == 'termine' ? 'selected' : '' }}>✅ Terminé / Archivé</option>
                                <option value="annule" {{ $seminaire->statut == 'annule' ? 'selected' : '' }}>❌ Annulé</option>
                            </select>
                        </div>
                    </div>

                    <!-- Participants Attendus -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark text-uppercase small">Effectif attendu</label>
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-0 text-primary"><i class="fas fa-users"></i></span>
                            <input type="number" name="nb_participants_prevu" class="form-control border-0 bg-light fw-bold" value="{{ $seminaire->nb_participants_prevu }}">
                        </div>
                    </div>

                    <!-- Description / Objectifs -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark text-uppercase small">Description & Objectifs</label>
                        <textarea name="description" class="form-control border-0 shadow-sm bg-light rounded-3" rows="4">{{ $seminaire->description }}</textarea>
                    </div>

                    <hr class="my-4 opacity-10">

                    <!-- Boutons d'action -->
                    <div class="col-12 text-end">
                        <a href="{{ route('seminaires.index') }}" class="btn btn-light rounded-pill px-4 me-2 fw-bold text-muted">Annuler</a>
                        <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold text-white shadow-sm" style="background: linear-gradient(45deg, #f59e0b, #d97706); border: none;">
                            <i class="fas fa-check-circle me-1"></i> Mettre à jour le séminaire
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-indigo { color: #6366f1; }
    .rounded-4 { border-radius: 1rem !important; }
    .fw-black { font-weight: 800 !important; }
    input:focus, select:focus, textarea:focus {
        background-color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.1) !important;
        border: 1px solid #6366f1 !important;
    }
</style>
@endsection
