@extends('layouts.app')

@section('content')
<style>
    /* --- STYLES ÉCRAN --- */
    .extra-small { font-size: 0.75rem; }
    .table-header-custom { background-color: #000; color: #fff; text-transform: uppercase; font-size: 0.85rem; }
    .badge-present { background-color: #198754 !important; color: #ffffff !important; }
    .badge-retard { background-color: #ffc107 !important; color: #000000 !important; }
    .badge-absent { background-color: #dc3545 !important; color: #ffffff !important; }
    .badge-justifie { background-color: #0d6efd !important; color: #ffffff !important; }

    /* --- STYLES IMPRESSION --- */
    @media print {
        /* 1. On cache TOUT ce qui est sur la page (menus, barres latérales, filtres) */
        body * {
            visibility: hidden;
        }

        /* 2. On réaffiche UNIQUEMENT la zone du tableau (l'ID que tu as mis) */
        #printableArea, #printableArea * {
            visibility: visible;
        }

        /* 3. On repositionne le tableau en haut à gauche de la feuille */
        #printableArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        /* 4. On force les titres de colonnes (Fond noir / Texte blanc) */
        .table-header-custom th {
            background-color: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #000 !important;
        }

        /* 5. On force les badges en couleur sur le papier */
        .badge-present, .badge-retard, .badge-absent, .badge-justifie {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* 6. Mise en page générale */
        @page { size: landscape; margin: 1cm; }
        .table td, .table th { border: 1px solid #dee2e6 !important; padding: 8px !important; }
        .no-print { display: none !important; }
    }
</style>


<div class="container-fluid py-4 px-4">
    <!-- EN-TÊTE -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div class="d-flex align-items-center">
            <a href="{{ url('/home') }}" class="btn btn-outline-danger me-3 shadow-sm border-2">
                <i class="fas fa-times"></i>
            </a>
            <h3 class="mb-0 fw-bold text-dark text-uppercase">Rapport Global des Présences 2026</h3>
        </div>

        <button type="button" onclick="window.print()" class="btn btn-success shadow-sm px-4 no-print">
            <i class="fas fa-print me-2"></i> Imprimer
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
    <div id="printableArea" class="card shadow border-0 rounded-3 overflow-hidden">

        <!-- Ce titre sera invisible sur ton site, mais apparaîtra sur l'impression -->
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
                </table>
            </div>
        </div>

        <!-- PAGINATION (Suivant / Précédent) -->
        {{-- On ne vérifie la pagination QUE si on n'est pas en mode impression --}}
        {{-- On vérifie d'abord si on n'est PAS en mode impression et si l'objet peut paginer --}}
        @if(!request()->has('print') && method_exists($resultats, 'hasPages') && $resultats->hasPages())
        <div class="card-footer bg-white border-top py-3 no-print">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    {{-- Utilisation de method_exists pour sécuriser les appels aux fonctions de pagination --}}
                    Affichage de {{ $resultats->firstItem() }} à {{ $resultats->lastItem() }} sur {{ $resultats->total() }} résultats
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Bouton Précédent --}}
                        @if ($resultats->onFirstPage())
                            <li class="page-item disabled"><span class="page-link shadow-none">Précédent</span></li>
                        @else
                            <li class="page-item"><a class="page-link shadow-none" href="{{ $resultats->previousPageUrl() }}" rel="prev">Précédent</a></li>
                        @endif

                        {{-- Bouton Suivant --}}
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
    // Uniquement le filtrage (sans les fonctions d'impression qui buggent)
    document.getElementById('direction_id')?.addEventListener('change', function() {
        var dirId = this.value;
        var serviceSelect = document.getElementById('service_id');
        var options = serviceSelect.querySelectorAll('option');
        options.forEach(function(opt) {
            if (opt.value === "" || dirId === "" || opt.getAttribute('data-direction') === dirId) {
                opt.style.display = "block";
            } else {
                opt.style.display = "none";
            }
        });
        serviceSelect.value = "";
    });
</script>


@endsection
