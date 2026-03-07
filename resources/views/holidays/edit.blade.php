@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Modifier le jour férié</h1>
        <a href="{{ route('holidays.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <!-- Formulaire Card -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Édition : {{ $holiday->name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('holidays.update', $holiday) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Désignation -->
                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Désignation de l'événement</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $holiday->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Date chômée</label>
                            <input type="date" name="holiday_date" 
                                   class="form-control @error('holiday_date') is-invalid @enderror" 
                                   value="{{ old('holiday_date', $holiday->holiday_date->format('Y-m-d')) }}" required>
                            @error('holiday_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description (Optionnelle) -->
                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Description / Notes</label>
                            <textarea name="description" rows="3" 
                                      class="form-control">{{ old('description', $holiday->description) }}</textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success px-4 font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                            </button>
                            <a href="{{ route('holidays.index') }}" class="btn btn-light border px-4 text-gray-800">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
