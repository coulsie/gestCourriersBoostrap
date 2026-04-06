@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #fdfaf6; min-height: 100vh;">

    <!-- Bouton Retour -->
    <div class="mb-4 no-print">
        <a href="{{ route('activities.index') }}" class="btn btn-white shadow-sm rounded-pill px-4 border-0 fw-bold text-muted transition-all hover-lift">
            <i class="fas fa-arrow-left me-2 text-warning"></i> Annuler les modifications
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Header Dynamique (Orange Édition) -->
                <div class="card-header p-4 border-0 position-relative" style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);">
                    <div class="d-flex justify-content-between align-items-center position-relative z-index-1">
                        <div>
                            <h4 class="mb-0 text-white fw-bolder">
                                <i class="fas fa-edit me-2"></i> Édition de l'Activité
                            </h4>
                            <p class="text-white-50 small mb-0 mt-1">ID : #{{ $activity->id }} — Mis à jour le {{ $activity->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="text-white opacity-25">
                            <i class="fas fa-history fa-3x"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- BLOC 1 : ATTRIBUTION & TYPE -->
                        <div class="row g-4 mb-5 p-3 rounded-4" style="background-color: #fffbeb; border-left: 5px solid #f59e0b;">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark small text-uppercase">Service Responsable</label>
                                <select name="service_id" class="form-select border-0 shadow-sm rounded-3 py-2 @error('service_id') is-invalid @enderror" required>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $activity->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-switch p-3 bg-white rounded-3 shadow-sm border border-warning-subtle w-100 d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-warning mb-0" for="isPermanent">
                                        <i class="fas fa-sync-alt me-1"></i> Permanent
                                    </label>
                                    <input class="form-check-input ms-0 custom-switch-warn" type="checkbox" name="is_permanent" id="isPermanent" value="1"
                                        {{ old('is_permanent', $activity->is_permanent) ? 'checked' : '' }} onchange="toggleEndDate()">
                                </div>
                            </div>
                        </div>

                        <!-- BLOC 2 : CALENDRIER -->
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <div class="p-3 rounded-4 border-top border-4 border-success bg-white shadow-sm">
                                    <label class="form-label fw-bold text-success small text-uppercase">Date de Début</label>
                                    <input type="date" name="start_date" class="form-control border-0 bg-light rounded-3 shadow-inner"
                                           value="{{ old('start_date', $activity->start_date ? $activity->start_date->format('Y-m-d') : '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4" id="endDateContainer">
                                <div class="p-3 rounded-4 border-top border-4 border-danger bg-white shadow-sm transition-all">
                                    <label class="form-label fw-bold text-danger small text-uppercase">Échéance Prévue</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control border-0 bg-light rounded-3 shadow-inner"
                                           value="{{ old('end_date', $activity->end_date ? $activity->end_date->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-4 border-top border-4 border-secondary bg-white shadow-sm opacity-75">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Date Enregistrement</label>
                                    <input type="date" name="report_date" class="form-control border-0 bg-light rounded-3 shadow-inner"
                                           value="{{ old('report_date', $activity->report_date->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- BLOC 3 : DESCRIPTION -->
                        <div class="row g-4 mb-5">
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark px-1"><i class="fas fa-align-left me-2 text-warning"></i>Description des travaux</label>
                                <textarea name="content" rows="6" class="form-control border-0 bg-light rounded-4 shadow-sm p-3 @error('content') is-invalid @enderror" required>{{ old('content', $activity->content) }}</textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- BLOC 4 : PROGRESSION -->
                        <div class="row g-4 align-items-center">
                                <div class="col-md-7">
                                    <div class="p-4 rounded-4 border-0 shadow-lg text-white" style="background: #1e293b;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="small fw-bold text-uppercase opacity-75">Niveau d'avancement</span>
                                            <span id="rangeValue" class="h4 fw-black text-warning mb-0">{{ old('progress', $activity->progress ?? 0) }}%</span>
                                        </div>

                                        <!-- Le curseur Range -->
                                        <div class="position-relative">
                                            <input type="range" name="progress" class="form-range accent-warning w-100" id="progressRange"
                                                min="0" max="100" step="5" value="{{ old('progress', $activity->progress ?? 0) }}"
                                                oninput="document.getElementById('rangeValue').innerText = this.value + '%'">

                                            <!-- Graduation alignée -->
                                            <div class="d-flex justify-content-between mt-2 px-1 small opacity-50" style="font-size: 0.75rem;">
                                                <span style="width: 20px; text-align: left;">0%</span>
                                                <span style="width: 20px; text-align: center;">50%</span>
                                                <span style="width: 20px; text-align: right;">100%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons d'action (à droite) -->
                                <div class="col-md-5 d-flex justify-content-md-end gap-3 mt-4 mt-md-0">
                                    <a href="{{ route('activities.index') }}" class="btn btn-light rounded-pill px-4 fw-bold border">Annuler</a>
                                    <button type="submit" class="btn btn-warning shadow-lg px-5 py-3 rounded-pill border-0 text-white fw-bold transition-all hover-scale" style="background: linear-gradient(45deg, #f59e0b, #ea580c);">
                                        <i class="fas fa-sync-alt me-2"></i> Mettre à jour
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

<script>
    function toggleEndDate() {
        const isPermanent = document.getElementById('isPermanent').checked;
        const endDateInput = document.getElementById('end_date');
        const container = document.getElementById('endDateContainer').firstElementChild;

        if (isPermanent) {
            endDateInput.value = '';
            endDateInput.disabled = true;
            container.classList.add('opacity-50', 'bg-light');
            container.style.borderTopColor = '#cbd5e1';
        } else {
            endDateInput.disabled = false;
            container.classList.remove('opacity-50', 'bg-light');
            container.style.borderTopColor = '#ef4444';
        }
    }
    window.onload = toggleEndDate;
</script>
<style>
    /* Assure que le curseur prend toute la largeur disponible */
    .form-range {
        display: block;
        width: 100%;
    }

    /* Style pour le curseur (Thumb) en orange */
    .accent-warning::-webkit-slider-thumb { background: #f59e0b; border: 2px solid white; }
    .accent-warning::-moz-range-thumb { background: #f59e0b; border: 2px solid white; }

    .fw-black { font-weight: 900; }
    .hover-scale:hover { transform: scale(1.03); transition: 0.3s; }
</style>


<style>
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .hover-scale:hover { transform: scale(1.03); }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
    .transition-all { transition: all 0.3s ease; }

    .accent-warning { filter: hue-rotate(10deg) saturate(1.5); }
    .custom-switch-warn { width: 3.5rem !important; height: 1.7rem !important; cursor: pointer; }
    .custom-switch-warn:checked { background-color: #f59e0b; border-color: #f59e0b; }

    .form-control:focus, .form-select:focus {
        background-color: white !important;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1) !important;
        border: 1px solid #f59e0b !important;
    }
    .fw-black { font-weight: 900; }
</style>
@endsection
