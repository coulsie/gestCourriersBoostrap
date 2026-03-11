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
                    <thead class="table-light">
                        <tr>
                            <th>Date & Heure</th>
                            <th>Utilisateur</th>
                            <th>Événement</th>
                            <th>Module / Cible</th>
                            <th>Adresse IP</th>
                            <th class="text-center">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)

                            @php
                                $event = strtolower($log->event);
                                $badgeColor = match(true) {
                                    str_contains($event, 'created')   => 'success',   // Vert
                                    str_contains($event, 'updated')   => 'warning',   // Jaune
                                    str_contains($event, 'deleted')   => 'danger',    // Rouge
                                    str_contains($event, 'connexion') => 'info',      // Bleu ciel
                                    str_contains($event, 'archivage') => 'primary',   // Bleu foncé (pour vos courriers)
                                    default                           => 'secondary'  // Gris
                                };
                            @endphp


                            <tr>
                                <td class="fw-bold">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-light rounded-circle p-1">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $log->user->name ?? 'Système' }}</div>
                                            <small class="text-muted">{{ $log->user->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-{{ $badgeColor }} text-white px-2 py-1 text-uppercase shadow-sm">
                                        {{ $log->event }}
                                    </span>
                                </td>
                               <td>
                                    @if(!empty($log->auditable_type) && $log->auditable_type !== 'Système')
                                        {{-- Cas d'un modèle (Courrier, Utilisateur, etc.) --}}
                                        <small class="fw-bold text-primary">{{ class_basename($log->auditable_type) }}</small>
                                        <span class="text-muted">#{{ $log->auditable_id }}</span>
                                    @else
                                        {{-- Cas d'une action système (Connexion, Déconnexion) --}}
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2">
                                            <i class="fas fa-shield-alt me-1"></i> AUTHENTIFICATION
                                        </span>
                                        <small class="text-muted ms-1">ID-LOG #{{ $log->id }}</small>
                                    @endif
                                </td>

                                <td><code class="text-primary">{{ $log->ip_address }}</code></td>

                                <td class="text-center">
                                    {{-- Bouton Voir --}}


<button type="button" class="btn btn-sm btn-outline-dark shadow-sm"
        onclick="var myModal = new bootstrap.Modal(document.getElementById('modalLog{{ $log->id }}')); myModal.show();">
    <i class="fas fa-eye"></i>
</button>


                                    {{-- Bouton Supprimer --}}
                                    <form action="{{ route('admin.logs.destroy', $log->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce log définitivement ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm ms-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
