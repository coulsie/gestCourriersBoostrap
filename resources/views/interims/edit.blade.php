@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                {{-- Header Indigo/Bleu --}}
                <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-edit me-2"></i> Modifier l'Intérim #{{ $interim->id }}
                    </h5>
                    <a href="{{ route('interims.index') }}" class="btn btn-light btn-sm fw-bold shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Retour
                    </a>
                </div>

                <div class="card-body p-5">
                    {{-- Affichage des erreurs de validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger shadow-sm mb-4">
                            <ul class="mb-0 small fw-bold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('interims.update', $interim->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Agent Titulaire (Absent) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-danger">
                                    <i class="fas fa-user-minus me-1"></i> Agent Absent (Titulaire)
                                </label>
                                <select name="agent_id" class="form-control form-select border-left-danger shadow-sm" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $interim->agent_id == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->last_name }} {{ $agent->first_name }} ({{ $agent->status }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Agent Remplaçant (Intérimaire) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-user-check me-1"></i> Agent Remplaçant (Intérimaire)
                                </label>
                                <select name="interimaire_id" class="form-control form-select border-left-success shadow-sm" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $interim->interimaire_id == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->last_name }} {{ $agent->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dates -->
                            <!-- Date de début -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date de début</label>
                                <input type="date" name="date_debut" class="form-control shadow-sm"
                                    value="{{ \Carbon\Carbon::parse($interim->date_debut)->format('Y-m-d') }}" required>
                            </div>

                            <!-- Date de fin -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date de fin</label>
                                <input type="date" name="date_fin" class="form-control shadow-sm"
                                    value="{{ \Carbon\Carbon::parse($interim->date_fin)->format('Y-m-d') }}" required>
                            </div>


                            <!-- Motif (Optionnel selon votre table) -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Motif de l'intérim</label>
                                <textarea name="motif" class="form-control shadow-sm" rows="2"
                                          placeholder="Ex: Congés annuels, Mission à l'étranger...">{{ $interim->motif }}</textarea>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4 border-0 shadow-sm small">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note :</strong> La modification de ces dates mettra automatiquement à jour l'absence approuvée correspondante pour le titulaire.
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ $interim->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label fw-bold" for="is_active">Intérim Actif</label>
                            </div>

                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
