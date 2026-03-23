@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- BARRE DE FILTRES - TAILLE DE POLICE AUGMENTÉE -->
    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <form action="{{ route('imputations.index') }}" method="GET" class="row g-3 align-items-end">
               <!-- Recherche (Bleu/Primary) -->
    <div class="col-md-3">
        <label class="form-label fw-bold text-primary mb-2 fs-5">
            <i class="fas fa-search me-1"></i> RECHERCHE
        </label>
        <input type="text" name="search" class="form-control border-primary border-2 shadow-sm fs-5 py-2"
               value="{{ request('search') }}" placeholder="Réf. ou objet...">
    </div>

    <!-- Niveau (Vert/Success) -->
    <div class="col-md-2">
        <label class="form-label fw-bold text-success mb-2 fs-5">
            <i class="fas fa-layer-group me-1"></i> NIVEAU
        </label>
        <select name="niveau" class="form-select border-success border-2 shadow-sm fs-5 py-2">
            <option value="">Tous</option>
            <option value="primaire" {{ request('niveau') == 'primaire' ? 'selected' : '' }}>Primaire</option>
            <option value="secondaire" {{ request('niveau') == 'secondaire' ? 'selected' : '' }}>Secondaire</option>
            <option value="tertiaire" {{ request('niveau') == 'tertiaire' ? 'selected' : '' }}>Tertiaire</option>
        </select>
    </div>

    <!-- Statut (Orange/Warning) -->
    <div class="col-md-2">
        <label class="form-label fw-bold text-warning mb-2 fs-5">
            <i class="fas fa-tasks me-1"></i> STATUT
        </label>
        <select name="statut" class="form-select border-warning border-2 shadow-sm fs-5 py-2">
            <option value="">Tous les statuts</option>
            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
            <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>⚙️ En cours</option>
            <option value="termine" {{ request('statut') == 'termine' ? 'selected' : '' }}>✅ Terminé</option>
        </select>
    </div>

    <!-- Agent (Info/Bleu clair) -->
    <div class="col-md-3">
        <label class="form-label fw-bold text-info mb-2 fs-5">
            <i class="fas fa-user-tie me-1"></i> AGENT ASSIGNÉ
        </label>
        <select name="agent_id" class="form-select border-info border-2 shadow-sm fs-5 py-2">
            <option value="">Tous les agents</option>
            @foreach($allAgents as $agent)
                <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                    👤 {{ strtoupper($agent->last_name) }} {{$agent->first_name }}
                </option>
            @endforeach
        </select>
    </div>

                <!-- Boutons -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold w-100 shadow-sm border-2 py-2 fs-5">
                        <i class="fas fa-filter"></i>
                    </button>
                    <a href="{{ route('imputations.index') }}" class="btn btn-light fw-bold w-100 shadow-sm border-2 py-2 fs-5">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTION STATISTIQUES - CARTES DE SCORE -->
    <div class="row g-4 mb-4">
        <!-- Total Imputations -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border-left: 5px solid #4338ca !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-indigo-subtle p-3 rounded-3">
                            <i class="fas fa-file-invoice fa-2x text-indigo" style="color: #4338ca;"></i>
                        </div>
                        <span class="badge bg-indigo-subtle text-indigo rounded-pill px-3 py-2 fw-bold fs-6">TOTAL</span>
                    </div>

                    <h2 class="display-5 fw-black text-dark mb-0">
                        {{ $imputations instanceof \Illuminate\Pagination\LengthAwarePaginator ? $imputations->total() : $imputations->count() }}
                    </h2>

                    <p class="text-muted fw-bold mb-0 mt-2">Dossiers imputés</p>
                </div>
            </div>
        </div>

        <!-- En Cours -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border-left: 5px solid #f59e0b !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning-subtle p-3 rounded-3">
                            <i class="fas fa-spinner fa-2x text-warning"></i>
                        </div>
                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-bold fs-6">EN COURS</span>
                    </div>
                    <h2 class="display-5 fw-black text-dark mb-0">
                        {{ $imputations->where('statut', 'en_cours')->count() }}
                    </h2>
                    <p class="text-muted fw-bold mb-0 mt-2">Actions actives</p>
                </div>
            </div>
        </div>

        <!-- Terminées -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success-subtle p-3 rounded-3">
                            <i class="fas fa-check-double fa-2x text-success"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold fs-6">TERMINÉES</span>
                    </div>
                    <h2 class="display-5 fw-black text-dark mb-0">
                        {{ $imputations->where('statut', 'termine')->count() }}
                    </h2>
                    <p class="text-muted fw-bold mb-0 mt-2">Dossiers bouclés</p>
                </div>
            </div>
        </div>

        <!-- Retards (Alertes) -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border-left: 5px solid #ef4444 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger-subtle p-3 rounded-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-bold fs-6">HORS DÉLAI</span>
                    </div>
                    <h2 class="display-5 fw-black text-danger mb-0">
                        {{ $imputations->filter(fn($i) => \Carbon\Carbon::parse($i->echeancier)->isPast() && $i->statut != 'termine')->count() }}
                    </h2>
                    <p class="text-muted fw-bold mb-0 mt-2">Dossiers en retard</p>
                </div>
            </div>
        </div>
    </div>





    <!-- TABLEAU DES IMPUTATIONS - TEXTES AGRANDIS -->
        <!-- TABLEAU DES IMPUTATIONS -->
