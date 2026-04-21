@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            {{-- Card avec lueur externe (Glow effect) --}}
            <div class="card border-0 rounded-5 shadow-2xl overflow-hidden animate__animated animate__zoomIn"
                 style="box-shadow: 0 0 50px rgba(121, 40, 202, 0.3);">

                {{-- Header avec dégradé "Cosmic" --}}
                <div class="card-header p-5 text-center border-0"
                     style="background: linear-gradient(45deg, #7928ca 0%, #ff0080 100%);">
                    <div class="bg-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-sync-alt fa-2x animate__animated animate__rotateIn animate__infinite animate__slow" style="color: #7928ca;"></i>
                    </div>
                    <h2 class="m-0 text-white fw-900 text-uppercase" style="letter-spacing: 3px; text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">
                        Mise à jour
                    </h2>
                    <p class="text-white opacity-75 fw-bold mt-2 mb-0">{{ strtoupper($direction->name) }}</p>
                </div>

                <div class="card-body p-5 bg-white">
                    <form method="POST" action="{{ route('directions.update', $direction) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Nom de la Direction --}}
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-black text-dark small text-uppercase" style="letter-spacing: 1px;">
                                    <i class="fas fa-signature me-1 text-primary"></i> Nom Officiel
                                </label>
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-lg border-2 fw-bold @error('name') is-invalid @enderror"
                                       value="{{ old('name', $direction->name) }}"
                                       style="border-radius: 15px; border-color: #f0f9ff; background-color: #f0f9ff; color: #0369a1;" required>
                                @error('name') <div class="text-danger fw-bold small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                            </div>

                            {{-- Code Unique --}}
                            <div class="col-md-4">
                                <label for="code" class="form-label fw-black text-dark small text-uppercase" style="letter-spacing: 1px;">
                                    <i class="fas fa-hashtag me-1 text-danger"></i> Code
                                </label>
                                <input type="text" name="code" id="code"
                                       class="form-control form-control-lg border-2 fw-black text-center @error('code') is-invalid @enderror"
                                       value="{{ old('code', $direction->code) }}"
                                       style="border-radius: 15px; border-color: #fff1f2; background-color: #fff1f2; color: #be123c;" required>
                                @error('code') <div class="text-danger fw-bold small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Responsable --}}
                            <div class="col-12">
                                <label for="head_id" class="form-label fw-black text-dark small text-uppercase" style="letter-spacing: 1px;">
                                    <i class="fas fa-user-shield me-1 text-success"></i> Leadership
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-success text-white" style="border-radius: 15px 0 0 15px;">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                    <select name="head_id" id="head_id" class="form-select form-control-lg border-2 @error('head_id') is-invalid @enderror"
                                            style="border-radius: 0 15px 15px 0; border-color: #f0fdf4; background-color: #f0fdf4; font-weight: 700;">
                                        <option value="">-- Assigner un responsable --</option>

                                        {{-- On trie par last_name avant de boucler --}}
                                        @foreach($agents->sortBy('last_name') as $agent)
                                            <option value="{{ $agent->id }}" {{ old('head_id', $direction->head_id ?? '') == $agent->id ? 'selected' : '' }}>
                                                {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-black text-dark small text-uppercase" style="letter-spacing: 1px;">
                                    <i class="fas fa-align-left me-1 text-warning"></i> Missions Stratégiques
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="form-control border-2 @error('description') is-invalid @enderror"
                                          style="border-radius: 20px; border-color: #fffbeb; background-color: #fffbeb;"
                                          placeholder="Quels sont les objectifs majeurs ?">{{ old('description', $direction->description) }}</textarea>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('directions.index') }}" class="text-decoration-none text-muted fw-bold">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow-xl border-0"
                                    style="background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); transition: all 0.4s ease;">
                                <i class="fas fa-check-circle me-2"></i> APPLIQUER LES MODIFICATIONS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .fw-black { font-weight: 800; }
    .rounded-5 { border-radius: 2.5rem !important; }

    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border-color: #7928ca !important;
        box-shadow: 0 10px 20px rgba(121, 40, 202, 0.1) !important;
    }

    .btn-lg:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 20px 40px rgba(79, 172, 254, 0.4) !important;
    }

    .card-header h2 { text-shadow: 0 4px 10px rgba(0,0,0,0.3); }
</style>
@endsection
