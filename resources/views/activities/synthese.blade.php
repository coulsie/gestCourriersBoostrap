@extends('layouts.app')

@section('content')
<!-- Import corrigé des icônes Bootstrap -->
<link rel="stylesheet" href="https://jsdelivr.net">

<div class="container py-4">
    <!-- Header Premium (Masqué à l'impression) -->
        <!-- Header Premium -->
    <!-- Header Premium -->
<div class="card border-0 shadow-lg mb-5 overflow-hidden no-print" style="border-radius: 2rem; background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);">
    <div class="card-body p-4 p-md-5 position-relative">
        <div class="row align-items-center" style="z-index: 2; position: relative;">

            <!-- Texte à gauche -->
            <div class="col-lg-5 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-5 fw-black mb-2" style="color: #ffffff !important; font-weight: 800;">Tableau de Bord</h1>
                <p class="h5 fw-light mb-0" style="color: #ffffff !important; opacity: 0.9;">Synthèse analytique des activités</p>
                <div class="mt-3">
                    <span class="badge py-2 px-3" style="background-color: rgba(255,255,255,0.2); color: #ffffff !important; border: 1px solid rgba(255,255,255,0.3);">
                        Période : {{ ucfirst($periode) }}
                    </span>
                </div>
            </div>

            <!-- Formulaire à droite -->
            <div class="col-lg-7">
                <form action="{{ route('activities.synthese') }}" method="GET" class="p-4 rounded-4" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px);">

                    <!-- Ligne des Sélecteurs -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold text-uppercase mb-2" style="color: #ffffff !important; display: block; letter-spacing: 1px;">Période de rapport</label>
                            <select name="periode" onchange="this.form.submit()" class="form-select border-0 fw-bold shadow-sm" style="background-color: #ffffff !important; color: #334155 !important; height: 45px;">
                                <option value="daily" {{ $periode == 'daily' ? 'selected' : '' }}>Quotidienne</option>
                                <option value="weekly" {{ $periode == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                                <option value="monthly" {{ $periode == 'monthly' ? 'selected' : '' }}>Mensuelle</option>
                                <option value="quarterly" {{ $periode == 'quarterly' ? 'selected' : '' }}>Trimestrielle</option>
                                <option value="semester" {{ $periode == 'semester' ? 'selected' : '' }}>Semestrielle</option>
                                <option value="yearly" {{ $periode == 'yearly' ? 'selected' : '' }}>Annuelle</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-uppercase mb-2" style="color: #ffffff !important; display: block; letter-spacing: 1px;">Filtrer par Direction</label>
                            <select name="direction_id" onchange="this.form.submit()" class="form-select border-0 fw-bold shadow-sm" style="background-color: #ffffff !important; color: #334155 !important; height: 45px;">
                                <option value="">Toutes Directions</option>
                                @foreach($directions as $dir)
                                    <option value="{{ $dir->id }}" {{ request('direction_id') == $dir->id ? 'selected' : '' }}>{{ $dir->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Nouvelle ligne pour le Bouton d'Impression (en bas à droite) -->
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <!-- Bouton avec Image SVG Directe (Garantit la visibilité) -->
                            <button type="button"
                                    onclick="window.print()"
                                    class="btn no-print shadow-sm btn-print-hover"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="left"
                                    title="Imprimer le rapport"
                                    style="background-color: #ffffff !important; border: none; width: 60px; height: 45px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.3s ease; padding: 0;">

                                <!-- Code SVG de l'imprimante (Couleur Indigo #6366f1) -->
                                <svg xmlns="http://w3.org" width="24" height="24" fill="#6366f1" class="bi bi-printer-fill" viewBox="0 0 16 16" style="display: block;">
                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                </svg>
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Titre visible uniquement à l'impression -->
    <div class="d-none d-print-block mb-4 text-center">
        <h1 class="fw-bold text-dark">SYNTHÈSE ANALYTIQUE DES ACTIVITÉS</h1>
        <h4 class="text-uppercase text-secondary">Période : {{ $periode }}</h4>
        <hr>
    </div>

    <!-- Grille des Directions -->
    <div class="row g-4" id="printable-area">
        @forelse($rapport as $item)
            <div class="col-12 print-card">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header border-0 p-4 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(90deg, #1e293b 0%, #334155 100%);">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-primary rounded-3 me-3 no-print">
                                <i class="bi bi-building-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h2 class="h4 fw-black text-white mb-0 text-uppercase">{{ $item['direction'] }}</h2>
                                <span class="badge bg-info text-dark fw-bold mt-1 no-print">Structure Administrative</span>
                            </div>
                        </div>
                        <div class="text-end text-white">
                            <div class="h3 fw-black mb-0">{{ $item['total_activites'] }}</div>
                            <div class="small opacity-50 fw-bold text-uppercase" style="font-size: 0.6rem;">Activités</div>
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
                                                <span class="fw-bold text-dark">{{ $activite['service'] }}</span>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-danger text-white px-3 py-2">
                                                    <i class="bi bi-calendar3 me-1"></i> {{ $activite['date'] }}
                                                </span>
                                            </td>
                                            <td class="pe-4 py-4">
                                                <div class="p-3 rounded-4 bg-white border border-start border-primary border-4">
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
            <div class="col-12 text-center py-5 no-print">
                <div class="p-5 bg-white rounded-5 shadow-sm border border-dashed">
                    <i class="bi bi-inbox text-muted display-1"></i>
                    <h3 class="fw-bold mt-3 text-dark">Aucun rapport trouvé</h3>
                </div>
            </div>
        @endforelse
    </div>
</div>
<!-- Pied de page visible UNIQUEMENT à l'impression -->
<div class="d-none d-print-block mt-5 pt-4 border-top">
    <div class="d-flex justify-content-between align-items-center">
        <div class="small text-secondary">
            <strong>Généré par :</strong> {{ Auth::user()->name }} ({{ Auth::user()->role ?? 'Utilisateur' }})
        </div>
        <div class="small text-secondary text-end">
            <strong>Date d'impression :</strong> {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>
    <div class="text-center mt-3 small opacity-50">
        <em style="font-size: 0.7rem;">Document généré via le Tableau de Bord des Activités</em>
    </div>
</div>


<!-- Script d'activation des bulles d'info -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation Tooltip Bootstrap 5.2.3
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
    
    @media print {
        /* ... vos styles existants ... */

        /* Force le pied de page à rester en bas si le rapport est court */
        .d-print-block {
            display: block !important;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Supprime les liens bleus soulignés à l'impression */
        a { text-decoration: none !important; color: black !important; }
    }

</script>

<style>
    .btn-print-hover:hover {
        transform: scale(1.1) translateY(-2px);
        background-color: #f8f9fa !important;
    }
<style>
    body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-black { font-weight: 800 !important; }
    .rounded-4 { border-radius: 1.25rem !important; }

    /* CSS POUR L'IMPRESSION */
    @media print {
        .no-print, .btn, form, nav, .navbar, .sidebar, footer, .badge.no-print {
            display: none !important;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body { background-color: white !important; padding: 0; margin: 0; }
        .container { width: 100% !important; max-width: 100% !important; }

        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            break-inside: avoid;
            margin-bottom: 1.5rem !important;
        }

        .card-header {
            background: #1e293b !important;
            color: white !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: white !important;
        }
    }

    /* Assure que les titres du tableau restent sombres à l'écran */
    .table thead th {
        background-color: #f8f9fa !important;
        color: #475569 !important;
        font-weight: 700;
    }
</style>


@endsection
