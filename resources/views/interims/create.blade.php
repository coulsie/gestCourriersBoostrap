@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-clock me-2"></i> Programmer un nouvel intérim</h5>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('interims.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <!-- Titulaire -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger">Agent Absent (Titulaire)</label>
                                <select name="agent_id" class="form-control form-select border-left-danger shadow-sm @error('agent_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner le titulaire --</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->last_name }} {{ $agent->first_name }} ({{ $agent->status }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Remplaçant -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success">Agent Remplaçant (Intérimaire)</label>
                                <select name="interimaire_id" class="form-control form-select border-left-success shadow-sm @error('interimaire_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner le remplaçant --</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ old('interimaire_id') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->last_name }} {{ $agent->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('interimaire_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Dates -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date de début</label>
                                <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}"
                                    class="form-control shadow-sm @error('date_debut') is-invalid @enderror" required min="{{ date('Y-m-d') }}">
                                @error('date_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date de fin</label>
                                <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}"
                                    class="form-control shadow-sm @error('date_fin') is-invalid @enderror" required>
                                @error('date_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Motif -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-primary">Motif de l'intérim</label>
                                <textarea name="motif" class="form-control shadow-sm border-left-primary @error('motif') is-invalid @enderror"
                                        rows="3" placeholder="Ex: Congés annuels, Déplacement professionnel, Maladie...">{{ old('motif') }}</textarea>
                                <small class="text-muted italic">Ce motif sera également reporté dans la table des absences.</small>
                                @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('interims.index') }}" class="btn btn-light fw-bold text-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                <i class="fas fa-check-circle me-1"></i> Enregistrer l'intérim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sécurité : Empêcher de choisir une date de fin antérieure à la date de début
    document.getElementById('date_debut').addEventListener('change', function() {
        document.getElementById('date_fin').min = this.value;
    });
</script>
@endsection
