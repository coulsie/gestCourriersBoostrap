@extends('layouts.app')

@section('content')
<style>
    /* 1. Couleurs éclatantes pour les statuts */
    .status-present { background-color: #28a745 !important; color: white; }
    .status-retard  { background-color: #ffc107 !important; color: #000; }
    .status-absent  { background-color: #dc3545 !important; color: white; }
    .status-justifie { background-color: #17a2b8 !important; color: white; }

    /* 2. Design du tableau de statistiques (Synthèse) */
    .bg-gradient-dark { background: linear-gradient(45deg, #212529, #343a40); }

    .transition-row { transition: all 0.2s ease-in-out; cursor: default; }
    .transition-row:hover {
        background-color: rgba(13, 110, 253, 0.08) !important;
        transform: scale(1.002);
        box-shadow: inset 4px 0 0 #0d6efd;
    }

    /* Gestion de l'ascenseur et de l'en-tête fixe */
    .sticky-top {
        position: sticky !important;
        top: 0;
        z-index: 1020;
        background-color: white !important;
    }

    .table-stats thead th {
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }

    /* 3. Style personnalisé pour la barre de défilement (Scrollbar) */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #adb5bd;
    }

    /* 4. Style du badge de capacité (Rouge/Blanc) */
    .badge-capacity {
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
        border: 2px solid rgba(255,255,255,0.2);
    }

    /* 5. Pagination personnalisée */
    .page-item.active .page-link {
        background-color: #212529 !important;
        border-color: #212529 !important;
    }
    .page-link {
        color: #212529;
        font-weight: bold;
    }

    /* 6. Configuration de l'impression */
   @media print {
    /* Cache tout ce qui n'est pas le tableau ou l'en-tête d'impression */
    .no-print, .btn, .card-header, .form-control, .form-select, .pagination, nav {
        display: none !important;
    }

    /* Supprime les bordures de cartes et les ombres */
    .card { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
    .container { width: 100% !important; max-width: 100% !important; margin: 0; padding: 0; }

    /* Force l'affichage du tableau sur toute la page sans ascenseur */
    .table-responsive {
        max-height: none !important;
        overflow: visible !important;
    }

    /* Assure que l'en-tête du tableau n'est pas "sticky" sur le papier */
    .sticky-top { position: static !important; background-color: #f8f9fa !important; }

    /* Ajuste la taille de police pour faire tenir plus de colonnes */
    table { font-size: 10pt !important; width: 100% !important; }

    /* Saut de page intelligent pour ne pas couper une ligne au milieu */
    tr { page-break-inside: avoid; }
}

    /* 7. Utilitaires */
    .print-only { display: none; }
    .badge-status {
        padding: 0.5em 0.8em;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        display: inline-block;
        min-width: 100px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .table-hover tbody tr:hover { background-color: rgba(0,0,0,.03); }
</style>



<div class="container py-4">
    <!-- En-tête Impression -->
    <div class="print-only text-center mb-4">
        <h2 class="text-uppercase fw-bold">Rapport d'Assiduité des Agents</h2>
        <p class="text-muted">Période : {{ $mois ? \Carbon\Carbon::create()->month((int)$mois)->locale('fr')->translatedFormat('F') : 'Toute l\'année' }} {{ $annee }}</p>
        <hr>
    </div>

    <!-- Filtres (Masqués à l'impression) -->
    <div class="card shadow-sm border-0 mb-4 no-print">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Critères de Recherche</h6>

            <button onclick="window.print()" class="btn btn-sm shadow-sm fw-bold border-0 px-3"
                    style="background: linear-gradient(135s, #f8f9fa 0%, #e9ecef 100%); color: #212529; transition: 0.3s;">
                <i class="fas fa-print me-2 text-primary"></i>IMPRIMER L'ÉTAT
            </button>

        </div>
        <div class="card-body">
            <form action="{{ route('presences.etat') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">ANNÉE</label>
                    <select name="annee" class="form-select">
                        @for($i = 2024; $i <= 2026; $i++)
                            <option value="{{ $i }}" {{ $annee == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">MOIS</label>
                    <select name="mois" class="form-select">
                        <option value="">Tous les mois</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $mois == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('fr')->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="fas fa-search me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('presences.etat') }}" class="btn btn-outline-secondary" title="Réinitialiser">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Information Jours Ouvrables -->
    @if($mois)
    <div class="row mb-3">

    <div class="col-12">
    <div class="card shadow-sm border-0 bg-light">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-muted small text-uppercase">
                <i class="fas fa-calendar-check me-2 text-danger"></i>
                Capacité de la période (Hors week-ends & fériés) :
            </span>

            <!-- Badge Rouge avec Mois en blanc et mention Jours Ouvrables -->
            <span class="badge bg-danger text-white fs-6 shadow-sm px-3 py-2 border-capacity">
                @if($mois)
                    {{ \Carbon\Carbon::create()->month((int)$mois)->locale('fr')->translatedFormat('F') }} :
                @endif
                {{ $joursOuvrables ?? 0 }} Jours Ouvrables
            </span>
        </div>
    </div>
</div>

</div>
    @endif
    <!-- Statistiques Globales avec Ascenseur -->
<div class="card border-0 shadow-lg mb-5" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-gradient-dark py-3">
        <h6 class="mb-0 text-white fw-bold"><i class="fas fa-chart-line me-2"></i>SYNTHÈSE DE PERFORMANCE PAR AGENT</h6>
    </div>

    <!-- Conteneur de l'ascenseur (max-height à 400px) -->
    <div class="table-responsive" style="max-height: 450px; overflow-y: auto; scrollbar-width: thin;">
        <table class="table table-hover align-middle mb-0 table-stats">
            <thead class="text-secondary small text-uppercase fw-bolder sticky-top bg-white shadow-sm" style="z-index: 10;">
                <tr class="text-center">
                    <th class="text-start ps-4 py-3 bg-white" style="width: 30%">Agent</th>
                    <th class="py-3 bg-white"><span class="text-success"><i class="fas fa-check-circle me-1"></i>Présents</span></th>
                    <th class="py-3 bg-white"><span class="text-warning"><i class="fas fa-clock me-1"></i>Retards</span></th>
                    <th class="py-3 bg-white"><span class="text-danger"><i class="fas fa-times-circle me-1"></i>Absents</span></th>
                    <th class="py-3 bg-white"><span class="text-info"><i class="fas fa-file-medical me-1"></i>Justifiés</span></th>
                    <th class="py-3 bg-light" style="width: 15%">Total Général</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($statsAgents as $stat)
                <tr class="transition-row">
                    <td class="text-start ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold me-2" style="width: 35px; height: 35px; font-size: 0.9rem; background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                                {{ substr($stat['nom'], 0, 1) }}
                            </div>
                            <span class="fw-bold text-dark">{{ $stat['nom'] }}</span>
                        </div>
                    </td>
                    <td class="py-3"><span class="badge rounded-pill bg-success-subtle text-success fs-6 px-3 py-2 border border-success-subtle">{{ $stat['presents'] }}</span></td>
                    <td class="py-3"><span class="badge rounded-pill bg-warning-subtle text-warning fs-6 px-3 py-2 border border-warning-subtle">{{ $stat['retards'] }}</span></td>
                    <td class="py-3"><span class="badge rounded-pill bg-danger-subtle text-danger fs-6 px-3 py-2 border border-danger-subtle">{{ $stat['absents'] }}</span></td>
                    <td class="py-3"><span class="badge rounded-pill bg-info-subtle text-info fs-6 px-3 py-2 border border-info-subtle">{{ $stat['justifies'] }}</span></td>
                    <td class="py-3 bg-light fw-bolder fs-5 text-dark">{{ $stat['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination Suivant / Précédent -->
<div class="card shadow-sm border-0 mb-4 no-print bg-white p-3 rounded-3">
    <div class="d-flex flex-column align-items-center">
        <div class="mb-3">
            {{ $presences->links('pagination::bootstrap-5') }}
        </div>
        <div class="text-muted small">
            Affichage de <b>{{ $presences->firstItem() }}</b> à <b>{{ $presences->lastItem() }}</b> sur un total de <b>{{ $presences->total() }}</b> enregistrements
        </div>
    </div>
</div>

    <!-- Détail des Pointages -->
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark small text-uppercase">
                    <tr>
                        <th>Agent</th>
                        <th>Date & Heure Arrivée</th>
                        <th>Heure Départ</th>
                        <th class="text-center">Statut</th>
                        <th class="no-print">Observations</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($presences as $p)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ strtoupper($p->agent->last_name) }}</div>
                                <div class="text-muted">{{ ucfirst(strtolower($p->agent->first_name)) }}</div>
                            </td>
                            <td>
                                <i class="far fa-calendar-alt me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($p->heure_arrivee)->translatedFormat('d/m/Y') }}
                                <b class="ms-1 text-primary">{{ \Carbon\Carbon::parse($p->heure_arrivee)->format('H:i') }}</b>
                            </td>
                            <td>
                                @if($p->heure_depart)
                                    <i class="far fa-clock me-1 text-muted"></i>{{ \Carbon\Carbon::parse($p->heure_depart)->format('H:i') }}
                                @else
                                    <span class="text-danger small italic">Non pointé</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = match($p->statut) {
                                        'Présent' => 'status-present',
                                        'En Retard' => 'status-retard',
                                        'Absent' => 'status-absent',
                                        'Justifié' => 'status-justifie',
                                        default => 'bg-secondary text-white'
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">
                                    {{ $p->statut }}
                                </span>
                            </td>
                            <td class="no-print text-muted small italic">{{ $p->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">Aucun enregistrement pour cette période.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="print-only mt-5">
    <div class="d-flex justify-content-between">
        <div class="text-center" style="width: 200px;">
            <p class="mb-5 small fw-bold">L'Agent RH</p>
            <div style="border-bottom: 1px solid #ccc; height: 50px;"></div>
        </div>
        <div class="text-center" style="width: 200px;">
            <p class="mb-5 small fw-bold">La Direction</p>
            <div style="border-bottom: 1px solid #ccc; height: 50px;"></div>
        </div>
    </div>
    <div class="text-center mt-4">
        <small class="text-muted">Document généré le {{ now()->format('d/m/Y à H:i') }}</small>
    </div>
</div>
@endsection
