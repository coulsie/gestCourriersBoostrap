@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe;">

    {{-- Rappel pour la sélection multiple --}}
    <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
            <i class="fas fa-edit text-warning"></i>
        </div>
        <div>
            <span class="fw-bold">Mode Édition :</span> Modifiez les détails ci-dessous. N'oubliez pas de maintenir <kbd class="bg-white text-dark shadow-sm">Ctrl</kbd> pour modifier la liste des participants.
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #1e293b;">
            <h6 class="m-0 font-weight-bold text-white fs-5">
                <i class="fas fa-pen-fancy me-2 text-warning"></i> Modifier la réunion : {{ $reunion->objet }}
            </h6>
            <a href="{{ route('reunions.hebdo') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Retour</a>
        </div>

        <div class="card-body p-4 bg-white">
            <form action="{{ route('reunions.update', $reunion->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Indispensable pour la mise à jour --}}

                <div class="row g-4">
                    <!-- Objet -->
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark text-uppercase small">Objet de la réunion</label>
                        <input type="text" name="objet" class="form-control border-0 bg-light fw-bold" value="{{ $reunion->objet }}" required>
                    </div>

                    <!-- Date et Heure -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-danger text-uppercase small">Date et Heure</label>
                        <input type="datetime-local" name="date_heure" class="form-control border-0 shadow-sm text-danger fw-bold"
                               value="{{ \Carbon\Carbon::parse($reunion->date_heure)->format('Y-m-d\TH:i') }}" required style="background-color: #fff1f2;">
                    </div>

                    <!-- Animateur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #eef2ff; border-left: 5px solid #6366f1;">
                            <label class="form-label fw-bold text-indigo"><i class="fas fa-microphone me-2"></i> Animateur</label>
                            <select name="animateur_id" class="form-select select2 border-0" required>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $reunion->animateur_id == $agent->id ? 'selected' : '' }}>
                                        {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Rédacteur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #ecfdf5; border-left: 5px solid #10b981;">
                            <label class="form-label fw-bold text-success"><i class="fas fa-pen-nib me-2"></i> Rédacteur</label>
                            <select name="redacteur_id" class="form-select select2 border-0" required>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $reunion->redacteur_id == $agent->id ? 'selected' : '' }}>
                                        {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Participants Internes -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary"><i class="fas fa-users me-2"></i> Participants Internes</label>
                        <select name="participants[]" class="form-control select2 shadow-sm border-light" multiple="multiple">
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}"
                                    {{ in_array($agent->id, $reunion->participants->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Participants Externes -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-warning"><i class="fas fa-user-plus me-2"></i> Personnes Extérieures</label>
                        @php
                            $externesArray = is_string($reunion->externes) ? json_decode($reunion->externes, true) : $reunion->externes;
                            $externesString = is_array($externesArray) ? implode(', ', $externesArray) : '';
                        @endphp
                        <input type="text" name="externes_simple" class="form-control border-0 bg-light" value="{{ $externesString }}" placeholder="Nom1, Nom2...">
                    </div>

                    <!-- Ordre du jour -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark">Ordre du jour / Notes</label>
                        <textarea name="ordre_du_jour" class="form-control border-0 shadow-sm bg-light" rows="4">{{ $reunion->ordre_du_jour }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Supprimer
                    </button>
                    <button type="submit" class="btn px-5 py-3 rounded-pill shadow-lg text-white fw-bold" style="background: linear-gradient(45deg, #3b82f6, #2563eb);">
                        <i class="fas fa-sync-alt me-2"></i> METTRE À JOUR LA RÉUNION
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
