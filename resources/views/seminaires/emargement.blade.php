@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📋 Émargement : {{ $seminaire->titre }}</h3>
        <button onclick="window.print()" class="btn btn-outline-dark no-print"><i class="fas fa-print me-2"></i>Imprimer la liste</button>
    </div>

    <!-- SÉLECTEUR DE JOURS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 no-print">
        <div class="card-body">
            <h6 class="text-muted small fw-bold text-uppercase mb-3">Choisir le jour de présence</h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach($jours as $index => $jour)
                    <a href="{{ route('seminaires.emargement', [$seminaire->id, 'date_pointage' => $jour]) }}"
                       class="btn {{ $dateSelectionnee == $jour ? 'btn-primary shadow' : 'btn-light border' }} rounded-pill px-4">
                        Jour {{ $index + 1 }} <br>
                        <small>{{ \Carbon\Carbon::parse($jour)->translatedFormat('d M') }}</small>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- LISTE DES PRÉSENCES -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold">Situation du {{ \Carbon\Carbon::parse($dateSelectionnee)->translatedFormat('l d F Y') }}</h5>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Participant</th>
                        <th>Organisme / Structure</th>
                        <th class="text-center">Statut</th>
                        <th class="text-end pe-4 no-print">Saisie Heure</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $p)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $p->nom_agent ?? $p->nom_externe }}</td>
                        <td>{{ $p->organisme_externe ?? 'Interne' }}</td>
                        <td class="text-center">
                            @if($p->est_present)
                                <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm"
                                    style="background-color: #10b981; border: 1px solid #059669; box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);">
                                    <i class="fas fa-check-circle me-1"></i>
                                    PRÉSENT À {{ \Carbon\Carbon::parse($p->heure_pointage)->format('H:i') }}
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm"
                                    style="background-color: #ef4444; border: 1px solid #dc2626; box-shadow: 0 0 10px rgba(239, 68, 68, 0.3);">
                                    <i class="fas fa-times-circle me-1"></i>
                                    ABSENT
                                </span>
                            @endif
                        </td>

                        <td class="text-end pe-4 no-print">
                            <form action="{{ route('seminaires.update-pointage', [$seminaire->id, $p->id]) }}" method="POST" class="d-flex justify-content-end gap-1">
                                @csrf
                                <input type="hidden" name="date_pointage" value="{{ $dateSelectionnee }}">

                                <input type="time" name="heure_presence"
                                    value="{{ $p->heure_pointage ? \Carbon\Carbon::parse($p->heure_pointage)->format('H:i') : '' }}"
                                    class="form-control form-control-sm border-primary-subtle"
                                    style="width: 100px;"
                                    title="Modifier l'heure d'arrivée">

                                <button type="submit"
                                        class="btn btn-sm btn-primary rounded-circle shadow-sm btn-save-animate"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Enregistre l'heure de présence pour ce jour">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    /* Petite animation pour rendre le bouton plus interactif */
    .btn-save-animate:hover {
        transform: scale(1.2);
        background-color: #0d6efd;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.5) !important;
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection
