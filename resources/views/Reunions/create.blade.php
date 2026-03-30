@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-calendar-plus me-2"></i> Programmer une nouvelle réunion</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reunions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Objet -->
                    <div class="col-md-8 mb-3">
                        <label class="fw-bold text-dark">Objet de la réunion</label>
                        <input type="text" name="objet" class="form-control" placeholder="ex: Comité de Direction" required>
                    </div>
                    <!-- Date et Heure -->
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold text-dark">Date et Heure</label>
                        <input type="datetime-local" name="date_heure" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Animateur -->
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-indigo"><i class="fas fa-microphone me-1"></i> Animateur</label>
                        <select name="animateur_id" class="form-control select2" required>
                            <option value="">Sélectionner l'animateur...</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">
                                    {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Rédacteur -->
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-success"><i class="fas fa-pen-nib me-1"></i> Rédacteur du rapport</label>
                        <select name="redacteur_id" class="form-control select2" required>
                            <option value="">Sélectionner le rédacteur...</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">
                                    {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Participants Internes (Agents) -->
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-primary"><i class="fas fa-users me-1"></i> Participants Internes (Agents)</label>
                        <select name="participants[]" class="form-control select2" multiple="multiple" data-placeholder="Cocher les agents">
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">
                                    {{ strtoupper($agent->last_name) }} {{ $agent->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Participants Externes (Saisie libre) -->
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-warning"><i class="fas fa-user-plus me-1"></i> Personnes Extérieures</label>
                        <input type="text" name="externes_simple" class="form-control" placeholder="Nom1, Nom2, Nom3...">
                        <small class="text-muted">Séparez les noms par une virgule.</small>
                    </div>

                </div>

                <!-- Ordre du jour -->
                <div class="mb-3">
                    <label class="fw-bold text-dark">Ordre du jour / Notes</label>
                    <textarea name="ordre_du_jour" class="form-control" rows="4" placeholder="Points à aborder..."></textarea>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('reunions.hebdo') }}" class="btn btn-secondary shadow-sm">Annuler</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Enregistrer la programmation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialisation forcée pour les EXTERNES
        $('.select2-tags').select2({
            theme: 'bootstrap-5',
            width: '100%',
            tags: true,                // PERMET LA SAISIE LIBRE
            multiple: true,            // INDISPENSABLE POUR PLUSIEURS NOMS
            tokenSeparators: [',', ';'], // Valide avec virgule ou point-virgule
            placeholder: "Tapez un nom et appuyez sur Entrée",
            allowClear: true,
            containerCssClass: 'select2-bootstrap-5-focus',
            // Cette ligne règle le problème de saisie impossible (focus) :
            dropdownParent: $('.select2-tags').parent()
        });

        // ASTUCE : Si "Entrée" ne marche pas, ce code force la validation du nom
        $('.select2-tags').on('select2:closing', function (e) {
            var term = $(this).data('select2').dropdown.$search.val();
            if (term) {
                var option = new Option(term, term, true, true);
                $(this).append(option).trigger('change');
            }
        });
    });
</script>
@endpush


@endsection
