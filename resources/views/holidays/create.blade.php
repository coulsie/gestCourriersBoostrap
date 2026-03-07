@extends('layouts.app')

@section('content')
<div class="container-fluid text-sm">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Nouveau Jour Férié</h1>
        <a href="{{ route('holidays.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-7">
            <!-- Formulaire Card -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-plus mr-2"></i> Ajouter une date exceptionnelle
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('holidays.store') }}" method="POST">
                        @csrf

                        <!-- Nom du Jour Férié -->
                        <div class="form-group mb-4">
                            <label class="text-dark font-weight-bold small uppercase">Désignation de l'événement</label>
                            <input type="text" name="name" 
                                   class="form-control form-control-user @error('name') is-invalid @enderror" 
                                   placeholder="ex: Tabaski, Noël, Fête de l'Indépendance" 
                                   value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sélection de la Date -->
                        <div class="form-group mb-4">
                            <label class="text-dark font-weight-bold small uppercase">Date précise</label>
                            <input type="date" name="holiday_date" 
                                   class="form-control form-control-user @error('holiday_date') is-invalid @enderror" 
                                   value="{{ old('holiday_date') }}" required>
                            @error('holiday_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Notes Optionnelles -->
                        <div class="form-group mb-4">
                            <label class="text-dark font-weight-bold small uppercase">Description / Motif (Optionnel)</label>
                            <textarea name="description" rows="3" 
                                      class="form-control" 
                                      placeholder="Ajoutez un commentaire si nécessaire...">{{ old('description') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <!-- Boutons d'action -->
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-2">
                                <i class="fas fa-check-circle mr-2"></i> Enregistrer le jour férié
                            </button>
                            <a href="{{ route('holidays.index') }}" class="btn btn-link btn-block text-gray-600 small">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Note informative -->
            <div class="alert alert-info border-0 shadow-sm small">
                <i class="fas fa-info-circle mr-2"></i> 
                Une fois enregistré, ce jour sera pris en compte lors du calcul automatique des retards et absences des agents.
            </div>
        </div>
    </div>
</div>
@endsection
