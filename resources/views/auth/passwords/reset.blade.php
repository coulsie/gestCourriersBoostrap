@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    {{ __('Changer le mot de passe') }}
                </div>

                <div class="card-body">
                    {{-- Affichage du message de succès --}}
                    @if (session('status'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.password.custom.update') }}">
                        @csrf

                        <!-- ANCIEN MOT DE PASSE -->
                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">Mot de passe actuel</label>
                            <div class="col-md-6">
                                <input id="current_password" type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password" required autofocus>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- NOUVEAU MOT DE PASSE -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Nouveau mot de passe</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- CONFIRMATION -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmer le nouveau</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="fas fa-save me-1"></i> Mettre à jour
                                </button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
