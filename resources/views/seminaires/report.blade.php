@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4 text-uppercase">📊 État Global des Séminaires</h4>

    <!-- Cartes de résumé -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 p-3">
                <small>Total Séminaires</small>
                <h2 class="fw-bold">{{ $totalSeminaires }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark border-0 shadow-sm rounded-4 p-3">
                <small>En attente de rapport</small>
                <h2 class="fw-bold">{{ $enAttenteRapport }}</h2>
            </div>
        </div>
    </div>

    <!-- Tableau détaillé -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Titre / Date</th>
                        <th>Statut</th>
                        <th class="text-center">Taux Présence</th>
                        <th class="text-center">Documents</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats as $s)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $s->titre }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($s->date_debut)->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            @php
                                // Définition de la couleur en fonction du statut
                                $badgeColor = 'bg-secondary'; // Par défaut
                                if($s->statut == 'termine') $badgeColor = 'bg-success';
                                elseif($s->statut == 'en_cours') $badgeColor = 'bg-warning text-dark'; // Jaune (souvent mieux avec texte noir)
                                elseif($s->statut == 'annule') $badgeColor = 'bg-danger';
                                elseif($s->statut == 'en attente du rapport final') $badgeColor = 'bg-info';
                                elseif($s->statut == 'planifie') $badgeColor = 'bg-primary';
                            @endphp

                            <span class="badge rounded-pill {{ $badgeColor }} text-white px-3 shadow-sm">
                                {{ strtoupper($s->statut) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                $pourcentage = $s->inscrits_total > 0 ? ($s->presents_count / $s->inscrits_total) * 100 : 0;
                            @endphp
                            <div class="fw-bold">{{ round($pourcentage) }}%</div>
                            <small class="text-muted">{{ $s->presents_count }} / {{ $s->inscrits_total }} présents</small>
                        </td>
                        <td class="text-center">
                            @if($s->rapports_count > 0)
                                @php
                                    // On récupère le document de type 'rapport'
                                    $rapport = $s->documents->where('type', 'rapport')->first();
                                @endphp

                                @if($rapport)
                                    {{-- Le chemin en base contient déjà 'Seminaires_Rapport/nom.pdf' --}}
                                    <a href="{{ asset('seminaires_rapport/' . $rapport->fichier_path) }}" target="_blank" class="text-decoration-none">
                                        <div class="p-1 rounded shadow-sm d-inline-block" style="background-color: #fff1f2; border: 1px solid #fecaca;">
                                            <i class="fas fa-file-pdf text-danger fs-4" title="Cliquez pour ouvrir le rapport final"></i>
                                        </div>
                                        <small class="d-block text-danger fw-bold mt-1" style="font-size: 0.6rem;">OUVRIR RAPPORT</small>
                                    </a>
                                @endif
                            @else
                                <div class="opacity-50">
                                    <i class="fas fa-file-invoice text-muted fs-4"></i>
                                    <small class="d-block text-muted fw-bold mt-1" style="font-size: 0.6rem;">AUCUN RAPPORT</small>
                                </div>
                            @endif
                        </td>


                        <td>
                            <a href="{{ route('seminaires.show', $s->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Détails</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
