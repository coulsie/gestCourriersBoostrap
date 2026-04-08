@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Dans emargement.blade.php -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">📋 Émargement : {{ $seminaire->titre }}</h3>
        <div class="no-print d-flex gap-2">
            <!-- NOUVEAU BOUTON QR JOURNALIER -->
            <a href="{{ route('seminaires.qrcodeJournalier', $seminaire->id) }}" target="_blank" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-qrcode me-2"></i>Afficher QR Journalier
            </a>

            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill">
                <i class="fas fa-print me-2"></i>Imprimer la liste
            </button>
        </div>
    </div>


    <!-- SÉLECTEUR DE JOURS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 no-print">
        <div class="card-body">
            <h6 class="text-muted small fw-bold text-uppercase mb-3">
                <i class="fas fa-calendar-day me-2 text-primary"></i>Choisir le jour de présence
            </h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach($jours as $index => $jour)
                    <a href="{{ route('seminaires.emargement', [$seminaire->id, 'date_pointage' => $jour]) }}"
                       class="btn {{ $dateSelectionnee == $jour ? 'btn-primary shadow text-white' : 'btn-light border text-dark' }} rounded-4 px-4 py-2 text-center"
                       style="min-width: 100px;">
                        <span class="small fw-bold">Jour {{ $index + 1 }}</span><br>
                        <span style="font-size: 0.8rem;">{{ \Carbon\Carbon::parse($jour)->translatedFormat('d M') }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- LISTE DES PRÉSENCES -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0 border-bottom">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-user-check me-2"></i>Situation du {{ \Carbon\Carbon::parse($dateSelectionnee)->translatedFormat('l d F Y') }}
            </h5>
        </div>

        {{-- Affichage des erreurs SQL ou Validation --}}
        @if ($errors->any())
            <div class="alert alert-danger mx-4 mt-3 border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Message de succès --}}
        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3 border-0 shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Participant</th>
                        <th>Organisme / Structure</th>
                        <th class="text-center">Statut du Jour</th>
                        <th class="text-end pe-4 no-print">Saisie Heure</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $p)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">
                                <span class="text-muted small me-1">[{{ $p->id }}]</span>
                                {{ $p->nom_agent ?? $p->nom_externe }}
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $p->organisme_externe ?? 'AGENT INTERNE' }}</span>
                        </td>
                        <td class="text-center">
                            {{-- Test sur les colonnes issues du LEFT JOIN (table seminaire_emargements) --}}
                            @if(isset($p->est_present) && $p->est_present == 1)
                                <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm"
                                    style="background-color: #10b981; border: 1px solid #059669; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
                                    <i class="fas fa-check-circle me-1"></i>
                                    PRÉSENT À {{ \Carbon\Carbon::parse($p->heure_pointage)->format('H:i') }}
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm"
                                    style="background-color: #ef4444; border: 1px solid #dc2626; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.1);">
                                    <i class="fas fa-times-circle me-1"></i>
                                    ABSENT
                                </span>
                            @endif
                        </td>

                        <td class="text-end pe-4 no-print">
                            {{-- Route pointant vers SeminaireController@updatePointage --}}
                            <form action="{{ route('seminaires.update-emargement', [$seminaire->id, $p->id]) }}" method="POST" class="d-flex justify-content-end gap-1">
                                @csrf
                                <input type="hidden" name="date_pointage" value="{{ $dateSelectionnee }}">

                                <div class="input-group input-group-sm" style="width: 130px;">
                                    <span class="input-group-text bg-white"><i class="far fa-clock text-muted"></i></span>
                                    <input type="time" name="heure_presence"
                                        value="{{ (isset($p->est_present) && $p->est_present == 1) ? \Carbon\Carbon::parse($p->heure_pointage)->format('H:i') : '' }}"
                                        class="form-control border-primary-subtle"
                                        required>
                                </div>

                                <button type="submit"
                                        class="btn btn-sm btn-primary rounded-circle shadow-sm btn-save-animate d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;"
                                        title="Valider la présence">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted italic">
                            Aucun participant inscrit pour ce séminaire.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-save-animate {
        transition: all 0.2s ease-in-out;
    }
    .btn-save-animate:hover {
        transform: scale(1.15);
        filter: brightness(1.1);
    }
    @media print {
        .no-print { display: none !important; }
        .card { border: 1px solid #ddd !important; box-shadow: none !important; }
        body { background-color: white !important; }
    }
</style>
@endsection
