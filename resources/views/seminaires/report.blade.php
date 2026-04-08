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
                        <td class="text-center align-middle">
                            @if($s->rapports_count > 0)
                                @php
                                    $rapport = $s->documents->where('type', 'rapport')->first();
                                    $nomBrut = basename($rapport->fichier_path);
                                    $cheminFinal = $nomBrut;

                                    if (!file_exists(public_path('seminaires_rapport/' . $nomBrut))) {
                                        $nomSansPdf = str_replace('.pdf', '', $nomBrut);
                                        if (file_exists(public_path('seminaires_rapport/' . $nomSansPdf))) {
                                            $cheminFinal = $nomSansPdf;
                                        }
                                    }
                                @endphp

                                <a href="{{ asset('seminaires_rapport/' . $cheminFinal) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-danger border-2 shadow-sm d-inline-flex align-items-center gap-2 px-3 py-2"
                                style="border-radius: 8px;">

                                    <!-- Icône taille standard mais nette -->
                                    <i class="fas fa-file-pdf fs-5"></i>

                                    <!-- Texte horizontal pour gagner de la place en hauteur -->
                                    <span class="fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        Rapport
                                    </span>
                                </a>
                            @else
                                <span class="badge bg-light text-muted border py-2">
                                    <i class="fas fa-times-circle me-1"></i> Aucun
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <!-- Bouton Détails existant -->
                                <a href="{{ route('seminaires.show', $s->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Détails
                                </a>

                                <!-- NOUVEAU : Bouton QR CODE intégré -->
                                <a href="{{ route('seminaires.qrcode', $s->id) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-dark border-2 shadow-sm px-3"
                                style="border-radius: 8px;"
                                title="Générer QR Code pour émargement">
                                    <i class="fas fa-qrcode"></i>
                                    <span class="ms-1 small fw-bold">QR CODE</span>
                                </a>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    /* Petit effet de survol pour le côté moderne */
    .hover-zoom { transition: transform 0.2s ease; }
    .hover-zoom:hover { transform: scale(1.05); background-color: #dc3545; color: white !important; }
</style>

@endsection
