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
                <div class="card shadow mb-4 border-top-primary">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-ul me-1"></i> Sélectionner les Agents</h6>
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="checkAll">
                            <label class="custom-control-label font-weight-bold text-dark" for="checkAll">Tout cocher</label>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Barre de recherche -->
                        <div class="p-3 bg-white border-bottom">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white border-primary"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="searchAgent" class="form-control border-primary" placeholder="Rechercher un nom ou matricule...">
                            </div>
                        </div>

                        <!-- Liste scrollable -->
                        <div class="list-group list-group-flush" style="max-height: 450px; overflow-y: auto;" id="agentList">
                            @foreach($agents as $agent)
                            <label class="list-group-item list-group-item-action d-flex align-items-center py-2 m-0 cursor-pointer agent-item border-left-transparent">
                                <div class="custom-control custom-checkbox mr-3">
                                    <input type="checkbox" name="agent_ids[]" value="{{ $agent->id }}"
                                           class="custom-control-input agent-checkbox" id="agent_{{ $agent->id }}">
                                    <span class="custom-control-label" for="agent_{{ $agent->id }}"></span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold text-dark mb-0">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</div>
                                    <small class="text-muted"><i class="fas fa-id-badge me-1"></i>{{ $agent->matricule }}</small>
                                </div>
                                @if($agent->service)
                                    <span class="badge badge-soft-primary border small">{{ $agent->service->libelle }}</span>
                                @endif
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-primary text-white d-flex justify-content-between align-items-center py-2">
                        <small class="font-weight-bold">Total sélectionné :</small>
                        <span class="badge badge-light px-3 py-2 text-primary" id="count-selected">0</span>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : DÉTAILS -->
            <div class="col-lg-7">
                <div class="card shadow mb-4 border-top-info">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-info-circle me-1"></i> PARAMÈTRES DE L'ABSENCE</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Motif avec couleur Indigo -->
                            <div class="col-12 mb-3">
                                <label class="fw-bold text-indigo"><i class="fas fa-tag mr-1"></i> Motif de l'absence <span class="text-danger">*</span></label>
                                <select name="type_absence_id" class="form-control border-left-indigo custom-select shadow-sm" required>
                                    <option value="" disabled selected>Choisir un motif...</option>
                                    @foreach($typeAbsences as $type)
                                        <option value="{{ $type->id }}">{{ strtoupper($type->nom_type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dates avec couleur Warning -->
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-warning"><i class="fas fa-calendar-alt mr-1"></i> Date Début <span class="text-danger">*</span></label>
                                <input type="date" name="date_debut" class="form-control shadow-sm border-left-warning bg-light-warning" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-warning"><i class="fas fa-calendar-check mr-1"></i> Date Fin <span class="text-danger">*</span></label>
                                <input type="date" name="date_fin" class="form-control shadow-sm border-left-warning bg-light-warning" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="fw-bold text-muted"><i class="fas fa-comment-dots mr-1"></i> Observations communes</label>
                                <textarea name="motif" class="form-control shadow-sm border-left-secondary" rows="3" placeholder="Saisir la raison détaillée ici..."></textarea>
                            </div>

                            <!-- Justificatif avec couleur Success -->
                            <div class="col-12">
                                <label class="fw-bold text-success"><i class="fas fa-cloud-upload-alt mr-1"></i> Pièce justificative (PDF, Image)</label>
                                <div class="custom-file">
                                    <input type="file" name="document_justificatif" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label border-left-success" for="customFile">Choisir le fichier...</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg font-weight-bold py-3 transition-hover">
                            <i class="fas fa-check-circle mr-2"></i> ENREGISTRER L'ABSENCE GROUPÉE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .agent-item { transition: all 0.2s; border-left: 3px solid transparent; }
    .agent-item:hover { background-color: #f0f4f8 !important; border-left: 3px solid #4e73df; }
    .agent-checkbox:checked ~ .flex-grow-1 .text-dark { color: #4e73df !important; font-weight: 800 !important; }

    .border-left-indigo { border-left: .25rem solid #6610f2!important; }
    .text-indigo { color: #6610f2; }
    .bg-light-warning { background-color: #fffdf5; }
    .border-top-primary { border-top: .25rem solid #4e73df!important; }
    .border-top-info { border-top: .25rem solid #36b9cc!important; }

    .badge-soft-primary { background-color: #eef2ff; color: #4e73df; border: 1px solid #d1d9ff; }
    .transition-hover:hover { transform: translateY(-2px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important; }
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
        if(count > 0) {
            $('#count-selected').removeClass('badge-light').addClass('badge-white font-weight-bold');
        } else {
            $('#count-selected').addClass('badge-light').removeClass('badge-white');
        }
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
