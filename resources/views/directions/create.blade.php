@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-7">
            {{-- Card avec effet de profondeur et bordures translucides --}}
            <div class="card shadow-2xl border-0 rounded-5 overflow-hidden animate__animated animate__zoomIn"
                 style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">

                {{-- Header avec dégradé Vert Éclatant --}}
                <div class="card-header p-5 text-center border-0"
                     style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);">
                    <div class="bg-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-sitemap fa-2x" style="color: #11998e;"></i>
                    </div>
                    <h2 class="m-0 text-white fw-900 text-uppercase" style="letter-spacing: 3px; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                        Nouvelle Direction
                    </h2>
                    <p class="text-white opacity-75 small fw-bold mt-2 mb-0 italic">Configuration de la structure hiérarchique</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('directions.store') }}">
                        @csrf

                        <div class="row g-4">
                            {{-- Champ Nom de la Direction --}}
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-black text-dark small text-uppercase">
                                    <i class="fas fa-signature me-1 text-success"></i> Nom de la direction
                                </label>
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-lg border-2 shadow-sm @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Ex: Direction des Affaires Juridiques"
                                       required autofocus style="border-radius: 15px; border-color: #e0f2f1;">
                                @error('name')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Code --}}
                            <div class="col-md-4">
                                <label for="code" class="form-label fw-black text-dark small text-uppercase">
                                    <i class="fas fa-hashtag me-1 text-success"></i> Code Unique
                                </label>
                                <input type="text" name="code" id="code"
                                       class="form-control form-control-lg border-2 shadow-sm text-center fw-bold text-success @error('code') is-invalid @enderror"
                                       value="{{ old('code') }}" placeholder="DIR-XXX"
                                       style="border-radius: 15px; border-color: #e0f2f1;">
                                @error('code')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Responsable --}}
                            <div class="col-12">
                                <label for="head_id" class="form-label fw-black text-dark small text-uppercase">
                                    <i class="fas fa-user-tie me-1 text-success"></i> Responsable de Direction
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0 text-success" style="border-radius: 15px 0 0 15px; border-color: #e0f2f1;">
                                        <i class="fas fa-user-shield"></i>
                                    </span>
                                    <select class="form-select form-control-lg border-2 shadow-sm @error('head_id') is-invalid @enderror"
                                            id="head_id" name="head_id" style="border-radius: 0 15px 15px 0; border-color: #e0f2f1;">
                                        <option value="">Choisir un agent responsable...</option>

                                        {{-- Tri par nom de famille, puis par prénom --}}
                                        @foreach ($agents->sortBy(['last_name', 'first_name']) as $agent)
                                            <option value="{{ $agent->id }}" {{ old('head_id', $direction->head_id ?? '') == $agent->id ? 'selected' : '' }}>
                                                {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            {{-- Champ Description --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-black text-dark small text-uppercase">
                                    <i class="fas fa-align-left me-1 text-success"></i> Missions & Attributions
                                </label>
                                <textarea name="description" id="description" rows="3"
                                          class="form-control border-2 shadow-sm @error('description') is-invalid @enderror"
                                          placeholder="Décrivez brièvement les missions de cette direction..."
                                          style="border-radius: 15px; border-color: #e0f2f1;">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('directions.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                                <i class="fas fa-times-circle me-1"></i> ANNULER
                            </a>
                            <button type="submit" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow-lg border-0"
                                    style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);">
                                <i class="fas fa-save me-2"></i> ENREGISTRER LA DIRECTION
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer badge --}}
            <div class="text-center mt-4">
                <p class="badge bg-white text-success shadow-sm rounded-pill px-3 py-2 fw-bold">
                    <i class="fas fa-shield-check me-1"></i> SÉCURISÉ | GESTCOURRIERS v2.0
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .fw-black { font-weight: 800; }
    .rounded-5 { border-radius: 2.5rem !important; }

    .form-control:focus, .form-select:focus {
        border-color: #38ef7d !important;
        box-shadow: 0 0 0 0.25rem rgba(56, 239, 125, 0.15) !important;
        background-color: #fafffd !important;
    }

    .btn-lg {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(56, 239, 125, 0.4) !important;
    }

    /* Animation d'entrée */
    .animate__animated { animation-duration: 0.6s; }
</style>
@endsection
