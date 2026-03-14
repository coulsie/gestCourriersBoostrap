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
                                <select name="agent_id" class="form-control form-select border-left-danger shadow-sm" required>
                                    <option value="">-- Sélectionner le titulaire --</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->last_name }} {{ $agent->first_name }} ({{ $agent->status }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Remplaçant -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success">Agent Remplaçant (Intérimaire)</label>
                                <select name="interimaire_id" class="form-control form-select border-left-success shadow-sm" required>
                                    <option value="">-- Sélectionner le remplaçant --</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->last_name }} {{ $agent->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dates -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date de début</label>
                                <input type="date" name="date_debut" class="form-control shadow-sm" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date de fin</label>
                                <input type="date" name="date_fin" class="form-control shadow-sm" required>
                            </div>

                            <!-- Motif (Nouveau champ ajouté) -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-primary">Motif de l'intérim</label>
                                <textarea name="motif" class="form-control shadow-sm border-left-primary" rows="3" placeholder="Ex: Congés annuels, Déplacement professionnel, Maladie..."></textarea>
                                <small class="text-muted italic">Ce motif sera également reporté dans la table des absences.</small>
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
@endsection
