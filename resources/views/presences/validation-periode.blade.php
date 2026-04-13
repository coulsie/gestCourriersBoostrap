@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-dark fw-bolder">📂 Validation de Période Oubliée</h1>

    <!-- Formulaire de sélection de période -->
    <div class="card shadow-sm border-0 rounded-4 mb-4 no-print">
        <div class="card-body p-4">
            <form action="{{ route('presences.validation-periode') }}" method="GET" class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Date de début</label>
                    <input type="date" name="date_debut" class="form-control rounded-pill" value="{{ $dateDebut }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Date de fin</label>
                    <input type="date" name="date_fin" class="form-control rounded-pill" value="{{ $dateFin }}" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                        <i class="fas fa-search me-2"></i> Afficher les oublis
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(!empty($agentsAbsents))
    <form action="{{ route('presences.storeValidationPeriode') }}" method="POST">
        @csrf
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-primary">Liste des absences détectées sur la période</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Agent</th>
                            <th class="text-center">Valider l'absence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agentsAbsents as $index => $data)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border">{{ $data['jour'] }}</span>
                                <input type="hidden" name="absences[{{$index}}][date]" value="{{ $data['date'] }}">
                                <input type="hidden" name="absences[{{$index}}][agent_id]" value="{{ $data['agent_id'] }}">
                            </td>
                            <td class="fw-bold">{{ $data['nom'] }}</td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" name="absences[{{$index}}][selected]" value="1" checked>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-4 text-end">
                <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill fw-bold shadow">
                    <i class="fas fa-check-double me-2"></i> Valider les éléments cochés
                </button>
            </div>
        </div>
    </form>
    @elseif($dateDebut)
        <div class="alert alert-success rounded-4 border-0 shadow-sm text-center">
            <i class="fas fa-check-circle fa-2x mb-3 d-block"></i>
            <strong>Félicitations !</strong> Toutes les présences ont été pointées sur cette période.
        </div>
    @endif
</div>
@endsection