<div class="card shadow-lg border-0 rounded-4 overflow-hidden" id="printableCard">
    <div class="card-header bg-dark py-4 d-flex justify-content-between align-items-center border-bottom">
        <h4 class="mb-0 text-white fw-bold">
            <i class="fas fa-tasks me-2 text-warning"></i>
            Suivi des Imputations ({{ ucfirst(now()->translatedFormat('F Y')) }})
        </h4>
        <div class="d-flex gap-2 no-print">

           <button onclick="window.print()" class="btn btn-outline-light btn-lg fw-bold shadow-sm px-4">
                    <i class="fas fa-print me-1"></i> IMPRIMER
            </button>
            <a href="{{ route('imputations.create') }}" class="btn btn-warning btn-lg fw-bold shadow-sm px-4">
                <i class="fas fa-plus-circle me-1"></i> NOUVELLE IMPUTATION
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-5">
                <thead class="table-secondary">
                    <tr class="text-uppercase fw-black">
                        <th class="py-4 ps-4" style="width: 160px;">Niveau</th>
                        <th>Courrier (Réf & Objet)</th>
                        <th>Agents Assignés</th>
                        <th>Échéancier</th>
                        <th style="width: 18%;">Progression</th>
                        <th>Statut</th>
                        <th class="text-center no-print">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($imputations as $imputation)
                    <tr>
                        <!-- NIVEAU STYLE RENFORCÉ -->
                        <td class="ps-4 text-center">
                            @php
                                $niveauClass = [
                                    'primaire' => 'bg-danger text-white',
                                    'secondaire' => 'bg-warning text-dark',
                                    'tertiaire' => 'bg-info text-white'
                                ][$imputation->niveau] ?? 'bg-secondary text-white';
                            @endphp
                            <div class="{{ $niveauClass }} fw-black rounded-3 px-3 py-2 shadow-sm fs-6">
                                {{ strtoupper($imputation->niveau) }}
                            </div>
                        </td>

                        <!-- Détails Courrier -->
                        <td>
                            <div class="fw-bold text-primary mb-1 fs-5">{{ $imputation->courrier->reference }}</div>
                            <div class="text-dark fw-medium text-truncate" style="max-width: 300px; font-size: 1rem;">
                                {{ $imputation->courrier->objet }}
                            </div>
                        </td>

                        <!-- Agents -->
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($imputation->agents as $agent)
                                    <span class="badge bg-white text-indigo border border-indigo-subtle fw-bold p-2 fs-6 shadow-sm" style="color: #4338ca;">
                                        <i class="fas fa-user-circle me-1"></i>{{ strtoupper($agent->last_name) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>

                        <!-- Échéancier -->
                        <td class="fw-bold fs-5">
                            @if($imputation->echeancier)
                                @php
                                    $echeance = \Carbon\Carbon::parse($imputation->echeancier);
                                    $isPast = $echeance->isPast() && $imputation->statut != 'termine';
                                @endphp
                                <div class="{{ $isPast ? 'text-danger' : 'text-dark' }}">
                                    <i class="far fa-clock me-1"></i>{{ $echeance->format('d/m/Y') }}
                                    @if($isPast)
                                        <br>
                                        <span class="badge bg-danger text-white text-uppercase mt-1 shadow-sm" style="font-size: 0.75rem;">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Hors Délai
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted small">N/A</span>
                            @endif
                        </td>

                        <!-- Progression Dynamique -->
                        <td>
                            @if($imputation->statut == 'termine')
                                <div class="progress shadow-sm mb-1" style="height: 12px; border-radius: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                </div>
                                <small class="fw-bold text-success fs-6">100% Terminé</small>
                            @elseif($imputation->echeancier && $imputation->date_imputation)
                                @php
                                    $start = \Carbon\Carbon::parse($imputation->date_imputation);
                                    $end = \Carbon\Carbon::parse($imputation->echeancier);
                                    $totalDays = max(1, $start->diffInDays($end));
                                    $daysRemaining = now()->diffInDays($end, false);
                                    $percentRemaining = max(0, min(100, ($daysRemaining / $totalDays) * 100));
                                    $color = ($percentRemaining <= 30) ? 'bg-danger' : (($percentRemaining <= 60) ? 'bg-warning' : 'bg-success');
                                @endphp
                                <div class="progress shadow-sm mb-2" style="height: 12px; border-radius: 10px; background-color: #e2e8f0;">
                                    <div class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentRemaining }}%"></div>
                                </div>
                                <small class="fw-bold fs-6">{{ round($percentRemaining) }}% restant</small>
                            @else
                                <small class="text-muted italic fs-6">---</small>
                            @endif
                        </td>

                        <!-- Statut -->
                        <td>
                            @php
                                $statuts = [
                                    'en_attente' => ['class' => 'bg-soft-danger text-danger border-danger', 'label' => 'EN ATTENTE'],
                                    'en_cours' => ['class' => 'bg-soft-primary text-primary border-primary', 'label' => 'EN COURS'],
                                    'termine' => ['class' => 'bg-soft-success text-success border-success', 'label' => 'TERMINÉ'],
                                ];
                                $current = $statuts[$imputation->statut] ?? $statuts['en_attente'];
                            @endphp
                            <span class="badge {{ $current['class'] }} border fw-bold w-100 py-3 fs-6">
                                {{ $current['label'] }}
                            </span>
                        </td>

                        <!-- Actions (Masquées à l'impression) -->
                        <td class="text-center pe-4 no-print">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('imputations.show', $imputation->id) }}" class="btn btn-sm btn-info text-white" title="Voir"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('imputations.edit', $imputation->id) }}" class="btn btn-sm btn-light border" title="Modifier"><i class="fas fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-4">Aucune imputation trouvée pour ce mois.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
       <!-- PAGINATION PERSONNALISÉE -->
            <div class="card-footer bg-white py-3 border-top no-print">
                <div class="d-flex justify-content-between align-items-center">

                    {{-- Cas 1 : Mode Pagination (Navigation Web) --}}
                    @if($imputations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="text-muted small fw-bold">
                            Affichage de {{ $imputations->firstItem() }} à {{ $imputations->lastItem() }} sur {{ $imputations->total() }} résultats
                        </div>

                        <nav>
                            <ul class="pagination pagination-lg mb-0 shadow-sm">
                                {{-- Bouton Précédent --}}
                                @if ($imputations->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link border-2"><i class="fas fa-chevron-left me-1"></i> Précédent</span></li>
                                @else
                                    <li class="page-item"><a class="page-link border-2 fw-bold" href="{{ $imputations->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left me-1"></i> Précédent</a></li>
                                @endif

                                {{-- Numéros de pages --}}
                                @php
                                    $start = max(1, $imputations->currentPage() - 1);
                                    $end = min($imputations->lastPage(), $imputations->currentPage() + 1);
                                @endphp
                                @foreach ($imputations->getUrlRange($start, $end) as $page => $url)
                                    <li class="page-item {{ ($page == $imputations->currentPage()) ? 'active' : '' }}">
                                        <a class="page-link border-2 fw-bold" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Bouton Suivant --}}
                                @if ($imputations->hasMorePages())
                                    <li class="page-item"><a class="page-link border-2 fw-bold" href="{{ $imputations->nextPageUrl() }}" rel="next">Suivant <i class="fas fa-chevron-right ms-1"></i></a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link border-2">Suivant <i class="fas fa-chevron-right ms-1"></i></span></li>
                                @endif
                            </ul>
                        </nav>

                    {{-- Cas 2 : Mode Impression (Tout est affiché) --}}
                    @else
                        <div class="text-muted small fw-bold mx-auto">
                            <i class="fas fa-list me-2"></i> Mode impression : Affichage de la totalité des <strong>{{ $imputations->count() }}</strong> résultats filtrés.
                        </div>
                    @endif

                </div>
            </div>




    </div>
</div>
<!-- Style spécifique pour l'impression (à mettre dans votre stack CSS ou en haut du fichier) -->
<style>
    @media print {
        /* Masquer tout le reste de la page (menus, sidebar, etc.) */
        body * { visibility: hidden; }

        /* Afficher uniquement la carte des imputations */
        #printableCard, #printableCard * { visibility: visible; }

        /* Positionner la zone d'impression en haut à gauche */
        #printableCard {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }

        /* Masquer les boutons et la colonne Actions */
        .btn, .no-print, th:last-child, td:last-child {
            display: none !important;
        }

        /* Forcer l'affichage des couleurs de fond (badges, barres de progression) */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Ajuster la taille du texte pour l'impression */
        .table { font-size: 12px !important; }
    }
</style>
@endsection

