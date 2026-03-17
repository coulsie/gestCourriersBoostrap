@extends('layouts.app')

@section('content')
<style>
    /* Styles personnalisés pour renforcer l'aspect visuel */
    .border-left-danger { border-left: 5px solid #dc3545 !important; }
    .border-left-success { border-left: 5px solid #198754 !important; }
    .border-left-primary { border-left: 5px solid #0d6efd !important; }
    .border-left-info { border-left: 5px solid #0dcaf0 !important; }
    .card-header.bg-gradient-primary {
        background: linear-gradient(45deg, #1e3a8a, #3b82f6);
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25 margin rgba(13, 110, 253, 0.15);
    }
</style>

<div class="container-fluid py-5" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header Coloré -->
                <div class="card-header bg-gradient-primary text-white py-4 px-5 rounded-top-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-user-shield me-2"></i> PROGRAMMER UN NOUVEL INTÉRIM</h4>
                        <span class="badge bg-white text-primary px-3 py-2 fw-bold shadow-sm text-uppercase">Session 2026</span>
                    </div>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('interims.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">

                            <!-- Section Agents : Titulaire & Remplaçant -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger"><i class="fas fa-user-minus me-1"></i> Agent Absent (Titulaire)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white border-0"><i class="fas fa-id-card"></i></span>
                                    <select name="agent_id" class="form-control form-select border-left-danger shadow-sm @error('agent_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionner le titulaire --</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                                {{ strtoupper($agent->last_name) }} {{ $agent->first_name }} ({{ $agent->status }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('agent_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success"><i class="fas fa-user-plus me-1"></i> Agent Remplaçant (Intérimaire)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-0"><i class="fas fa-user-check"></i></span>
                                    <select name="interimaire_id" class="form-control form-select border-left-success shadow-sm @error('interimaire_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionner le remplaçant --</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" {{ old('interimaire_id') == $agent->id ? 'selected' : '' }}>
                                                {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('interimaire_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <!-- Section Chronologie : Dates -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-alt me-1 text-primary"></i> Date de début</label>
                                <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}"
                                    class="form-control shadow-sm border-left-info @error('date_debut') is-invalid @enderror" required min="{{ date('Y-m-d') }}">
                                @error('date_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-check me-1 text-primary"></i> Date de fin</label>
                                <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}"
                                    class="form-control shadow-sm border-left-info @error('date_fin') is-invalid @enderror" required>
                                @error('date_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Section Justification : Motif -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-primary"><i class="fas fa-pen-fancy me-1"></i> Motif de l'intérim</label>
                                <textarea name="motif" class="form-control shadow-sm border-left-primary @error('motif') is-invalid @enderror"
                                        rows="3" placeholder="Précisez la raison de l'absence (ex: Congés, Mission, Maladie...)">{{ old('motif') }}</textarea>
                                <div class="mt-2 p-2 bg-light rounded border">
                                    <small class="text-muted"><i class="fas fa-info-circle text-info me-1"></i> <strong>Note :</strong> Ce motif servira de justificatif automatique pour l'absence de l'agent titulaire.</small>
                                </div>
                                @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-5 shadow-sm">

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('interims.index') }}" class="btn btn-outline-secondary px-4 fw-bold rounded-pill shadow-sm">
                                <i class="fas fa-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">
                                <i class="fas fa-save me-2"></i> ENREGISTRER L'INTÉRIM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sécurité dynamique sur les dates
    document.getElementById('date_debut').addEventListener('change', function() {
        let dateFin = document.getElementById('date_fin');
        dateFin.min = this.value;
        if (dateFin.value && dateFin.value < this.value) {
            dateFin.value = this.value;
        }
    });
</script>
@endsection
