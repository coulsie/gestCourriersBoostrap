@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0 border-top border-4 border-dark">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-dark fw-bold">
                <i class="fas fa-history me-2 text-primary"></i> Journal des Événements
            </h4>


            <div class="d-flex align-items-center gap-2">

                    {{-- Le Badge (Écriture noire sur Jaune) --}}
                    <span class="badge bg-warning text-dark px-3 py-2 fw-bold border border-dark shadow-sm"
                        style="font-size: 0.875rem; display: inline-flex; align-items: center; height: 31px;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $logs->total() }} Actions
                    </span>

                    {{-- Le Bouton (Aligné sur la même ligne) --}}
                    <form action="{{ route('admin.logs.clear') }}" method="POST" class="d-inline mb-0" onsubmit="return confirm('⚠️ ATTENTION : Voulez-vous vraiment vider TOUT le journal ? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm fw-bold px-3 py-1 shadow-sm" style="height: 31px; display: inline-flex; align-items: center;">
                            <i class="fas fa-broom me-2"></i> Vider le journal
                        </button>
                    </form>

            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="logTable">
                    <thead class="table-light border-bottom">
                        <tr>
                            <th class="py-3" style="width: 150px;">Date & Heure</th>
                            <th class="py-3">Utilisateur & IP</th>
                            <th class="py-3">Événement & Page</th>
                            <th class="py-3">Module / Cible</th>
                            <th class="py-3 text-center" style="width: 100px;">Appareil</th>
                            <th class="py-3 text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($logs as $log)
                            @php
                                $event = strtolower($log->event);
                                $badgeColor = match(true) {
                                    str_contains($event, 'created')   => 'success',
                                    str_contains($event, 'updated')   => 'warning',
                                    str_contains($event, 'deleted')   => 'danger',
                                    str_contains($event, 'connexion') => 'info',
                                    str_contains($event, 'archivage') => 'primary',
                                    default                           => 'secondary'
                                };

                                // Nettoyage du User Agent pour l'affichage court
                                $ua = strtolower($log->user_agent ?? '');
                                $isMobile = str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone');
                            @endphp

                            <tr>
                                {{-- 1. Date & Heure --}}
                                <td class="fw-bold small">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>

                                {{-- 2. Utilisateur --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-light rounded-circle p-1 text-center" style="width:32px">
                                            <i class="fas fa-user text-muted small"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $log->user->name ?? 'Système' }}</div>
                                            <code class="text-muted" style="font-size: 0.7rem;">{{ $log->ip_address }}</code>
                                        </div>
                                    </div>
                                </td>

                                {{-- 3. Événement & URL (Fusionnés pour plus de clarté) --}}
                                <td>
                                    <span class="badge bg-{{ $badgeColor }} text-white px-2 py-1 text-uppercase mb-1" style="font-size: 0.65rem;">
                                        {{ $log->event }}
                                    </span>
                                    @if($log->url)
                                        <div class="text-truncate text-muted" style="max-width: 180px; font-size: 0.75rem;" title="{{ $log->url }}">
                                            <i class="fas fa-link me-1"></i>{{ str_replace(url('/'), '', $log->url) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- 4. Module / Cible --}}
                                <td>
                                    @if(!empty($log->auditable_type) && $log->auditable_type !== 'Système')
                                        <span class="badge bg-light text-primary border fw-bold">
                                            {{ class_basename($log->auditable_type) }}
                                        </span>
                                        <small class="text-muted d-block">ID: #{{ $log->auditable_id }}</small>
                                    @else
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                                            <i class="fas fa-shield-alt me-1"></i> AUTH
                                        </span>
                                    @endif
                                </td>

                                {{-- 5. Appareil (Icône dynamique) --}}
                                <td class="text-center">
                                    <span title="{{ $log->user_agent }}" style="cursor: help;">
                                        @if($isMobile)
                                            <i class="fas fa-mobile-alt text-danger fs-5"></i>
                                            <small class="d-block text-muted" style="font-size: 0.6rem;">Mobile</small>
                                        @else
                                            <i class="fas fa-desktop text-primary fs-5"></i>
                                            <small class="d-block text-muted" style="font-size: 0.6rem;">PC</small>
                                        @endif
                                    </span>
                                </td>

                                {{-- 6. Actions --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        {{-- Bouton Voir (Largeur fixe de 35px) --}}
                                        <button type="button" class="btn btn-sm btn-outline-dark shadow-sm"
                                                style="width: 35px; height: 32px;"
                                                onclick="var myModal = new bootstrap.Modal(document.getElementById('modalLog{{ $log->id }}')); myModal.show();">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- Formulaire de suppression --}}
                                        <form action="{{ route('admin.logs.destroy', $log->id) }}" method="POST" class="m-0" onsubmit="return confirm('Supprimer définitivement ?')">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Bouton Supprimer (Même largeur fixe) --}}
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" style="width: 35px; height: 32px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            @include('admin.partials.modal_log', ['log' => $log])
                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- On place les modals ICI, hors de la table mais dans le card-body --}}


                       <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>

{{-- BOUCLE DE MODALS BIEN À PART --}}
@foreach($logs as $log)
    @include('admin.partials.modal_log', ['log' => $log])
@endforeach

@endsection

{{-- LIEN BOOTSTRAP ENFIN COMPLET ET CORRECT --}}
<script src="https://cdn.jsdelivr.net"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gestion de l'ouverture pour CHAQUE bouton "œil"
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const modalEl = document.querySelector(targetId);
            if (modalEl) {
                // On utilise getOrCreateInstance pour garantir l'unicité par ID de log
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        });
    });

    // Gestion de la fermeture pour TOUS les boutons fermer
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-bs-dismiss="modal"]')) {
            const modalEl = e.target.closest('.modal');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                // Nettoyage forcé du fond noir
                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style = "";
                }, 150);
            }
        }
    });
});
</script>
