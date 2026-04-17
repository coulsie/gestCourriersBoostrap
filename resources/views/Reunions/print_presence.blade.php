@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 shadow-none">

    {{-- En-tête Officiel --}}
    <div class="row align-items-center mb-4 border-bottom pb-3">
        <div class="col-2">
            <img src="{{ asset('images/DGI.png') }}" style="max-height: 70px;">
        </div>
        <div class="col-8 text-center">
            <h4 class="fw-bold mb-0" style="font-size: 1rem;">DIRECTION DE LA STRATEGIE, DES ETUDES ET DES STATISTIQUES FISCALES</h4>
            <p class="text-muted fw-bold small mb-0">(DSESF)</p>
            <hr class="mx-auto w-25 my-2" style="border-top: 2px solid #000;">
            <h5 class="fw-bold text-uppercase mt-2">LISTE D'ÉMARGEMENT</h5>
        </div>
        <div class="col-2 text-end small text-muted">
            Réf: {{ $reunion->id }}/{{ date('Y') }}
        </div>
    </div>

    {{-- Détails de la Réunion --}}
    <div class="mb-4 p-3 border rounded-3 bg-light">
        <div class="row g-3">
            <div class="col-12"><strong>OBJET :</strong> {{ strtoupper($reunion->objet) }}</div>
            <div class="col-6"><strong>DATE :</strong> {{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F Y') }}</div>
            <div class="col-6"><strong>LIEU :</strong> {{ $reunion->lieu }}</div>
        </div>
    </div>

    {{-- Tableau d'émargement --}}
    <table class="table table-bordered border-dark align-middle">
        <thead class="text-center bg-light">
            <tr class="small fw-bold text-uppercase">
                <th style="width: 5%">N°</th>
                <th style="width: 30%">Nom et Prénoms</th>
                <th style="width: 20%">Fonction / Titre</th>
                <th style="width: 15%">Structure</th>
                <th style="width: 15%">Signature</th>
            </tr>
        </thead>
        <tbody>
           @foreach($listeParticipants as $index => $p)
            <tr style="height: 60px;">
                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                <td class="ps-3 fw-bold">{{ strtoupper($p->nom) }}</td>
                {{-- Cette cellule affichera désormais : Fonction | Email | Téléphone --}}
                <td class="text-center small">{{ $p->fonction }}</td>
                <td class="text-center">
                    <span class="{{ $p->origine == 'DSESF' ? 'fw-bold' : '' }}">{{ $p->origine }}</span>
                </td>
                <td style="border-bottom: 1px solid #000;"></td>
            </tr>
            @endforeach
            {{-- Lignes vides pour les participants de dernière minute --}}
            @for ($i = 1; $i <= 3; $i++)
            <tr style="height: 60px;">
                <td class="text-center text-muted">{{ $listeParticipants->count() + $i }}</td>
                <td></td><td></td><td></td><td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    {{-- Zone de validation --}}
    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p class="fw-bold mb-5">Visa du Responsable</p>
            <div class="mt-5 border-top border-dark w-75 mx-auto"></div>
        </div>
    </div>

    {{-- Bouton d'action --}}
    <div class="text-center mt-5 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">
            <i class="fas fa-print me-2"></i> LANCER L'IMPRESSION
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-link text-muted mt-2 d-block">Retour</a>
    </div>
</div>

<style>
    @media print {
        .no-print, nav, .sidebar, header, footer { display: none !important; }
        body { background-color: white !important; padding: 0; }
        .container { width: 100% !important; max-width: 100% !important; border: none !important; }
        .table { border-color: #000 !important; }
    }
</style>
@endsection
