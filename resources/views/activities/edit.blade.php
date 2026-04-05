@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5; min-height: 100vh;">

    <!-- Retour rapide -->
    <div class="mb-4 no-print">
        <a href="{{ route('activities.index') }}" class="btn btn-white shadow-sm rounded-pill px-3 border fw-bold text-muted">
            <i class="fas fa-arrow-left me-2 text-warning"></i> Annuler et retourner
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé "Warning/Orange" -->
                <div class="card-header p-4 border-0" style="background: linear-gradient(45deg, #f59e0b, #d97706);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 text-white fw-bold">
                                <i class="fas fa-edit me-2"></i> Modifier l'Activité #{{ $activity->id }}
                            </h4>
                            <p class="text-white-50 small mb-0 mt-1">Dernière mise à jour le {{ $activity->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <i class="fas fa-history fa-2x text-white opacity-25"></i>
                    </div>
                </div>

                <div class="card-body p-4 bg-white">
                    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- SÉLECTION DU SERVICE -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-layer-group me-2 text-info"></i>Service Responsable</label>
                                <select name="service_id" class="form-select border-0 bg-light rounded-3 py-2 shadow-sm @error('service_id') is-invalid @enderror" required>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $activity->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- TYPE D'ACTIVITÉ (PERMANENTE) -->
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-switch bg-light p-3 rounded-3 w-100 shadow-sm border border-warning-subtle">
                                    <input class="form-check-input ms-0 me-3" type="checkbox" name="is_permanent" id="isPermanent" value="1"
                                        {{ old('is_permanent', $activity->is_permanent) ? 'checked' : '' }} onchange="toggleEndDate()">
                                    <label class="form-check-label fw-bold text-warning" for="isPermanent">
                                        <i class="fas fa-sync-alt me-1"></i> Activité Permanente
                                    </label>
                                </div>
                            </div>

                            <!-- PLANIFICATION DES DATES -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-plus me-2 text-success"></i>Date de Début</label>
                                <input type="date" name="start_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-sm @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date', $activity->start_date ? $activity->start_date->format('Y-m-d') : '') }}" required>
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4" id="endDateContainer">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-check me-2 text-danger"></i>Échéance (Fin)</label>
                                <input type="date" name="end_date" id="end_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-sm @error('end_date') is-invalid @enderror"
                                       value="{{ old('end_date', $activity->end_date ? $activity->end_date->format('Y-m-d') : '') }}">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-day me-2 text-muted"></i>Date du Rapport</label>
                                <input type="date" name="report_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-sm"
                                       value="{{ old('report_date', $activity->report_date) }}" required>
                            </div>

                            <!-- CONTENU / DESCRIPTION -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-align-left me-2 text-primary"></i>Description des travaux effectués</label>
                                <textarea name="content" rows="6" class="form-control border-0 bg-light rounded-3 shadow-sm @error('content') is-invalid @enderror"
                                          required>{{ old('content', $activity->content) }}</textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- PROGRESSION DYNAMIQUE -->
                            <div class="col-md-12">
                                <div class="p-3 rounded-4 border bg-light shadow-sm">
                                    <label class="form-label fw-bold text-dark d-flex justify-content-between">
                                        <span><i class="fas fa-tasks me-2 text-warning"></i>Mettre à jour la progression</span>
                                        <span id="rangeValue" class="badge bg-warning text-dark fs-6 px-3 shadow-sm">{{ old('progress', $activity->progress) }}%</span>
                                    </label>
                                    <input type="range" name="progress" class="form-range custom-range" id="progressRange"
                                           min="0" max="100" step="5" value="{{ old('progress', $activity->progress) }}"
                                           oninput="document.getElementById('rangeValue').innerText = this.value + '%'">
                                    <div class="d-flex justify-content-between mt-1 small text-muted">
                                        <span>0%</span>
                                        <span>50%</span>
                                        <span>100% (Terminé)</span>
                                    </div>
                                </div>
                                @error('progress') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- BOUTONS D'ACTION -->
                            <div class="col-12 mt-4 border-top pt-4 text-end">
                                <a href="{{ route('activities.index') }}" class="btn btn-light rounded-pill px-4 fw-bold me-2">Annuler</a>
                                <button type="submit" class="btn shadow-lg px-5 rounded-pill border-0 text-white fw-bold" style="background: linear-gradient(45deg, #f59e0b, #ea580c);">
                                    <i class="fas fa-save me-2"></i> Mettre à jour l'activité
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
    // Exécuter au chargement
    window.onload = toggleEndDate;
</script>

<style>
    .custom-range::-webkit-slider-thumb { background: #f59e0b; box-shadow: 0 0 10px rgba(245, 158, 11, 0.4); }
    .custom-range::-moz-range-thumb { background: #f59e0b; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.15) !important;
        border: 1px solid #f59e0b !important;
    }
    .form-switch .form-check-input:checked { background-color: #f59e0b; border-color: #f59e0b; }
</style>
@endsection
