@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Jours Fériés</h1>
        <a href="{{ route('holidays.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter un jour
        </a>
    </div>

    <div class="row">
        <!-- Formulaire d'ajout rapide -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nouveau Jour Férié</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('holidays.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Désignation</label>
                            <input type="text" name="name" class="form-control" placeholder="ex: Noël" required>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="holiday_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des jours -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des dates chômées</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $holiday)
                                <tr>
                                    <td><strong>{{ $holiday->name }}</strong></td>
                                    <td>
                                        <span class="badge badge-info shadow-sm p-2">
                                            {{ $holiday->holiday_date->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-sm btn-warning btn-circle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-circle">
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
@endsection
