@extends('layouts.app')

@section('content')
<!-- Import des icônes Bootstrap -->
<link rel="stylesheet" href="https://jsdelivr.net">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">

            <!-- Carte du formulaire avec bordure colorée haute -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé éclatant -->
                <div class="card-header border-0 p-4 text-white" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle me-3">
                            <i class="bi bi-pencil-square fs-3"></i>
                        </div>
                        <div>
                            <h1 class="h4 fw-black mb-0 text-white">Nouvelle Saisie</h1>
                            <p class="small mb-0 opacity-75 fw-medium">Rapport d'activité quotidien</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <!-- Message de succès stylisé -->
                    @if(session('success'))
                        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 mb-4 d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <span class="fw-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('activities.store') }}" method="POST">
                        @csrf

                        <!-- Sélection du Service -->
                        <div class="mb-4">
                            <label for="service_id" class="form-label small fw-black text-uppercase text-indigo tracking-wider">
                                <i class="bi bi-building me-1"></i> Votre Service
                            </label>
                            <select name="service_id" id="service_id" class="form-select custom-input py-3 shadow-none">
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="report_date" class="form-label small fw-black text-uppercase text-indigo tracking-wider">
                                <i class="bi bi-calendar-check me-1"></i> Date du rapport
                            </label>
                            <input type="date" name="report_date" id="report_date" value="{{ date('Y-m-d') }}"
                                   class="form-control custom-input py-3 shadow-none">
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="content" class="form-label small fw-black text-uppercase text-indigo tracking-wider">
                                <i class="bi bi-chat-left-text me-1"></i> Activités réalisées
                            </label>
                            <textarea name="content" id="content" rows="5"
                                      placeholder="Qu'avez-vous accompli aujourd'hui ?"
                                      class="form-control custom-input shadow-none"
                                      style="resize: none;"></textarea>
                        </div>

                        <!-- Bouton d'action éclatant -->
                        <div class="d-grid pt-2">
                            <button type="submit" class="btn btn-gradient-primary btn-lg rounded-pill fw-black shadow-lg py-3 border-0 transition-hover">
                                <i class="bi bi-cloud-upload me-2"></i> Enregistrer le rapport
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light border-0 py-4 text-center">
                    <a href="{{ route('activities.index') }}" class="text-decoration-none small fw-bold text-secondary hover-primary transition">
                        <i class="bi bi-arrow-left-circle me-2"></i> Retour au journal des activités
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Configuration des couleurs et polices */
    @import url('https://googleapis.com');

    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-black { font-weight: 800 !important; }
    .text-indigo { color: #6366f1; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Inputs personnalisés */
    .custom-input {
        background-color: #f8fafc;
        border: 2px solid #edf2f7;
        border-radius: 1rem;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        background-color: #ffffff;
        border-color: #a855f7;
        box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.1) !important;
    }

    /* Bouton avec dégradé */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
        color: white;
        transform: translateY(-2px);
    }

    /* Utilitaires */
    .rounded-4 { border-radius: 1.5rem !important; }
    .transition-hover { transition: all 0.3s ease; }
    .hover-primary:hover { color: #6366f1 !important; }
    .backdrop-blur { backdrop-filter: blur(10px); }
</style>
@endsection
