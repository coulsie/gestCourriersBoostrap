@extends('layouts.app')

@section('content')

<div class="container-fluid py-4" style="background-color: #f0f2f5;">

    {{-- Message d'information (Astuce) --}}
    <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center mb-4">
        <i class="fas fa-info-circle fa-lg me-3"></i>
        <div>
            <strong>Gestion des Séminaires :</strong> Cliquez sur l'icône <i class="fas fa-users text-primary"></i> pour gérer l'émargement des agents et des participants externes.
        </div>
    </div>

   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark fw-bolder">🎓 Gestion des Séminaires</h1>
        <div class="d-flex gap-2 flex-wrap">

            <!-- BOUTON IMPRIMER -->
            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-dark shadow-sm px-3 py-2 rounded-pill border-0 fw-bold no-print">
                <i class="fas fa-print me-1 text-warning"></i> Imprimer la liste
            </a>

            <!-- BOUTON NOUVEAU SÉMINAIRE (Dégradé identique à vos réunions) -->
            <a href="{{ route('seminaires.create') }}" class="btn shadow-lg px-4 py-2 rounded-pill border-0 text-white fw-bold no-print" style="background: linear-gradient(45deg, #6366f1, #a855f7);">
                <i class="fas fa-plus-circle me-1"></i> Nouveau Séminaire
            </a>
        </div>
    </div>

    {{-- Tableau des Séminaires --}}
    <div class="card shadow-lg mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 bg-white border-0">
            <h6 class="m-0 font-weight-bold" style="color: #6366f1;">
                <i class="fas fa-list-ul me-2 text-warning"></i>Liste globale des sessions de formation et séminaires
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #1e293b; color: #f8fafc;">
                        <tr class="text-uppercase small fw-bold">
                            <th class="ps-4 py-3">Date & Heure</th>
                            <th>Thème & Organisateur</th>
                            <th>Lieu & Participants</th>
                            <th>Statut / Rapport</th>
                            <th class="text-center no-print pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($seminaires as $seminaire)
                        <tr>
                            {{-- 1. DATE ET HEURE (Style Cyan/Rose identique) --}}
                            <td class="ps-4">
                                {{-- Date de début --}}
                                <span class="badge rounded-pill px-3 py-2 mb-1 shadow-sm" style="background-color: #22d3ee; color: #083344;">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($seminaire->date_debut)->translatedFormat('l d F Y') }}
                                </span><br>

                                {{-- Plage horaire (Début - Fin) --}}
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold fs-4" style="color: #f43f5e;">
                                        {{ \Carbon\Carbon::parse($seminaire->date_debut)->format('H:i') }}
                                    </span>
                                    <span class="mx-2 text-muted fw-bold">à</span>
                                    <span class="fw-bold fs-4" style="color: #6366f1;">
                                        {{ \Carbon\Carbon::parse($seminaire->date_fin)->format('H:i') }}
                                    </span>
                                </div>

                                {{-- Rappel de la date de fin (si différente du début) --}}
                                @if(\Carbon\Carbon::parse($seminaire->date_debut)->format('Y-m-d') != \Carbon\Carbon::parse($seminaire->date_fin)->format('Y-m-d'))
                                    <small class="text-muted d-block mt-1">
                                        Finit le : {{ \Carbon\Carbon::parse($seminaire->date_fin)->translatedFormat('d M Y') }}
                                    </small>
                                @endif
                            </td>

                            {{-- 2. THÈME ET ORGANISATEUR --}}
                            <td>
                                <div class="mb-1">
                                    <h6 class="fw-bold mb-0 text-dark text-uppercase">{{ $seminaire->titre }}</h6>
                                    <small class="badge bg-light text-primary border mt-1">
                                        <i class="fas fa-id-badge me-1"></i>ORG: {{ $seminaire->organisateur }}
                                    </small>
                                </div>
                                <p class="small text-muted mb-0 italic">{{ Str::limit($seminaire->description, 60) }}</p>
                            </td>

                            {{-- 3. LIEU ET NOMBRE DE PARTICIPANTS --}}
                            <td>
                                <div class="mb-1 small">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    <strong class="text-dark">{{ $seminaire->lieu }}</strong>
                                </div>
                                <div class="small">
                                    <i class="fas fa-users text-muted me-1"></i>
                                    <strong>{{ $seminaire->participations->count() }}</strong> / {{ $seminaire->nb_participants_prevu ?? '--' }} Inscrits
                                </div>
                            </td>

                           {{-- 4. STATUT --}}
                            <td>
                                @if($seminaire->statut == 'termine')
                                    <span class="badge shadow-sm text-white px-3 py-2 rounded-pill" style="background-color: #10b981;">
                                        <i class="fas fa-check-circle me-1"></i>TERMINÉ
                                    </span>
                                @elseif($seminaire->statut == 'en_cours')
                                    <span class="badge shadow-sm text-white px-3 py-2 rounded-pill animate__animated animate__pulse animate__infinite" style="background-color: #f59e0b;">
                                        <i class="fas fa-sync fa-spin me-1"></i>EN COURS
                                    </span>
                                @elseif($seminaire->statut == 'annule')
                                    <span class="badge shadow-sm text-white px-3 py-2 rounded-pill" style="background-color: #ef4444;">
                                        <i class="fas fa-times-circle me-1"></i>ANNULÉ
                                    </span>

                                {{-- CORRECTION ICI : Utilisez des espaces au lieu des underscores --}}
                                @elseif($seminaire->statut == 'en attente du rapport final')
                                    <span class="badge shadow-sm text-white px-3 py-2 rounded-pill" style="background-color: #f59e0b;">
                                        <i class="fas fa-clock me-1"></i>EN ATTENTE DU RAPPORT FINAL
                                    </span>

                                @else
                                    <span class="badge shadow-sm text-white px-3 py-2 rounded-pill" style="background-color: #3b82f6;">
                                        <i class="fas fa-clock me-1"></i>PLANIFIÉ
                                    </span>
                                @endif
                            </td>

                            {{-- 5. ACTIONS (Même style de boutons) --}}
                            <td class="text-center no-print pe-4">
                                <div class="d-flex justify-content-center gap-1">

                                    <!-- NOUVEAU : BOUTON QR CODE -->
                                    <a href="{{ route('seminaires.qrcode', $seminaire->id) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-dark border-0 px-2"
                                    title="Afficher le QR Code d'émargement">
                                        <i class="fas fa-qrcode fa-lg"></i>
                                    </a>
                                    {{-- Gérer les participants (Bouton spécial) --}}
                                    <a href="{{ route('seminaires.show', $seminaire->id) }}" class="btn btn-sm btn-outline-primary border-0 shadow-sm" title="Émargement & Participants">
                                        <i class="fas fa-users-cog fs-5"></i>
                                    </a>

                                    {{-- Modifier --}}
                                    <a href="{{ route('seminaires.edit', $seminaire->id) }}" class="btn btn-sm btn-outline-warning border-0 shadow-sm" title="Modifier">
                                        <i class="fas fa-edit fs-5"></i>
                                    </a>

                                    {{-- Supprimer --}}
                                    <form action="{{ route('seminaires.destroy', $seminaire->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce séminaire définitivement ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 shadow-sm">
                                            <i class="fas fa-trash-alt fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://popsy.co" style="width: 150px;" class="mb-3 opacity-50">
                                <h5 class="text-muted">Aucun séminaire dans la base de données.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination personnalisée --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $seminaires->links() }}
    </div>

</div>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-bolder { font-weight: 800 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .italic { font-style: italic; }
    .table-hover tbody tr:hover { background-color: #f8fafc; transition: 0.3s; }
    @media print {
        .no-print { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

@endsection
