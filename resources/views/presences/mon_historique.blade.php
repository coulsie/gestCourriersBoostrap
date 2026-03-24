@extends('layouts.app')

@section('content')
<style>
    @media print {
        /* 1. Masquage global */
        body * { visibility: hidden; }

        /* 2. Masquage des éléments interactifs (boutons, formulaires) */
        .btn, .card-footer, .card-body.bg-light, form, .no-print {
            display: none !important;
        }

        /* 3. RENDRE VISIBLE LE BLOC D'EN-TÊTE ET LE TABLEAU */
        /* Note : Utilisez l'ID 'printHeader' autour de votre h3 et des infos filtres */
        #printHeader, #printHeader *, #printableArea, #printableArea * {
            visibility: visible !important;
        }

        /* 4. Positionnement du bloc titre + filtres */
        #printHeader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px !important;
        }

        #printTitle {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px !important;
        }

        /* Style pour la ligne des filtres sous le titre */
        .print-filter-info {
            font-size: 13px;
            color: #555 !important;
            font-weight: bold;
        }

        /* 5. Positionnement du tableau (descendu pour laisser place aux filtres) */
        #printableArea {
            position: absolute;
            top: 100px;
            left: 0;
            width: 100%;
            border: none !important;
        }

        @page { size: A4 portrait; margin: 1.5cm; }

        /* 6. Pied de page dynamique */
        #printableArea::after {
            content: "Agent : {{ strtoupper(auth()->user()->agent->last_name ?? '') }} {{ auth()->user()->agent->first_name ?? '' }} | Total : {{ $mesPresences->count() }} | Imprimé le : {{ now()->format('d/m/Y H:i') }} | Page " counter(page);
            position: fixed;
            bottom: 0;
            right: 0;
            width: 100%;
            text-align: right;
            font-size: 10px;
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            visibility: visible;
        }

        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>



<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <!-- BOUTON FERMER (masqué à l'impression via .btn) -->
                <a href="{{ url('/home') }}" class="btn btn-outline-danger me-3 shadow-sm" title="Fermer et quitter">
                    <i class="fas fa-times"></i>
                </a>

                <!-- CONTENEUR D'EN-TÊTE POUR L'IMPRESSION -->
                <div id="printHeader">
                    <!-- LE TITRE -->
                    <h3 class="mb-0 fw-bold text-dark" id="printTitle">
                        Historique de Présences :
                        <span class="text-primary">
                            {{ strtoupper(auth()->user()->agent->last_name ?? '') }} {{ auth()->user()->agent->first_name ?? '' }}
                        </span>
                    </h3>

                    <!-- INFOS DE FILTRES (Visible uniquement sur papier via d-print-block) -->
                    <div id="printFilters" class="d-none d-print-block text-muted fw-bold small mt-1">
                        Période :
                        {{ request('date_debut') ? \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') : 'Début' }}
                        au
                        {{ request('date_fin') ? \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') : now()->format('d/m/Y') }}
                        | Statut : {{ request('statut') ?: 'Tous les statuts' }}
                    </div>
                </div>
            </div>
        <div class="d-flex gap-2">
        <!-- BOUTON IMPRIMER -->
        <a href="{{ request()->fullUrlWithQuery(['print' => 1]) }}" class="btn btn-outline-dark shadow-sm px-4">
            <i class="fas fa-print me-1"></i> IMPRIMER TOUT
        </a>
        <a href="{{ route('presences.monPointage') }}" class="btn btn-primary shadow-sm px-4">
            <i class="fas fa-clock"></i> Aller au Pointage
        </a>
    </div>
</div>



    <!-- ZONE DE FILTRES -->
    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body">
            <form action="{{ route('presences.monHistorique') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted">Du (Début)</label>
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted">Au (Fin)</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="Présent" {{ request('statut') == 'Présent' ? 'selected' : '' }}>Présent</option>
                        <option value="En Retard" {{ request('statut') == 'En Retard' ? 'selected' : '' }}>En Retard</option>
                        <option value="Absent" {{ request('statut') == 'Absent' ? 'selected' : '' }}>Absent</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="fas fa-filter me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('presences.monHistorique') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLEAU AVEC ID POUR IMPRESSION -->
    <div class="card shadow border-0 rounded-3 overflow-hidden" id="printableArea">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="py-3 ps-4 border-0">Date</th>
                            <th class="py-3 border-0">Arrivée</th>
                            <th class="py-3 border-0">Départ</th>
                            <th class="py-3 border-0 text-center">Statut</th>
                            <th class="py-3 pe-4 border-0">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mesPresences as $p)
                            <tr class="border-bottom">
                                <td class="ps-4 fw-bold text-secondary">
                                    <i class="far fa-calendar-alt me-2 text-primary no-print"></i>
                                    {{ \Carbon\Carbon::parse($p->heure_arrivee)->translatedFormat('d M Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border p-2 fw-normal">
                                        {{ \Carbon\Carbon::parse($p->heure_arrivee)->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->heure_depart)
                                        <span class="badge bg-light text-dark border p-2 fw-normal">
                                            {{ \Carbon\Carbon::parse($p->heure_depart)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 fw-normal">En cours</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $color = ($p->statut == 'Présent') ? 'bg-success' : (($p->statut == 'En Retard') ? 'bg-danger' : 'bg-secondary');
                                    @endphp
                                    <span class="badge {{ $color }} text-white px-3 py-2 w-75">{{ $p->statut }}</span>
                                </td>
                                <td class="pe-4 text-muted small italic">{{ $p->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Aucun résultat trouvé.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (new URLSearchParams(window.location.search).has('print')) {
            setTimeout(() => {
                window.print();
                window.onafterprint = () => {
                    window.location.href = window.location.pathname;
                };
            }, 500);
        }
    });
</script>
@endsection
