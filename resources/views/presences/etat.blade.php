@extends('layouts.app')

@section('content')
<style>
    /* --- CONFIGURATION IMPRESSION --- */
    @media print {
        /* 1. Masquer tout par défaut */
        body * { visibility: hidden; }

        /* 2. Afficher uniquement les zones de rapport */
        #rapport-impression, #rapport-impression * { visibility: visible; }

        /* 3. Positionnement et suppression des limites de scroll */
        #rapport-impression {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .table-responsive {
            max-height: none !important; /* Supprime l'ascenseur */
            overflow: visible !important;
        }

        .card { border: none !important; box-shadow: none !important; }

        /* 4. Forcer les couleurs de fond (Badges et Entêtes) */
        .card-header {
            background: #212529 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }
        .badge {
            border: 1px solid #dee2e6 !important;
            -webkit-print-color-adjust: exact;
        }
        .sticky-top { position: static !important; }

        /* 5. Cacher les éléments inutiles même si dans la zone */
        .no-print { display: none !important; }
    }

    /* Styles pour l'écran */
    .transition-row:hover { background-color: rgba(0,0,0,0.02); }
    .sticky-top { top: 0; z-index: 10; }
</style>

<div class="container py-4">

    <!-- SECTION FILTRES (Masquée à l'impression) -->
    <div class="card shadow-sm border-0 mb-4 no-print">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Critères de Recherche</h6>
            <!-- Bouton Impression Contrasté -->
            <button onclick="window.print()" class="btn btn-sm shadow-sm fw-bold border-0 px-3"
                    style="background: #ffffff; color: #212529; border-radius: 4px; transition: 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.2) !important;">
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
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ZONE DE RAPPORT (Celle qui sera imprimée) -->
    <div id="rapport-impression">

        <!-- En-tête Impression (Visible uniquement sur papier) -->
        <div class="print-only text-center mb-4 d-none d-print-block">
            <h2 class="text-uppercase fw-bold">Rapport d'Assiduité des Agents</h2>
            <p class="text-muted">
                Période : {{ $mois ? \Carbon\Carbon::create()->month((int)$mois)->locale('fr')->translatedFormat('F') : 'Année' }} {{ $annee }}
            </p>
            <hr>
        </div>

        <!-- Synthèse de Performance -->
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-dark py-3">
                <h6 class="mb-0 text-white fw-bold"><i class="fas fa-chart-line me-2"></i>SYNTHÈSE DE PERFORMANCE PAR AGENT</h6>
            </div>

            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white sticky-top shadow-sm">
                        <tr class="text-center small text-uppercase">
                            <th class="text-start ps-4 py-3">Agent</th>
                            <th class="py-3 text-success">Présents</th>
                            <th class="py-3 text-warning">Retards</th>
                            <th class="py-3 text-danger">Absents</th>
                            <th class="py-3 text-info">Justifiés</th>
                            <th class="py-3 bg-light">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($statsAgents as $stat)
                        <tr class="transition-row">
                            <td class="text-start ps-4 py-3">
                                <span class="fw-bold text-dark">{{ $stat['nom'] }}</span>
                            </td>
                            <td><span class="badge rounded-pill bg-success-subtle text-success border-success-subtle">{{ $stat['presents'] }}</span></td>
                            <td><span class="badge rounded-pill bg-warning-subtle text-warning border-warning-subtle">{{ $stat['retards'] }}</span></td>
                            <td><span class="badge rounded-pill bg-danger-subtle text-danger border-danger-subtle">{{ $stat['absents'] }}</span></td>
                            <td><span class="badge rounded-pill bg-info-subtle text-info border-info-subtle">{{ $stat['justifies'] }}</span></td>
                            <td class="bg-light fw-bold">{{ $stat['total'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signatures (Visible uniquement sur papier) -->
        <div class="d-none d-print-block mt-5">
            <div class="row text-center">
                <div class="col-6">
                    <p class="fw-bold">Le Responsable RH</p>
                    <div style="height: 60px;"></div>
                    <p>_______________________</p>
                </div>
                <div class="col-6">
                    <p class="fw-bold">La Direction</p>
                    <div style="height: 60px;"></div>
                    <p>_______________________</p>
                </div>
            </div>
        </div>
    </div> <!-- Fin du rapport-impression -->

    <!-- PAGINATION ET DÉTAILS (Masqués à l'impression) -->
    <div class="no-print mt-4">
        {{ $presences->links('pagination::bootstrap-5') }}
        <div class="card shadow-sm border-0 mt-3 p-3">
            <h6 class="fw-bold text-muted small"><i class="fas fa-list me-2"></i>Détail journalier des pointages</h6>
            <!-- Vos lignes de détails ici... -->
        </div>
    </div>
</div>

@endsection
