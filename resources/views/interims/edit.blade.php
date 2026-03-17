@extends('layouts.app')

@section('content')
<style>
    .border-left-danger { border-left: 5px solid #dc3545 !important; }
    .border-left-success { border-left: 5px solid #198754 !important; }
    .border-left-primary { border-left: 5px solid #0d6efd !important; }
    .border-left-warning { border-left: 5px solid #ffc107 !important; }
    .bg-gradient-primary { background: linear-gradient(45deg, #1e3a8a, #3b82f6); }
    .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25); }
</style>

<div class="container-fluid py-5" style="background-color: #f8fafc;">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé -->
                <div class="card-header bg-gradient-primary text-white py-4 px-5 d-flex justify-content-between align-items-center border-0">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-edit me-2"></i> Modification de l'Intérim <span class="badge bg-white text-primary ms-2">#{{ $interim->id }}</span>
                    </h4>
                    <a href="{{ route('interims.index') }}" class="btn btn-light btn-sm fw-bold px-3 rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body p-5">
                    <!-- Alertes d'erreurs -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger shadow-sm mb-4 rounded-3">
                            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Erreurs détectées :</div>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('interims.update', $interim->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Section Agents -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger"><i class="fas fa-user-minus me-1"></i> Agent Absent (Titulaire)</label>
                                <select name="agent_id" class="form-control form-select border-left-danger shadow-sm bg-light" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $interim->agent_id == $agent->id ? 'selected' : '' }}>
                                            {{ strtoupper($agent->last_name) }} {{ $agent->first_name }} ({{ $agent->status }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success"><i class="fas fa-user-plus me-1"></i> Agent Remplaçant (Intérimaire)</label>
                                <select name="interimaire_id" class="form-control form-select border-left-success shadow-sm bg-light" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $interim->interimaire_id == $agent->id ? 'selected' : '' }}>
                                            {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Section Dates -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-alt me-1 text-primary"></i> Date de début</label>
                                <input type="date" name="date_debut" class="form-control shadow-sm border-left-primary"
                                    value="{{ \Carbon\Carbon::parse($interim->date_debut)->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-check me-1 text-primary"></i> Date de fin</label>
                                <input type="date" name="date_fin" class="form-control shadow-sm border-left-primary"
                                    value="{{ \Carbon\Carbon::parse($interim->date_fin)->format('Y-m-d') }}" required>
                            </div>

                            <!-- Motif -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-pen-fancy me-1 text-primary"></i> Motif de l'intérim</label>
                                <textarea name="motif" class="form-control shadow-sm border-left-warning" rows="3"
                                          placeholder="Ex: Congés annuels, Mission...">{{ $interim->motif }}</textarea>
                            </div>
                        </div>

                        <!-- Badge Info -->
                        <div class="alert bg-light border mt-4 shadow-sm rounded-3">
                            <div class="d-flex align-items-center text-primary">
                                <i class="fas fa-sync-alt fa-spin me-3"></i>
                                <span class="small fw-bold">Synchronisation automatique : Les dates de l'absence liée seront mises à jour lors de la validation.</span>
                            </div>
                        </div>

                        <hr class="my-5 opacity-50">

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Switch Statut -->
                            <div class="form-check form-switch bg-white p-3 rounded-pill border shadow-sm px-5">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $interim->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-primary ms-2" for="is_active">
                                    {{ $interim->is_active ? 'INTÉRIM ACTIF' : 'INTÉRIM SUSPENDU' }}
                                </label>
                            </div>

                            <!-- Bouton Validation -->
                            <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow-lg border-0">
                                <i class="fas fa-check-double me-2"></i> METTRE À JOUR L'INTÉRIM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
