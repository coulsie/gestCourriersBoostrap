@extends('layouts.app')

@section('content')
<!-- Import des icônes Bootstrap -->
<link rel="stylesheet" href="https://jsdelivr.net">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- Lien de retour discret -->
            <div class="mb-4">
                <a href="{{ route('activities.index') }}" class="text-decoration-none fw-bold text-secondary small uppercase tracking-wider hover-orange transition">
                    <i class="bi bi-arrow-left-circle-fill me-2"></i> Annuler et retourner au journal
                </a>
            </div>

            <!-- Carte du formulaire -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé Orange Éclatant -->
                <div class="card-header border-0 p-4 text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle me-3">
                            <i class="bi bi-pencil-square fs-3 text-white"></i>
                        </div>
                        <div>
                            <h1 class="h4 fw-black mb-0 text-white uppercase tracking-tighter">Modifier la Saisie</h1>
                            <p class="small mb-0 opacity-75 fw-medium text-white">Rapport du {{ $activity->report_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Sélection du Service -->
                        <div class="mb-4">
                            <label class="form-label small fw-black text-uppercase text-muted tracking-widest mb-2">
                                <i class="bi bi-building me-1 text-orange"></i> Service concerné
                            </label>
                            <select name="service_id" class="form-select custom-input-edit py-3 shadow-none">
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ $activity->service_id == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label class="form-label small fw-black text-uppercase text-muted tracking-widest mb-2">
                                <i class="bi bi-calendar-event me-1 text-orange"></i> Date d'exécution
                            </label>
                            <input type="date" name="report_date" value="{{ $activity->report_date->format('Y-m-d') }}"
                                   class="form-control custom-input-edit py-3 shadow-none">
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label small fw-black text-uppercase text-muted tracking-widest mb-2">
                                <i class="bi bi-card-text me-1 text-orange"></i> Détails de l'activité
                            </label>
                            <textarea name="content" rows="7" class="form-control custom-input-edit shadow-none"
                                      style="resize: none;">{{ $activity->content }}</textarea>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row g-3 pt-2">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-orange btn-lg w-100 rounded-pill fw-black shadow-orange py-3 border-0 transition-hover">
                                    <i class="bi bi-check-lg me-2"></i> Enregistrer les modifications
                                </button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('activities.index') }}" class="btn btn-light btn-lg w-100 rounded-pill fw-bold py-3 text-muted">
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Configuration Typo et Couleurs */
    @import url('https://googleapis.com');

    body { background-color: #fcfcfc; font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-black { font-weight: 800 !important; }
    .text-orange { color: #f59e0b; }
    .tracking-widest { letter-spacing: 0.1em; }
    .tracking-tighter { letter-spacing: -0.03em; }

    /* Inputs Personnalisés (Thème Orange) */
    .custom-input-edit {
        background-color: #fff9f0;
        border: 2px solid #fef3c7;
        border-radius: 1rem;
        font-weight: 600;
        color: #451a03;
        transition: all 0.2s ease;
    }
    .custom-input-edit:focus {
        background-color: #ffffff;
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15) !important;
    }

    /* Bouton Orange Éclatant */
    .btn-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    .btn-orange:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: white;
        transform: translateY(-2px);
    }

    /* Utilitaires */
    .rounded-4 { border-radius: 1.5rem !important; }
    .shadow-orange { box-shadow: 0 10px 20px -5px rgba(217, 119, 6, 0.3); }
    .transition-hover { transition: all 0.3s ease; }
    .hover-orange:hover { color: #f59e0b !important; }
</style>
@endsection
