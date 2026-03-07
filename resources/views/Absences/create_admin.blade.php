@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 text-sm">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">
            <i class="fas fa-users-cog text-primary me-2"></i>Autorisation d'Absence Groupée
        </h1>
        <a href="{{ route('absences.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm fw-bold">
            <i class="fas fa-arrow-left fa-sm me-1"></i> Retour
        </a>
    </div>

    <form action="{{ route('absences.storeGrouped') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- COLONNE GAUCHE : LISTE DES AGENTS -->
            <div class="col-lg-5">
                <div class="card shadow mb-4 border-left-primary">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                        <h6 class="m-0 font-weight-bold text-primary">Sélectionner les Agents</h6>
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="checkAll">
                            <label class="custom-control-label font-weight-bold" for="checkAll">Tout cocher</label>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Barre de recherche rapide -->
                        <div class="p-3 bg-light border-bottom">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="searchAgent" class="form-control" placeholder="Rechercher un nom ou matricule...">
                            </div>
                        </div>
                        
                        <!-- Liste scrollable -->
                        <div class="list-group list-group-flush" style="max-height: 450px; overflow-y: auto;" id="agentList">
                            @foreach($agents as $agent)
                            <label class="list-group-item list-group-item-action d-flex align-items-center py-2 m-0 cursor-pointer agent-item">
                                <div class="custom-control custom-checkbox mr-3">
                                    <input type="checkbox" name="agent_ids[]" value="{{ $agent->id }}" 
                                           class="custom-control-input agent-checkbox" id="agent_{{ $agent->id }}">
                                    <span class="custom-control-label" for="agent_{{ $agent->id }}"></span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold text-dark mb-0">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</div>
                                    <small class="text-muted text-uppercase">Matricule: {{ $agent->matricule }}</small>
                                </div>
                                @if($agent->service)
                                    <span class="badge badge-light border text-muted small">{{ $agent->service->libelle }}</span>
                                @endif
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-primary text-white text-center py-2">
                        <span id="count-selected">0</span> agent(s) sélectionné(s)
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : DÉTAILS DE L'ABSENCE -->
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-white text-uppercase">
                        <h6 class="m-0 font-weight-bold text-dark italic">Paramètres de l'absence</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 mb-3">
                                <label class="fw-bold text-indigo"><i class="fas fa-tag mr-1"></i> Motif de l'absence <span class="text-danger">*</span></label>
                                <select name="type_absence_id" class="form-control border-left-indigo font-weight-bold shadow-sm" required>
                                    <option value="" disabled selected>Choisir un motif...</option>
                                    @foreach($typeAbsences as $type)
                                        <option value="{{ $type->id }}">{{ strtoupper($type->nom_type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-warning"><i class="fas fa-calendar mr-1"></i> Du <span class="text-danger">*</span></label>
                                <input type="date" name="date_debut" class="form-control shadow-sm border-left-warning" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-warning"><i class="fas fa-calendar-check mr-1"></i> Au <span class="text-danger">*</span></label>
                                <input type="date" name="date_fin" class="form-control shadow-sm border-left-warning" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="fw-bold text-muted">Observations communes</label>
                                <textarea name="motif" class="form-control shadow-sm" rows="3" placeholder="Saisir un commentaire..."></textarea>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold text-success"><i class="fas fa-paperclip mr-1"></i> Pièce justificative</label>
                                <div class="custom-file">
                                    <input type="file" name="document_justificatif" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choisir le fichier...</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow font-weight-bold">
                            <i class="fas fa-save mr-2"></i> VALIDER POUR LE GROUPE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .agent-item:hover { background-color: #f8f9fc !important; }
    .border-left-indigo { border-left: .25rem solid #6610f2!important; }
    .text-indigo { color: #6610f2; }
</style>

<script>
$(document).ready(function() {
    // 1. Tout cocher / Décocher
    $('#checkAll').change(function() {
        $('.agent-checkbox').prop('checked', $(this).prop('checked'));
        updateCounter();
    });

    // 2. Mise à jour du compteur
    $('.agent-checkbox').change(function() {
        updateCounter();
    });

    function updateCounter() {
        let count = $('.agent-checkbox:checked').length;
        $('#count-selected').text(count);
    }

    // 3. Recherche dynamique
    $("#searchAgent").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#agentList label").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // 4. Affichage du nom de fichier
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
});
</script>
@endsection
