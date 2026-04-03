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
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé -->
                <div class="card-header p-4 border-0" style="background: linear-gradient(45deg, #6366f1, #a855f7);">
                    <h4 class="mb-0 text-white fw-bold">
                        <i class="fas fa-plus-circle me-2"></i> Enregistrer une Nouvelle Activité
                    </h4>
                    <p class="text-white-50 small mb-0 mt-1">Remplissez les informations ci-dessous pour documenter l'avancement.</p>
                </div>

                <div class="card-body p-4 bg-white">
                    <form action="{{ route('activities.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- SÉLECTION DU SERVICE -->
                            <div class="col-md-7">
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

                            <!-- DATE DU RAPPORT -->
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-day me-2 text-danger"></i>Date de l'activité</label>
                                <input type="date" name="report_date" class="form-select border-0 bg-light rounded-3 py-2 shadow-sm @error('report_date') is-invalid @enderror"
                                       value="{{ old('report_date', date('Y-m-d')) }}" required>
                                @error('report_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- CONTENU / DESCRIPTION -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-align-left me-2 text-primary"></i>Détails de l'activité</label>
                                <textarea name="content" rows="6" class="form-control border-0 bg-light rounded-3 shadow-sm @error('content') is-invalid @enderror"
                                          placeholder="Décrivez ici ce qui a été réalisé..." required>{{ old('content') }}</textarea>
                                <div class="form-text text-muted">Soyez précis et factuel dans votre description.</div>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- PROGRESSION -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-tasks me-2 text-warning"></i>Niveau de Progression (%)</label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="range" name="progress" class="form-range flex-grow-1" id="progressRange" min="0" max="100" step="5" value="{{ old('progress', 0) }}" oninput="this.nextElementSibling.value = this.value + '%'">
                                    <output class="badge bg-dark fs-6 px-3 py-2 rounded-pill" style="min-width: 60px;">{{ old('progress', 0) }}%</output>
                                </div>
                                @error('progress') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- BOUTON DE VALIDATION -->
                            <div class="col-12 mt-5 border-top pt-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-light rounded-pill px-4 fw-bold text-muted">Réinitialiser</button>
                                    <button type="submit" class="btn shadow-lg px-5 rounded-pill border-0 text-white fw-bold" style="background: linear-gradient(45deg, #10b981, #059669);">
                                        <i class="fas fa-check-circle me-2"></i> Enregistrer l'activité
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom style pour le curseur de progression */
    .form-range::-webkit-slider-thumb { background: #6366f1; }
    .form-range::-moz-range-thumb { background: #6366f1; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15) !important;
        border: 1px solid #6366f1 !important;
    }
</style>
@endsection
