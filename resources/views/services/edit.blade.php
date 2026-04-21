@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Card avec ombre portée colorée --}}
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="box-shadow: 0 15px 35px rgba(245, 158, 11, 0.2) !important;">

                {{-- Header avec dégradé Vif (Orange/Ambre) --}}
                <div class="card-header p-4 d-flex align-items-center justify-content-between"
                     style="background: linear-gradient(45deg, #f59e0b, #ef4444);">
                    <h4 class="m-0 text-white fw-900 text-uppercase" style="letter-spacing: 1px;">
                        <i class="fas fa-edit me-2"></i> Modifier : {{ $service->name }}
                    </h4>
                    <span class="badge bg-white text-danger rounded-pill px-3 py-2 fw-bold shadow-sm">MODE ÉDITION</span>
                </div>

                <div class="card-body p-5 bg-white">
                    <form method="POST" action="{{ route('services.update', $service) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Champ Nom du Service --}}
                            <div class="col-md-7 mb-4">
                                <label for="name" class="form-label fw-black text-dark small text-uppercase">Nom du Service</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-warning"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="name" id="name"
                                           class="form-control form-control-lg border-0 bg-light fw-bold @error('name') is-invalid @enderror"
                                           value="{{ old('name', $service->name) }}" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Code Unique --}}
                            <div class="col-md-5 mb-4">
                                <label for="code" class="form-label fw-black text-dark small text-uppercase">Code Unique</label>
                                <input type="text" name="code" id="code"
                                       class="form-control form-control-lg border-0 bg-light fw-bold text-center text-primary @error('code') is-invalid @enderror"
                                       value="{{ old('code', $service->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Direction --}}
                            <div class="col-md-6 mb-4">
                                <label for="direction_id" class="form-label fw-black text-dark small text-uppercase">Direction de rattachement</label>
                                <select name="direction_id" id="direction_id" class="form-select form-control-lg border-0 bg-light fw-bold @error('direction_id') is-invalid @enderror" required>
                                    <option value="">-- Choisir une direction --</option>
                                    @foreach($directions as $direction)
                                        <option value="{{ $direction->id }}" {{ old('direction_id', $service->direction_id) == $direction->id ? 'selected' : '' }}>
                                            {{ $direction->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('direction_id')
                                    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Responsable --}}
                            <div class="col-md-6 mb-4">
                                <label for="head_id" class="form-label fw-black text-dark small text-uppercase">Responsable du Service</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-info"><i class="fas fa-user-tie"></i></span>
                                    <select name="head_id" id="head_id" class="form-select form-control-lg border-0 bg-light fw-bold @error('head_id') is-invalid @enderror">
                                        <option value="">-- Non affecté --</option>

                                        {{-- Tri alphabétique par le nom de famille (last_name) --}}
                                        @foreach($agents->sortBy('last_name') as $agent)
                                            <option value="{{ $agent->id }}" {{ old('head_id', $service->head_id) == $agent->id ? 'selected' : '' }}>
                                                {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            {{-- Champ Description --}}
                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label fw-black text-dark small text-uppercase">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="form-control border-0 bg-light fw-bold @error('description') is-invalid @enderror"
                                          placeholder="Décrivez les missions du service...">{{ old('description', $service->description) }}</textarea>
                            </div>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('services.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                                <i class="fas fa-arrow-left me-1"></i> Annuler les changements
                            </a>
                            <button type="submit" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow"
                                    style="background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border: none;">
                                <i class="fas fa-sync-alt me-1"></i> METTRE À JOUR MAINTENANT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 800; }
    .fw-900 { font-weight: 900; }

    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.15) !important;
        border: 1px solid #f59e0b !important;
    }

    .input-group-text {
        border-radius: 12px 0 0 12px !important;
    }

    .form-control, .form-select {
        border-radius: 12px !important;
    }

    /* Animation du bouton */
    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(217, 119, 6, 0.4) !important;
        transition: all 0.3s ease;
    }
</style>
@endsection
