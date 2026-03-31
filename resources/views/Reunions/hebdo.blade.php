@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5;">

    {{-- Message d'information --}}
    <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center mb-4">
        <i class="fas fa-info-circle fa-lg me-3"></i>
        <div>
            <strong>Astuce :</strong> Maintenez <kbd class="bg-dark text-white">Ctrl</kbd> pour sélectionner plusieurs participants.
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark fw-bolder">🗓️ Programmation Hebdomadaire</h1>
        <div class="d-flex gap-2">
            {{-- Bouton corrigé --}}
            <button type="button" class="btn btn-outline-dark shadow-sm px-4 py-2 rounded-pill border-2 fw-bold bg-white"
                    data-bs-toggle="modal" data-bs-target="#modalAutresReunions">
                <i class="fas fa-calendar-alt me-2 text-primary"></i> Hors-semaine
            </button>

            <a href="{{ route('reunions.create') }}" class="btn shadow-lg px-4 py-2 rounded-pill border-0 text-white fw-bold" style="background: linear-gradient(45deg, #6366f1, #a855f7);">
                <i class="fas fa-plus-circle me-2"></i> Nouvelle Réunion
            </a>
        </div>
    </div>

    {{-- Tableau de la semaine --}}
    <div class="card shadow-lg mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 bg-white border-0">
            <h6 class="m-0 font-weight-bold" style="color: #6366f1;">
                <i class="fas fa-bolt me-2 text-warning"></i>Semaine du {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m') }} au {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #1e293b; color: #f8fafc;">
                        <tr class="text-uppercase small fw-bold">
                            <th class="ps-4 py-3">Jour & Heure</th>
                            <th>Objet & Détails</th>
                            <th>Rôles Maîtres</th>
                            <th>Équipe</th>
                            <th class="text-center no-print pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reunions as $reunion)
                        <tr>
                            <td class="ps-4">
                                <span class="badge rounded-pill px-3 py-2 mb-1 shadow-sm" style="background-color: #22d3ee; color: #083344;">
                                    {{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F') }}
                                </span><br>
                                <span class="fw-bold fs-4" style="color: #f43f5e;">
                                    {{ \Carbon\Carbon::parse($reunion->date_heure)->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                <h6 class="fw-bold mb-1 text-dark">{{ $reunion->objet }}</h6>
                                <small class="text-muted">{{ $reunion->ordre_du_jour ?? '---' }}</small>
                            </td>
                            <td>
                                <div class="small">
                                    <i class="fas fa-microphone text-primary me-1"></i> {{ $reunion->animateur->last_name }}<br>
                                    <i class="fas fa-pen text-success me-1"></i> {{ $reunion->redacteur->last_name }}
                                </div>
                            </td>
                            <td>
                                @foreach($reunion->participants as $participant)
                                    <span class="badge shadow-sm border-0 mb-1 fw-normal px-2 py-1 text-white"
                                        style="background: linear-gradient(45deg, #6366f1, #8b5cf6);">
                                        {{ substr($participant->last_name, 0, 1) }}. {{ $participant->first_name }}
                                    </span>
                                @endforeach
                            </td>

                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm rounded-pill border bg-white">
                                    <a href="{{ route('reunions.show', $reunion->id) }}" class="btn btn-sm text-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('reunions.edit', $reunion->id) }}" class="btn btn-sm text-warning"><i class="fas fa-magic"></i></a>
                                    <form action="{{ route('reunions.destroy', $reunion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Aucune réunion cette semaine.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- STRUCTURE DU MODAL (INDISPENSABLE) --}}
        {{-- STRUCTURE DU MODAL (Assurez-vous qu'elle est bien AVANT le @endsection) --}}
    <div class="modal fade shadow-lg" id="modalAutresReunions" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header bg-dark text-white border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-history me-2 text-warning"></i> Autres Réunions</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-4 py-3">Date</th>
                                <th>Objet</th>
                                <th>Animateur</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($autresReunions as $autre)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ \Carbon\Carbon::parse($autre->date_heure)->format('d/m/Y') }}</td>
                                <td class="fw-bold">{{ $autre->objet }}</td>
                                <td>{{ $autre->animateur->last_name }}</td>
                                <td class="text-center"><a href="{{ route('reunions.show', $autre->id) }}" class="btn btn-sm btn-primary rounded-pill">Consulter</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">Aucun historique disponible.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> {{-- Fermeture du container-fluid --}}

{{-- CHARGEMENT FORCÉ DES SCRIPTS --}}
<script src="https://code.jquery.com"></script>
<script src="https://cdn.jsdelivr.net"></script>

<script>
    // Script de secours si le bouton ne répond pas nativement
    document.addEventListener('DOMContentLoaded', function () {
        var btnHorsSemaine = document.querySelector('[data-bs-target="#modalAutresReunions"]');
        var modalEl = document.getElementById('modalAutresReunions');

        if (btnHorsSemaine && modalEl) {
            var bsModal = new bootstrap.Modal(modalEl);

            btnHorsSemaine.addEventListener('click', function (e) {
                e.preventDefault();
                console.log("Clic détecté - Ouverture forcée du modal");
                bsModal.show();
            });
        }
    });
</script>

<style>
    .fw-black { font-weight: 900; }
    .btn:hover { transform: translateY(-2px); }
</style>
@endsectiON
