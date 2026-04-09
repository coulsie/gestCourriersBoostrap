@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4 no-print">
        <h2 class="fw-bold text-primary">{{ $seminaire->titre }}</h2>
        <p class="text-muted small">Cliquez sur un bouton pour changer de QR Code.</p>
    </div>

    <!-- Navigation : On utilise des IDs très simples -->
    <div class="d-flex justify-content-center flex-wrap gap-2 mb-5 no-print" role="tablist">
        @foreach($qrCodesParJour as $index => $item)
            <button class="btn btn-outline-primary rounded-pill px-4 fw-bold qr-tab-btn {{ $index === 0 ? 'active' : '' }}"
                    id="btn-day-{{ $index }}"
                    data-bs-toggle="pill"
                    data-bs-target="#pane-day-{{ $index }}"
                    type="button" role="tab">
                {{ $item['label'] }}
            </button>
        @endforeach
    </div>

    <!-- Contenu des Onglets -->
    <div class="tab-content">
        @foreach($qrCodesParJour as $index => $item)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                 id="pane-day-{{ $index }}"
                 role="tabpanel">

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-lg rounded-4 text-center p-5">
                            <span class="badge bg-primary rounded-pill mb-3 mx-auto px-4 py-2 fs-6 shadow-sm">{{ $item['label'] }}</span>
                            <h3 class="fw-bold text-dark text-uppercase mb-4">{{ $item['date'] }}</h3>

                            <!-- Zone QR Code -->
                            <div class="bg-white p-4 d-inline-block mx-auto rounded-4 border shadow-sm mb-4">
                                {!! $item['code'] !!}
                            </div>

                            <div class="alert alert-info border-0 mb-0">
                                <h6 class="fw-bold mb-1"><i class="fas fa-mobile-alt me-2"></i>POINTAGE DU JOUR</h6>
                                <p class="small mb-0 opacity-75">Ce code est unique pour la journée du {{ $item['date'] }}.</p>
                            </div>

                            <div class="mt-4 no-print">
                                <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 shadow">
                                    <i class="fas fa-print me-1"></i> Imprimer ce jour
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- SCRIPT DE FORÇAGE POUR BOOTSTRAP 5.2.3 --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const triggerButtons = document.querySelectorAll('.qr-tab-btn');

    triggerButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            // 1. Désactiver tous les boutons
            triggerButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.replace('btn-primary', 'btn-outline-primary');
            });

            // 2. Activer le bouton cliqué
            this.classList.add('active');
            this.classList.replace('btn-outline-primary', 'btn-primary');

            // 3. Forcer l'affichage du contenu via l'API Bootstrap 5
            const targetId = this.getAttribute('data-bs-target');
            const targetEl = document.querySelector(targetId);

            // Masquer tous les panneaux
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Afficher le panneau cible
            targetEl.classList.add('show', 'active');
        });
    });
});
</script>

<style>
    .qr-tab-btn.active { background-color: #0d6efd !important; color: white !important; }

    @media print {
        .no-print, .btn, .sidebar, nav, header { display: none !important; }
        .tab-pane { display: none !important; }
        .tab-pane.active { display: block !important; opacity: 1 !important; }
        .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; }
        .card { box-shadow: none !important; border: none !important; }
        body { background-color: white !important; }
    }
</style>
@endsection
