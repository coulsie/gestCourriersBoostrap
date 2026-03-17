@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
{{-- Affichage de l'erreur de doublon de date --}}
    @if ($errors->has('holiday_date'))
        <div class="alert alert-danger shadow-sm border-start border-4 border-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                <div>
                    <h6 class="fw-bold mb-1 text-uppercase">Erreur d'enregistrement</h6>
                    {{ $errors->first('holiday_date') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">
            <i class="fas fa-calendar-alt text-primary me-2"></i>Gestion des Jours Fériés
        </h1>
        <a href="{{ route('holidays.create') }}" class="btn btn-sm btn-primary shadow-sm px-3">
            <i class="fas fa-plus-circle fa-sm text-white-50 me-1"></i> Ajouter un jour
        </a>
    </div>

    <div class="row">
        <!-- Formulaire d'ajout rapide -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary italic">
                        <i class="fas fa-plus me-1"></i> Nouveau Jour Férié
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('holidays.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark small text-uppercase">Désignation</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-tag text-muted"></i>
                                    </span>
                                </div>
                                <!-- style : affichage majuscule | oninput : transformation réelle de la valeur -->
                                <input type="text"
                                    name="name"
                                    class="form-control border-left-0"
                                    placeholder="ex: NOËL"
                                    required
                                    style="text-transform: uppercase;"
                                    oninput="this.value = this.value.toUpperCase()">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark small text-uppercase">Date du jour chômé</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-calendar-day text-muted"></i></span>
                                </div>
                                <input type="date" name="holiday_date" class="form-control border-left-0" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow font-weight-bold py-2">
                            <i class="fas fa-save me-1"></i> ENREGISTRER
                        </button>
                    </form>
                </div>
                <!-- Ajoutez ce bloc juste après la fermeture de la div class="card-body p-0" -->
                <div class="card-footer bg-light py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        @php
                            $currentYear = date('Y');
                            $totalThisYear = $holidays->filter(function($h) use ($currentYear) {
                                return \Carbon\Carbon::parse($h->holiday_date)->year == $currentYear;
                            })->count();
                        @endphp

                        <span class="text-muted small fw-bold">
                            <i class="fas fa-info-circle me-1"></i>
                            Récapitulatif annuel
                        </span>

                        <div class="text-info font-weight-bold">
                            Total pour l'année {{ $currentYear }} :
                            <span class="badge badge-info ml-2 px-3 py-2 shadow-sm" style="font-size: 0.9rem;">
                                {{ $totalThisYear }} JOUR{{ $totalThisYear > 1 ? 'S' : '' }} FÉRIÉ{{ $totalThisYear > 1 ? 'S' : '' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Liste des jours -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 border-top-info">
                <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info text-uppercase small">
                        <i class="fas fa-list me-1"></i> Dates chômées enregistrées
                    </h6>
                    <span class="badge badge-info shadow-sm px-3">{{ $holidays->count() }} Jours</span>
                </div>
                <div class="card-body p-0"> <!-- P-0 pour que la table touche les bords -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th class="border-0 px-4">Désignation</th>
                                    <th class="border-0 text-center">Date</th>
                                    <th class="border-0 text-right px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $holiday)
                                <tr>
                                    <td class="align-middle px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-light-primary mr-3 text-primary text-center" style="width: 35px; height: 35px; border-radius: 50%; line-height: 35px;">
                                                <i class="fas fa-umbrella-beach"></i>
                                            </div>
                                            <span class="font-weight-bold text-dark">{{ strtoupper($holiday->name) }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-soft-info p-2 px-3 border" style="font-size: 0.9rem;">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            {{ $holiday->holiday_date->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-right px-4">
                                        <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-sm btn-outline-warning border-0" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<style>
    .border-left-primary { border-left: .25rem solid #4e73df!important; }
    .border-top-info { border-top: .25rem solid #36b9cc!important; }
    .bg-light-primary { background-color: #f0f2f9; }
    .badge-soft-info { background-color: #e3f2fd; color: #0d47a1; border-color: #bbdefb !important; }
    .table-hover tbody tr:hover { background-color: #f8f9fc; }
    .italic { font-style: italic; }
    .btn-circle { border-radius: 50%; width: 35px; height: 35px; padding: 0; }
</style>
@endsection
