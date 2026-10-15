@extends('layouts.app')

@section('content')
<style>

    .custom-print-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 35px;
        background-color: #ffffff !important;
        border-top: 1px solid #dee2e6 !important;
        font-size: 0.75rem !important;
        color: #6c757d !important;
    }


    /* --- STYLES ÉCRAN --- */
    .extra-small { font-size: 0.75rem; }
    .table-header-custom { background-color: #000; color: #fff; text-transform: uppercase; font-size: 0.85rem; }
    .badge-present { background-color: #198754 !important; color: #ffffff !important; }
    .badge-retard { background-color: #ffc107 !important; color: #000000 !important; }
    .badge-absent { background-color: #dc3545 !important; color: #ffffff !important; }
    .badge-justifie { background-color: #0d6efd !important; color: #ffffff !important; }

    /* --- STYLES IMPRESSION --- */
    @media print {
        /* Masquer les éléments superflus de l'écran */
        .no-print, .no-print * {
            display: none !important;
        }

        #printableArea {
            border: none !important;
            box-shadow: none !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .table-header-custom th {
            background-color: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #000 !important;
        }

        .badge-present, .badge-retard, .badge-absent, .badge-justifie {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .table {
            width: 100% !important;
        }

        .table td, .table th {
            border: 1px solid #dee2e6 !important;
            padding: 8px !important;
        }

        tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /*
           SOLUTION ULTIME POUR COMPTEUR DYNAMIQUE ET FLUIDE X/Y
           On configure la mise en page et les compteurs système de l'imprimante
        */
        @page {
            size: landscape;
            margin: 1cm 1cm 1.5cm 1cm;

            /* Les navigateurs basés sur Chromium gèrent les compteurs directement à l'impression */
            @bottom-right {
                content: "Page " counter(page) " / " counter(pages);
                font-family: Arial, sans-serif;
                font-size: 0.75rem;
                color: #6c757d;
                font-weight: bold;
            }
        }
    }
</style>



<div class="container-fluid py-4 px-4">
    <!-- EN-TÊTE -->
    <!-- EN-TÊTE -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div class="d-flex align-items-center">
            <a href="{{ url('/home') }}" class="btn btn-outline-danger me-3 shadow-sm border-2">
                <i class="fas fa-times"></i>
            </a>
            <h3 class="mb-0 fw-bold text-dark text-uppercase">Rapport Global des Présences 2026</h3>
        </div>

        <!-- MODIFICATION ICI : On appelle la fonction JS 'imprimerTout' -->
        <button type="button" onclick="imprimerTout()" class="btn btn-success shadow-sm px-4 no-print">
            <i class="fas fa-print me-2"></i> Imprimer le rapport complet
        </button>
    </div>


    <!-- ZONE DE FILTRAGE (no-print) -->
    <div class="card shadow-sm border-0 mb-4 bg-dark text-white rounded-3 no-print">
        <div class="card-body p-4">
            <form action="{{ route('presences.listeFiltree') }}" method="GET" id="filterForm">
                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-white-50">Période (Année 2026)</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-secondary border-0 text-white small">Du</span>
                            <input type="date" name="date_debut" class="form-control border-0" value="{{ request('date_debut') }}">
                            <span class="input-group-text bg-secondary border-0 text-white small">Au</span>
                            <input type="date" name="date_fin" class="form-control border-0" value="{{ request('date_fin') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-white-50">Statut</label>
                        <select name="statut" class="form-select border-0 shadow-sm">
                            <option value="">Tous les statuts</option>
                            <option value="Présent" {{ request('statut') == 'Présent' ? 'selected' : '' }}>🟢 Présent</option>
                            <option value="En Retard" {{ request('statut') == 'En Retard' ? 'selected' : '' }}>🟡 En Retard</option>
                            <option value="Absent" {{ request('statut') == 'Absent' ? 'selected' : '' }}>🔴 Absent</option>
                        </select>
                    </div>
                    <div class="col-md-5 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                            <i class="fas fa-filter me-2"></i>Appliquer
                        </button>
                        <a href="{{ route('presences.listeFiltree') }}" class="btn btn-outline-light shadow-sm">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-3 pt-3 border-top border-secondary">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-white-50">Direction</label>
                        <select name="direction_id" id="direction_id" class="form-select border-0 shadow-sm">
                            <option value="">Toutes les Directions</option>
                            @foreach($directions as $dir)
                                <option value="{{ $dir->id }}" {{ request('direction_id') == $dir->id ? 'selected' : '' }}>
                                    {{ $dir->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-white-50">Service</label>
                        <select name="service_id" id="service_id" class="form-select border-0 shadow-sm">
                            <option value="">Tous les Services</option>
                            @foreach($services as $ser)
                                <option value="{{ $ser->id }}"
                                        data-direction="{{ $ser->direction_id }}"
                                        {{ request('service_id') == $ser->id ? 'selected' : '' }}
                                        style="{{ request('direction_id') && request('direction_id') != $ser->direction_id ? 'display:none' : '' }}">
                                    {{ $ser->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLEAU DE RÉSULTATS -->
    <!-- TABLEAU DE RÉSULTATS -->
    <div id="printableArea" class="card shadow border-0 rounded-3 overflow-hidden">

        <!-- EN-TÊTE D'IMPRESSION DYNAMIQUE -->
        <div class="d-none d-print-block p-4 border-bottom mb-4">
            <div class="text-center">
                <h2 class="fw-bold text-uppercase mb-1">Rapport Global des Présences 2026</h2>
                <p class="text-muted small">Document généré le {{ now()->format('d/m/2026 à H:i') }}</p>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <ul class="list-unstyled small">
                        <li><strong>Direction :</strong>
                            {{ $directions->where('id', request('direction_id'))->first()->name ?? 'Toutes les Directions' }}
                        </li>
                        <li><strong>Service :</strong>
                            {{ $services->where('id', request('service_id'))->first()->name ?? 'Tous les Services' }}
                        </li>
                    </ul>
                </div>
                <div class="col-6 text-end">
                    <ul class="list-unstyled small">
                        <li><strong>Période :</strong>
                            @if(request('date_debut') && request('date_fin'))
                                Du {{ date('d/m/2026', strtotime(request('date_debut'))) }} au {{ date('d/m/2026', strtotime(request('date_fin'))) }}
                            @else
                                Année 2026 (Complète)
                            @endif
                        </li>
                        <li><strong>Statut :</strong> {{ request('statut') ?: 'Tous les statuts' }}</li>
                    </ul>
                </div>
            </div>
            <hr>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-custom">
                        <tr>
                            <th class="py-3 ps-4">Agent (Nom & Prénoms)</th>
                            <th class="py-3">Service / Direction</th>
                            <th class="py-3 text-center">Date</th>
                            <th class="py-3 text-center">Heures</th>
                            <th class="py-3 text-center">Statut</th>
                            <th class="py-3 pe-4 text-end">Observations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($resultats as $p)
                            <tr class="border-bottom">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ strtoupper($p->agent->last_name) }}</div>
                                    <div class="small text-secondary">{{ $p->agent->first_name }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold small text-primary">{{ $p->agent->service->name ?? 'N/A' }}</div>
                                    <div class="extra-small text-muted text-uppercase">{{ $p->agent->service->direction->name ?? 'N/A' }}</div>
                                </td>
                                <td class="text-center fw-bold text-secondary">
                                    {{ \Carbon\Carbon::parse($p->heure_arrivee)->format('d/m/2026') }}
                                </td>
                                <td class="text-center">
                                    <span class="text-success fw-bold">{{ \Carbon\Carbon::parse($p->heure_arrivee)->format('H:i') }}</span>
                                    <span class="mx-1 text-muted small">-</span>
                                    <span class="text-danger fw-bold">{{ $p->heure_depart ? \Carbon\Carbon::parse($p->heure_depart)->format('H:i') : '--:--' }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = match($p->statut) {
                                            'Présent' => 'badge-present',
                                            'En Retard' => 'badge-retard',
                                            'Absent' => 'badge-absent',
                                            'Absence Justifiée' => 'badge-justifie',
                                            default => 'bg-secondary text-white'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3 shadow-sm" style="min-width: 90px; font-weight: 600;">
                                        {{ $p->statut }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end small text-muted italic">
                                    {{ $p->note ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Aucune donnée trouvée pour cette période.</td>
                            </tr>
                        @endforelse
                    </tbody>


                            <!-- PIED DE PAGE IMPRESSION FLUIDE -->
                    <div class="d-none d-print-block custom-print-footer">
                        <div class="d-flex justify-content-between align-items-center px-4 w-100 h-100">
                            <div>
                                <strong>Dir. :</strong> <span class="text-uppercase fw-bold">{{ $directions->where('id', request('direction_id'))->first()->name ?? 'Toutes les directions' }}</span>
                                <span class="mx-1 text-secondary">|</span>
                                <strong>Serv. :</strong> <span class="fw-bold">{{ $services->where('id', request('service_id'))->first()->name ?? 'Tous les services' }}</span>
                                <span class="mx-1 text-secondary">|</span>
                                <strong>Période :</strong>
                                <span>
                                    @if(request('date_debut') && request('date_fin'))
                                        Du {{ date('d/m/2026', strtotime(request('date_debut'))) }} au {{ date('d/m/2026', strtotime(request('date_fin'))) }}
                                    @else
                                        Année 2026
                                    @endif
                                </span>
                            </div>
                            <!-- L'espace de droite reste vide en HTML car injecté nativement par le CSS @page -->
                            <div class="text-end"></div>
                        </div>
                    </div>


                </table>
            </div>
        </div>

        <!-- PAGINATION ÉCRAN (Suivant / Précédent) -->
        @if(!request()->has('print') && method_exists($resultats, 'hasPages') && $resultats->hasPages())
        <div class="card-footer bg-white border-top py-3 no-print">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Affichage de {{ $resultats->firstItem() }} à {{ $resultats->lastItem() }} sur {{ $resultats->total() }} résultats
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        @if ($resultats->onFirstPage())
                            <li class="page-item disabled"><span class="page-link shadow-none">Précédent</span></li>
                        @else
                            <li class="page-item"><a class="page-link shadow-none" href="{{ $resultats->previousPageUrl() }}" rel="prev">Précédent</a></li>
                        @endif

                        @if ($resultats->hasMorePages())
                            <li class="page-item"><a class="page-link shadow-none" href="{{ $resultats->nextPageUrl() }}" rel="next">Suivant</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link shadow-none">Suivant</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif

    </div>


    <!-- PAGINATION ÉCRAN (Suivant / Précédent) -->
    @if(!request()->has('print') && method_exists($resultats, 'hasPages') && $resultats->hasPages())
    <div class="card-footer bg-white border-top py-3 no-print">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Affichage de {{ $resultats->firstItem() }} à {{ $resultats->lastItem() }} sur {{ $resultats->total() }} résultats
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    @if ($resultats->onFirstPage())
                        <li class="page-item disabled"><span class="page-link shadow-none">Précédent</span></li>
                    @else
                        <li class="page-item"><a class="page-link shadow-none" href="{{ $resultats->previousPageUrl() }}" rel="prev">Précédent</a></li>
                    @endif

                    @if ($resultats->hasMorePages())
                        <li class="page-item"><a class="page-link shadow-none" href="{{ $resultats->nextPageUrl() }}" rel="next">Suivant</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link shadow-none">Suivant</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    @endif

</div>



</div>

<script>
    function imprimerTout() {
        // 1. On récupère l'URL actuelle avec ses filtres existants
        let url = new URL(window.location.href);

        // 2. On ajoute le paramètre print=1
        url.searchParams.set('print', '1');

        // 3. On redirige vers cette URL pour charger toutes les lignes
        window.location.href = url.toString();
    }

    // 4. Dès que la page se recharge AVEC le paramètre print, on lance l'impression automatiquement
    window.addEventListener('DOMContentLoaded', (event) => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('print')) {
            window.print();

            // Optionnel : Retire le paramètre 'print' après l'impression pour remettre la pagination au retour
            setTimeout(() => {
                let url = new URL(window.location.href);
                url.searchParams.delete('print');
                window.history.replaceState({}, document.title, url.toString());
            }, 1000);
        }
    });
</script>


@endsection
