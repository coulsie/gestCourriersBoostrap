@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc; min-height: 100vh;">

    <!-- Bouton Retour -->
    <div class="mb-4">
        <a href="{{ route('activities.index') }}" class="btn btn-white shadow-sm rounded-pill px-4 border-0 fw-bold text-muted transition-all hover-lift">
            <i class="fas fa-arrow-left me-2 text-primary"></i> Retour au journal
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Header Artistique -->
                <div class="card-header p-4 border-0 position-relative" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                    <div class="position-relative z-index-1">
                        <h4 class="mb-0 text-white fw-bolder">
                            <i class="fas fa-feather-alt me-2"></i> Nouvelle Activité
                        </h4>
                        <p class="text-white-50 small mb-0 mt-1">Planification et suivi des performances par service.</p>
                    </div>
                    <!-- Décoration en arrière-plan -->
                    <i class="fas fa-tasks position-absolute end-0 bottom-0 me-4 mb-3 text-white opacity-10" style="font-size: 5rem;"></i>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('activities.store') }}" method="POST">
                        @csrf

                        <!-- SECTION 1 : ATTRIBUTION -->
                        <div class="row g-4 mb-5 p-3 rounded-4" style="background-color: #f1f5f9; border-left: 5px solid #4f46e5;">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold text-uppercase small mb-3"><i class="fas fa-id-card me-2"></i>Identification</h6>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Service Responsable</label>
                                <select name="service_id" class="form-select border-0 shadow-sm rounded-3 py-2 @error('service_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Sélectionner le service concerné...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-switch p-3 bg-white rounded-3 shadow-sm border w-100 d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-primary mb-0" for="isPermanent">
                                        <i class="fas fa-infinity me-1"></i> Permanent
                                    </label>
                                    <input class="form-check-input ms-0 custom-switch" type="checkbox" name="is_permanent" id="isPermanent" value="1" {{ old('is_permanent') ? 'checked' : '' }} onchange="toggleEndDate()">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2 : CALENDRIER -->
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <div class="p-3 rounded-4 border-top border-4 border-success bg-white shadow-sm h-100">
                                    <label class="form-label fw-bold text-success small text-uppercase">Date de Début</label>
                                    <input type="date" name="start_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-inner" value="{{ old('start_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4" id="endDateContainer">
                                <div class="p-3 rounded-4 border-top border-4 border-danger bg-white shadow-sm h-100 transition-all">
                                    <label class="form-label fw-bold text-danger small text-uppercase">Échéance Prévue</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-inner" value="{{ old('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-4 border-top border-4 border-secondary bg-white shadow-sm h-100">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Date du Rapport</label>
                                    <input type="date" name="report_date" class="form-control border-0 bg-light rounded-3 py-2 shadow-inner" value="{{ old('report_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3 : RÉALISATION -->
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark px-1"><i class="fas fa-edit me-2 text-primary"></i>Description détaillée de l'activité</label>
                                <textarea name="content" rows="5" class="form-control border-0 bg-light rounded-4 shadow-sm p-3 @error('content') is-invalid @enderror" placeholder="Listez les tâches accomplies, les outils utilisés..." required>{{ old('content') }}</textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-7">
                                <div class="p-4 rounded-4 border-0 bg-dark text-white shadow-lg position-relative overflow-hidden">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Taux de Progression</label>
                                    <div class="d-flex align-items-center gap-4">
                                        <input type="range" name="progress" class="form-range flex-grow-1 accent-white" id="progressRange" min="0" max="100" step="5" value="{{ old('progress', 0) }}" oninput="document.getElementById('progressOutput').value = this.value + '%'">
                                        <output id="progressOutput" class="h3 fw-black mb-0 text-warning" style="min-width: 80px;">{{ old('progress', 0) }}%</output>
                                    </div>
                                    <!-- Déco progress bar -->
                                    <div class="position-absolute start-0 bottom-0 w-100 bg-warning" id="visualProgress" style="height: 4px; transition: width 0.3s ease;"></div>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="col-md-5 d-flex align-items-center justify-content-end gap-3">
                                <button type="reset" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-muted border transition-all">
                                    Effacer
                                </button>
                                <button type="submit" class="btn btn-primary shadow-lg px-5 py-3 rounded-pill border-0 fw-bold transition-all hover-scale" style="background: linear-gradient(45deg, #10b981, #059669);">
                                    <i class="fas fa-save me-2"></i> Enregistrer
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

    document.getElementById('progressRange').addEventListener('input', function() {
        document.getElementById('visualProgress').style.width = this.value + '%';
    });

    window.onload = function() {
        toggleEndDate();
        document.getElementById('visualProgress').style.width = document.getElementById('progressRange').value + '%';
    };
</script>

<style>
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .hover-scale:hover { transform: scale(1.05); }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
    .transition-all { transition: all 0.3s ease-in-out; }

    /* Style personnalisé pour le Range */
    .accent-white { filter: brightness(10); }
    .custom-switch { width: 3.5rem !important; height: 1.7rem !important; cursor: pointer; }

    .form-control:focus, .form-select:focus {
        background-color: white !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
        border: 1px solid #4f46e5 !important;
    }
</style>
@endsection
