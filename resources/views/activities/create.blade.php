@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5; min-height: 100vh;">

    <!-- Fil d'ariane / Retour -->
    <div class="mb-4">
        <a href="{{ route('activities.index') }}" class="btn btn-light shadow-sm rounded-pill px-3 border">
            <i class="fas fa-arrow-left me-2 text-primary"></i> Retour à la liste
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé -->
                <div class="card-header p-4 border-0" style="background: linear-gradient(45deg, #6366f1, #a855f7);">
                    <h4 class="mb-0 text-white fw-bold">
                        <i class="fas fa-plus-circle me-2"></i> Enregistrer une Nouvelle Activité
                    </h4>
                    <p class="text-white-50 small mb-0 mt-1">Définissez la période et l'avancement de la tâche.</p>
                </div>

                <div class="card-body p-4 bg-white">
                    <form action="{{ route('activities.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- SÉLECTION DU SERVICE -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-layer-group me-2 text-info"></i>Service Responsable</label>
                                <select name="service_id" class="form-select border-0 bg-light rounded-3 py-2 shadow-sm @error('service_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Choisir un service...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- TYPE D'ACTIVITÉ (PERMANENTE) -->
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-switch bg-light p-3 rounded-3 w-100 shadow-sm border">
                                    <input class="form-check-input ms-0 me-3" type="checkbox" name="is_permanent" id="isPermanent" value="1" {{ old('is_permanent') ? 'checked' : '' }} onchange="toggleEndDate()">
                                    <label class="form-check-label fw-bold text-primary" for="isPermanent">
                                        <i class="fas fa-sync-alt me-1"></i> Activité Permanente
                                    </label>
                                </div>
                            </div>

                            <!-- PLANIFICATION DES DATES -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-plus me-2 text-success"></i>Date de Début</label>
                                <input type="date" name="start_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-sm @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date', date('Y-m-d')) }}" required>
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4" id="endDateContainer">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-check me-2 text-danger"></i>Échéance (Fin)</label>
                                <input type="date" name="end_date" id="end_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-sm @error('end_date') is-invalid @enderror"
                                       value="{{ old('end_date') }}">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-file-alt me-2 text-muted"></i>Date du Rapport</label>
                                <input type="date" name="report_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-sm"
                                       value="{{ old('report_date', date('Y-m-d')) }}" required>
                            </div>

                            <!-- CONTENU / DESCRIPTION -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-align-left me-2 text-primary"></i>Description de l'activité</label>
                                <textarea name="content" rows="4" class="form-control border-0 bg-light rounded-3 shadow-sm @error('content') is-invalid @enderror"
                                          placeholder="Détaillez la mission ou les tâches accomplies..." required>{{ old('content') }}</textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- PROGRESSION -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-tasks me-2 text-warning"></i>Niveau de Progression (%)</label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="range" name="progress" class="form-range flex-grow-1" id="progressRange" min="0" max="100" step="5" value="{{ old('progress', 0) }}" oninput="this.nextElementSibling.value = this.value + '%'">
                                    <output class="badge bg-dark fs-6 px-3 py-2 rounded-pill" style="min-width: 70px;">{{ old('progress', 0) }}%</output>
                                </div>
                                @error('progress') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- BOUTON DE VALIDATION -->
                            <div class="col-12 mt-4 border-top pt-4 text-end">
                                <button type="reset" class="btn btn-light rounded-pill px-4 fw-bold text-muted me-2 border">Réinitialiser</button>
                                <button type="submit" class="btn shadow-lg px-5 rounded-pill border-0 text-white fw-bold" style="background: linear-gradient(45deg, #10b981, #059669);">
                                    <i class="fas fa-save me-2"></i> Enregistrer l'activité
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEndDate() {
        const isPermanent = document.getElementById('isPermanent').checked;
        const endDateInput = document.getElementById('end_date');
        const container = document.getElementById('endDateContainer');

        if (isPermanent) {
            endDateInput.value = '';
            endDateInput.disabled = true;
            container.style.opacity = '0.5';
        } else {
            endDateInput.disabled = false;
            container.style.opacity = '1';
        }
    }

    // Exécuter au chargement pour gérer le "old" value
    window.onload = toggleEndDate;
</script>

<style>
    .form-range::-webkit-slider-thumb { background: #6366f1; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15) !important;
        border: 1px solid #6366f1 !important;
    }
    .form-switch .form-check-input { width: 3em; height: 1.5em; cursor: pointer; }
</style>
@endsection
