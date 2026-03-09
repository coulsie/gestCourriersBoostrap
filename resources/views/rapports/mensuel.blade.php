@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0 border-top border-4 border-primary">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0 text-primary fw-bold"><i class="fas fa-file-invoice me-2"></i>Rapport de Présence Mensuel</h4>
                    <small class="badge bg-primary-subtle text-primary px-3 text-uppercase">{{ $nomMois }}</small>
                </div>
                <div class="col-auto">
                    <form class="d-flex gap-2 bg-light p-2 rounded-pill shadow-sm border">
                        <input type="month" name="periode" class="form-control form-control-sm border-0 bg-transparent" value="{{ $annee }}-{{ str_pad($mois, 2, '0', STR_PAD_LEFT) }}">
                        <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold"><i class="fas fa-filter"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="rapportTable">
                    <thead class="table-dark">
                        {{-- Ligne 1 : Titres principaux cliquables --}}
                        <tr>
                            <th class="text-start ps-4" style="cursor:pointer"><i class="fas fa-users me-2"></i>Agents</th>
                            <th class="text-start" style="cursor:pointer"><i class="fas fa-layer-group me-2"></i>Services</th>
                            <th class="text-center" style="cursor:pointer"><i class="fas fa-check-circle me-1 text-success"></i> Présents</th>
                            <th class="text-center" style="cursor:pointer"><i class="fas fa-clock me-1 text-warning"></i> Retards</th>
                            <th class="text-center text-danger" style="cursor:pointer"><i class="fas fa-user-times me-1"></i> Injustifiées</th>
                            <th class="text-center text-info" style="cursor:pointer"><i class="fas fa-file-medical me-1"></i> Justifiées</th>
                            <th class="text-center" style="cursor:pointer"><i class="fas fa-chart-line me-2"></i>Taux</th>
                            <th class="text-center no-export"><i class="fas fa-cog"></i></th>
                        </tr>


                    </thead>


                    <tbody>
                        @foreach($rapports as $rapport)
                            @php
                                // Préparation des données pour éviter les erreurs de calcul
                                $nomC = strtoupper($rapport->agent->last_name) . ' ' . $rapport->agent->first_name;
                                $serv = $rapport->agent->service->name ?? 'Non assigné';
                                $tx = $rapport->taux ?? 0;

                                // Logique de couleur du taux
                                $colorTaux = $tx >= 80 ? 'bg-success' : ($tx >= 50 ? 'bg-warning' : 'bg-danger');

                                // Palette de couleurs éclatantes pour les services
                                $palette = ['primary', 'indigo', 'success', 'danger', 'warning', 'info', 'purple', 'pink', 'orange', 'teal'];
                                $serviceId = $rapport->agent->service->id ?? 0;
                                $couleurS = $palette[$serviceId % count($palette)];
                            @endphp
                            <tr>
                                {{-- Colonne Agent --}}

                                <td data-search="{{ $nomC }}" data-order="{{ $nomC }}" class="ps-4 fw-bold">
                                    <span class="text-primary">{{ $nomC }}</span>
                                    <div class="small text-muted" style="font-size: 0.7rem;">ID: <span class="fw-bolder text-dark">{{ $rapport->agent->matricule }}</span></div>
                                </td>


                                {{-- Colonne Service (Cruciale pour le filtre) --}}


                                <td data-search="{{ $serv }}" data-order="{{ $serv }}">
                                    <span class="badge bg-{{ $couleurS }}-subtle text-{{ $couleurS }} border border-{{ $couleurS }} px-3 py-2 text-uppercase shadow-sm" style="font-weight: 700; font-size: 0.7rem;">
                                        {{ $serv }}
                                    </span>
                                </td>


                                {{-- Chiffres de présence --}}
                                <td class="text-center fw-bold text-dark">{{ $rapport->presents }}</td>
                                <td class="text-center fw-bold text-warning">{{ $rapport->retards }}</td>
                                <td class="text-center fw-bold text-danger">{{ $rapport->absences }}</td>
                                <td class="text-center fw-bold text-info">{{ $rapport->absences_justifiees }}</td>

                                {{-- Barre de progression du taux --}}
                                <td class="text-center" data-order="{{ $tx }}" style="min-width: 130px;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="progress flex-grow-1 shadow-sm" style="height: 10px; background-color: #eee !important;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated {{ $colorTaux }}"
                                                role="progressbar"
                                                style="width: {{ $tx }}%"></div>
                                        </div>
                                        <span class="ms-2 fw-bold text-dark" style="font-size: 0.8rem;">{{ $tx }}%</span>
                                    </div>
                                </td>

                                {{-- Action --}}
                                <td class="text-center">
                                    <a href="{{ route('rapports.export.pdf', ['agent_id' => $rapport->agent->id, 'periode' => $periode]) }}"
                                    class="btn btn-sm btn-outline-danger shadow-sm border-2"
                                    title="Exporter en PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table-dark { background-color: #2c3e50 !important; }
    .progress { border-radius: 10px; overflow: hidden; }
</style>

<!-- SCRIPTS CDNs CORRIGÉS (VERSION STABLE) -->
<!-- 1. CHARGEMENT DES BIBLIOTHÈQUES (URLs COMPLÈTES OBLIGATOIRES) -->
<!-- 1. CHARGEMENT DES BIBLIOTHÈQUES (AVEC LES VRAIS FICHIERS .js ET .css) -->

<link rel="stylesheet" href="https://cdn.datatables.net">
<script src="https://code.jquery.com"></script>
<script src="https://cdn.datatables.net"></script>
<script src="https://cdn.datatables.net"></script>

<script>
$(document).ready(function() {
    var table = $('#rapportTable').DataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
        "pageLength": 50,
        "dom": 'rtip',
        "orderCellsTop": true,
        "columnDefs": [
            { "orderable": true, "targets": 1 }, // Force l'activation du tri sur "Services"
            { "orderable": false, "targets": 7 } // Désactive le tri sur "Action"
        ],
        "order": [[ 1, "asc" ]] // Tri par défaut sur le Service (A-Z)
    });
});
</script>

@endsection
