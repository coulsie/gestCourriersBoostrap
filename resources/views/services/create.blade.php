@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-7">
            {{-- Card avec bordure néon et ombre profonde --}}
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;">

                {{-- Header avec dégradé Éclatant --}}
                <div class="card-header p-4 text-center" style="background: linear-gradient(90deg, #ff0080 0%, #7928ca 100%);">
                    <h3 class="m-0 text-white fw-900 text-uppercase" style="letter-spacing: 2px;">
                        <i class="fas fa-plus-circle me-2"></i> Créer un Nouveau Service
                    </h3>
                </div>

                <div class="card-body p-5 bg-white">
                    <form method="POST" action="{{ route('services.store') }}">
                        @csrf

                        <div class="row">
                            {{-- Champ Nom du Service --}}
                            <div class="col-md-8 mb-4">
                                <label for="name" class="form-label fw-bold text-dark fs-6">
                                    <i class="fas fa-tag me-1 text-primary"></i> Nom du service
                                </label>
                                <input type="text" class="form-control form-control-lg border-2 shadow-sm @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" placeholder="ex: Service Informatique" required autofocus
                                       style="border-color: #e2e8f0; border-radius: 12px;">
                                @error('name')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Code --}}
                            <div class="col-md-4 mb-4">
                                <label for="code" class="form-label fw-bold text-dark fs-6">
                                    <i class="fas fa-barcode me-1 text-primary"></i> Code
                                </label>
                                <input type="text" class="form-control form-control-lg border-2 shadow-sm @error('code') is-invalid @enderror"
                                       id="code" name="code" value="{{ old('code') }}" placeholder="SRV-01"
                                       style="border-color: #e2e8f0; border-radius: 12px;">
                                @error('code')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Direction --}}
                            <div class="col-md-12 mb-4">
                                <label for="direction_id" class="form-label fw-bold text-dark fs-6">
                                    <i class="fas fa-sitemap me-1 text-success"></i> Direction parente
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-0"><i class="fas fa-building"></i></span>
                                    <select class="form-select form-control-lg border-2 shadow-sm @error('direction_id') is-invalid @enderror"
                                            id="direction_id" name="direction_id" required style="border-radius: 0 12px 12px 0;">
                                        <option value="">Choisir une direction...</option>
                                        @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}" {{ old('direction_id') == $direction->id ? 'selected' : '' }}>
                                                {{ $direction->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('direction_id')
                                    <div class="invalid-feedback fw-bold d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Champ Responsable --}}
                            <div class="col-md-12 mb-4">
                                <label for="head_id" class="form-label fw-bold text-dark fs-6">
                                    <i class="fas fa-user-tie me-1 text-info"></i> Responsable du service (Optionnel)
                                </label>
                                <select class="form-select form-control-lg border-2 shadow-sm select2 @error('head_id') is-invalid @enderror"
                                        id="head_id" name="head_id" style="border-radius: 12px;">
                                    <option value="">Choisir un agent...</option>

                                    {{-- On trie la liste par last_name avant de générer les options --}}
                                    @foreach ($agents->sortBy('last_name') as $agent)
                                        <option value="{{ $agent->id }}" {{ old('head_id') == $agent->id ? 'selected' : '' }}>
                                            {{ strtoupper($agent->last_name) }} {{ $agent->first_name }} (Mat: {{ $agent->matricule }})
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            {{-- Champ Description --}}
                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label fw-bold text-dark fs-6">
                                    <i class="fas fa-edit me-1 text-warning"></i> Description détaillée
                                </label>
                                <textarea class="form-control border-2 shadow-sm @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3" placeholder="Description des missions du service..."
                                          style="border-radius: 12px; border-color: #e2e8f0;"></textarea>
                            </div>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary rounded-pill px-5 fw-bold order-2 order-md-1">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow-lg order-1 order-md-2"
                                    style="background: linear-gradient(90deg, #00f2fe 0%, #4facfe 100%); border: none;">
                                <i class="fas fa-save me-1"></i> ENREGISTRER LE SERVICE
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Petit badge de bas de page --}}
            <div class="text-center mt-4">
                <span class="badge bg-white text-muted shadow-sm p-2 rounded-pill">
                    <i class="fas fa-shield-alt text-primary me-1"></i> Système de Gestion RH - DSESF
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .form-control:focus, .form-select:focus {
        border-color: #7928ca !important;
        box-shadow: 0 0 0 0.25 row rgba(121, 40, 202, 0.25) !important;
    }
    .card-header h3 {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    /* Animation au survol du bouton */
    .btn-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(79, 172, 254, 0.4) !important;
        transition: all 0.3s ease;
    }
</style>
@endsection
