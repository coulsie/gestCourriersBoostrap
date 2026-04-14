@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc;">

    <!-- En-tête -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white p-3 rounded-4 shadow-sm me-3">
            <i class="fas fa-history fa-2x"></i>
        </div>
        <div>
            <h1 class="h3 mb-0 text-dark fw-bolder">Validation de Période Oubliée</h1>
            <p class="text-muted mb-0">Rattrapage des pointages non effectués avec suivi des justificatifs</p>
        </div>
    </div>

    <!-- Formulaire de sélection de période -->
    <div class="card shadow-sm border-0 rounded-4 mb-4 no-print border-start border-primary border-4">
        <div class="card-body p-4">
            <form action="{{ route('presences.validation-periode') }}" method="GET" class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary small text-uppercase">Date de début</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="fas fa-calendar-day text-primary"></i></span>
                        <input type="date" name="date_debut" class="form-control border-start-0 rounded-end-pill" value="{{ $dateDebut }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary small text-uppercase">Date de fin</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="fas fa-calendar-check text-primary"></i></span>
                        <input type="date" name="date_fin" class="form-control border-start-0 rounded-end-pill" value="{{ $dateFin }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">
                        <i class="fas fa-search me-2"></i> Analyser les oublis
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(!empty($agentsAbsents))
        <!-- Cartes de Résumé Statistique -->
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card bg-dark text-white border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75 fw-bold">Total Anomalies</small>
                            <h2 class="fw-bold mb-0 mt-1">{{ count($agentsAbsents) }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75 fw-bold">Déjà Justifiées</small>
                            <h2 class="fw-bold mb-0 mt-1">{{ collect($agentsAbsents)->where('justifiée', true)->count() }}</h2>
                        </div>
                        <i class="fas fa-file-signature fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75 fw-bold">Injustifiées</small>
                            <h2 class="fw-bold mb-0 mt-1">{{ collect($agentsAbsents)->where('justifiée', false)->count() }}</h2>
                        </div>
                        <i class="fas fa-exclamation-circle fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('presences.storeValidationPeriode') }}" method="POST">
            @csrf
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 border-bottom">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="fas fa-clipboard-list me-2 text-primary"></i>Détails des absences à valider
                    </h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-secondary small fw-bolder text-uppercase">
                                <th class="ps-4 py-3">Date</th>
                                <th>Agent</th>
                                <th>Statut / Motif</th>
                                <th class="text-center py-3">
                                    <label class="small fw-bold text-secondary d-block mb-1">TOUT</label>
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="checkAll" checked style="cursor: pointer; width: 2.5em; height: 1.2em;">
                                    </div>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agentsAbsents as $index => $data)
                            <tr class="{{ $data['justifiée'] ? 'bg-light-subtle' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white border rounded-3 p-2 me-3 text-center shadow-sm" style="min-width: 60px;">
                                            <div class="small fw-bold text-primary">{{ strtoupper(\Carbon\Carbon::parse($data['date'])->translatedFormat('M')) }}</div>
                                            <div class="h5 mb-0 fw-black">{{ \Carbon\Carbon::parse($data['date'])->format('d') }}</div>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $data['jour'] }}</span>
                                        <input type="hidden" name="absences[{{$index}}][date]" value="{{ $data['date'] }}">
                                        <input type="hidden" name="absences[{{$index}}][agent_id]" value="{{ $data['agent_id'] }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle border p-2 me-2">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $data['nom'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($data['justifiée'])
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm border-0"
                                            style="background-color: #10b981; color: white; font-weight: 800; letter-spacing: 0.5px; font-size: 0.75rem;">
                                            <i class="fas fa-check-circle me-1 text-white"></i>
                                            {{ strtoupper($data['motif']) }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm border-0 animate__animated animate__pulse animate__infinite"
                                            style="background-color: #ef4444; color: white; font-weight: 800; letter-spacing: 0.5px; font-size: 0.75rem;">
                                            <i class="fas fa-exclamation-triangle me-1 text-white"></i>
                                            ABSENCE INJUSTIFIÉE
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <!-- On utilise d-flex + justify-content-center pour un centrage parfait -->
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input h4 mb-0" type="checkbox"
                                            name="absences[{{$index}}][selected]" value="1"
                                            {{ $data['justifiée'] ? '' : 'checked' }}
                                            style="cursor: pointer;">
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white p-4 border-0 text-center text-md-end">
                     <button type="submit" class="btn btn-warning w-100 py-2 fw-bold shadow border-dark border-opacity-10">

                                <i class="fas fa-save me-2"></i>Enregistrer les {{ count($agentsAbsents) }} absences
                    </button>
                </div>
            </div>
        </form>
    @elseif($dateDebut)
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center">
            <div class="mb-3 text-success">
                <i class="fas fa-check-circle fa-5x"></i>
            </div>
            <h4 class="fw-bold text-dark">Rien à signaler !</h4>
            <p class="text-muted">La période sélectionnée ne présente aucune anomalie de pointage.</p>
            <a href="{{ route('presences.index') }}" class="btn btn-outline-primary rounded-pill px-4 mt-2">Retour</a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkAll = document.getElementById('checkAll');
    // On cible tous les switchs qui ont la classe form-check-input à l'intérieur du corps du tableau
    const checkboxes = document.querySelectorAll('tbody .form-check-input');

    checkAll.addEventListener('change', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkAll.checked;
        });
    });

    // Optionnel : Si on décoche manuellement un agent, on décoche le "Tout cocher"
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (!this.checked) {
                checkAll.checked = false;
            } else {
                // Si tous les autres sont cochés, on recoche le "Tout cocher"
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                if (allChecked) checkAll.checked = true;
            }
        });
    });
});
</script>

<style>
    .fw-black { font-weight: 900; }
    .hover-grow { transition: transform 0.2s; }
    .hover-grow:hover { transform: scale(1.03); }
    .form-check-input:checked { background-color: #10b981; border-color: #10b981; }
    .bg-light-subtle { background-color: #fcfcfc !important; }
    .input-group-text { border-radius: 50px 0 0 50px; }
</style>
@endsection
