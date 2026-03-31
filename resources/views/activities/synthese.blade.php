@extends('layouts.app')

@section('content')
<!-- Import des icônes si nécessaire -->
<link rel="stylesheet" href="https://jsdelivr.net">

<div class="container py-4">
    <!-- Header Premium avec Dégradé Éclatant -->
    <div class="card border-0 shadow-lg mb-5 overflow-hidden" style="border-radius: 2rem; background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-7 text-white text-center text-lg-start">
                    <h1 class="display-5 fw-black mb-2 text-white">Tableau de Bord</h1>
                    <p class="h5 fw-light opacity-90 mb-0">Synthèse analytique des activités</p>
                </div>

                <div class="col-lg-5 mt-4 mt-lg-0">
                    <!-- Filtres Stylisés en Blanc -->
                    <form action="{{ route('activities.synthese') }}" method="GET" class="row g-2 p-3 bg-white bg-opacity-10 rounded-4 backdrop-blur">
                        <div class="col-md-6">
                            <label class="small fw-bold text-white mb-1 text-uppercase" style="font-size: 0.65rem;">Période</label>
                            <select name="periode" onchange="this.form.submit()" class="form-select border-0 shadow-sm fw-bold">
                                <option value="daily" {{ $periode == 'daily' ? 'selected' : '' }}>Quotidienne</option>
                                <option value="weekly" {{ $periode == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                                <option value="monthly" {{ $periode == 'monthly' ? 'selected' : '' }}>Mensuelle</option>
                                <option value="quarterly" {{ $periode == 'quarterly' ? 'selected' : '' }}>Trimestrielle</option>
                                <option value="semester" {{ $periode == 'semester' ? 'selected' : '' }}>Semestrielle</option>
                                <option value="yearly" {{ $periode == 'yearly' ? 'selected' : '' }}>Annuelle</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-white mb-1 text-uppercase" style="font-size: 0.65rem;">Direction</label>
                            <select name="direction_id" onchange="this.form.submit()" class="form-select border-0 shadow-sm fw-bold">
                                <option value="">Toutes Directions</option>
                                @foreach($directions as $dir)
                                    <option value="{{ $dir->id }}" {{ request('direction_id') == $dir->id ? 'selected' : '' }}>{{ $dir->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des Directions -->
    <div class="row g-4">
        @forelse($rapport as $item)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <!-- En-tête de Direction Éclatant -->
                    <div class="card-header border-0 p-4 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(90deg, #1e293b 0%, #334155 100%);">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-primary rounded-3 me-3 shadow-primary">
                                <i class="bi bi-building-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h2 class="h4 fw-black text-white mb-0 text-uppercase tracking-tighter">{{ $item['direction'] }}</h2>
                                <span class="badge bg-info text-dark fw-bold mt-1">Structure Administrative</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="h3 fw-black text-white mb-0">{{ $item['total_activites'] }}</div>
                            <div class="small text-white opacity-50 fw-bold text-uppercase" style="font-size: 0.6rem;">Activités totales</div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="ps-4 py-3 fw-black text-secondary text-uppercase small" style="width: 250px;">Service Responsable</th>
                                        <th class="py-3 fw-black text-secondary text-uppercase small" style="width: 150px;">Date</th>
                                        <th class="py-3 fw-black text-secondary text-uppercase small">Réalisations & Observations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item['details'] as $activite)
                                        <tr class="border-bottom">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2"></div>
                                                    <span class="fw-bold text-dark">{{ $activite['service'] }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                                    <i class="bi bi-calendar3 me-1"></i> {{ $activite['date'] }}
                                                </span>
                                            </td>
                                            <td class="pe-4 py-4">
                                                <div class="p-3 rounded-4 bg-white border shadow-sm border-start border-primary border-4">
                                                    <p class="mb-0 text-dark" style="line-height: 1.6; font-size: 0.95rem;">
                                                        {{ $activite['texte'] }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-5 shadow-sm border border-dashed">
                    <i class="bi bi-inbox text-muted display-1"></i>
                    <h3 class="fw-bold mt-3">Aucun rapport trouvé</h3>
                    <p class="text-muted">Sélectionnez une autre période ou direction.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Configuration visuelle haute performance */
    body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-black { font-weight: 800 !important; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .rounded-5 { border-radius: 2.5rem !important; }
    .backdrop-blur { backdrop-filter: blur(10px); }
    .shadow-primary { shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39); }

    /* Animation au survol des lignes */
    .table tbody tr:hover { background-color: rgba(99, 102, 241, 0.02); }

    /* Espacement personnalisé */
    .tracking-tighter { letter-spacing: -0.02em; }

    /* Séparateur de direction */
    .border-primary { border-color: #6366f1 !important; }
</style>
@endsection
