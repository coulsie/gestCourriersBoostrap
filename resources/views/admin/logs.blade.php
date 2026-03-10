@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0 border-top border-4 border-dark">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-dark fw-bold"><i class="fas fa-history me-2 text-primary"></i> Journal des Événements Système</h4>
            <span class="badge bg-danger text-white px-3 fw-bold border border-white">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ $logs->total() }} Actions enregistrées
            </span>

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
                                    str_contains($event, 'created') => 'success', // Vert
                                    str_contains($event, 'updated') => 'warning', // Jaune
                                    str_contains($event, 'deleted') => 'danger',  // Rouge
                                    str_contains($event, 'réussie') => 'info',    // Bleu ciel
                                    default => 'secondary'                        // Gris
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
                                    <small class="fw-bold">{{ $log->auditable_type ? class_basename($log->auditable_type) : 'AUTH' }}</small>
                                    <span class="text-muted">#{{ $log->auditable_id ?? $log->id }}</span>
                                </td>
                                <td><code class="text-primary">{{ $log->ip_address }}</code></td>
                                <td class="text-center">
                                    {{-- Bouton pour déclencher le modal --}}


                                    <button type="button" class="btn btn-sm btn-outline-dark shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLog{{ $log->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- On place les modals ICI, hors de la table mais dans le card-body --}}
            @foreach($logs as $log)
                @include('admin.partials.modal_log', ['log' => $log])
            @endforeach

            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

{{-- CORRECT : Lien complet vers le JS de Bootstrap --}}

{{-- 1. Le script Bootstrap complet --}}
<script src="https://cdn.jsdelivr.net"></script>

{{-- 2. Le script d'activation automatique --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // On cherche tous les boutons qui ont data-bs-toggle="modal"
        var modalButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

        modalButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var targetId = this.getAttribute('data-bs-target');
                var modalElement = document.querySelector(targetId);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            });
        });
    });
</script>
