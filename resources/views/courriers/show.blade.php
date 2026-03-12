@extends('layouts.app')

@section('content')
@php
    // Définition globale des variables de fichier pour éviter l'erreur "Variable non définie"
    $fileUrl = $courrier->chemin_fichier ? asset('documents/courriers/' . $courrier->chemin_fichier) : null;
    $extension = $courrier->chemin_fichier ? pathinfo($courrier->chemin_fichier, PATHINFO_EXTENSION) : null;
@endphp

<div class="container-fluid py-4 px-5">
    <!-- Header avec Fil d'Ariane -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-envelope-paper shadow-sm p-2 rounded bg-white me-2"></i>Détails du Courrier</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('courriers.index') }}">Liste</a></li>
                    <li class="breadcrumb-item active">{{ $courrier->reference }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('courriers.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <button onclick="window.print()" class="btn btn-info text-white shadow-sm">
                <i class="bi bi-printer"></i> Imprimer la fiche
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- COLONNE GAUCHE : INFOS -->
        <div class="col-lg-4">
            <!-- Statut Card -->
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="p-3 {{ $courrier->statut == 'pending' ? 'bg-warning text-dark' : 'bg-success text-white' }} text-center fw-bold">
                        STATUT : {{ mb_convert_case($courrier->statut, MB_CASE_TITLE, "UTF-8") }}
                    </div>
                </div>
            </div>

            <!-- Main Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Identifiants</h5>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Référence interne</label>
                        <span class="fw-bold h5 text-dark">{{ $courrier->reference }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">N° Enregistrement</label>
                        <span class="badge bg-light text-dark border p-2 w-100 text-start">{{ $courrier->num_enregistrement ?? 'Non attribué' }}</span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="text-muted small d-block">Type</label>
                            <span class="badge bg-primary-subtle text-primary p-2">{{ $courrier->type }}</span>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Date</label>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($courrier->date_courrier)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacts Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-0">
                        <div class="col-12 mb-4">
                            <h6 class="text-uppercase text-danger fw-bold small"><i class="bi bi-person-up me-2"></i>Expéditeur</h6>
                            <div class="p-3 rounded bg-danger-subtle border-start border-danger border-4">
                                <strong class="d-block">{{ $courrier->expediteur_nom }}</strong>
                                <span class="text-muted small">{{ $courrier->expediteur_contact }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <h6 class="text-uppercase text-primary fw-bold small"><i class="bi bi-person-down me-2"></i>Destinataire</h6>
                            <div class="p-3 rounded bg-primary-subtle border-start border-primary border-4">
                                <strong class="d-block">{{ $courrier->destinataire_nom }}</strong>
                                <span class="text-muted small">{{ $courrier->destinataire_contact }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloc Action Signature -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-dark fw-bold small mb-3">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>Signature Numérique
                    </h6>

                    @if($courrier->signed_by && $courrier->signataire)
                        {{-- CAS : SIGNÉ - Affichage de la signature --}}
                        <div class="text-center p-3 rounded bg-white border border-primary shadow-sm">
                            @if($courrier->signataire->signature_path)
                                <img src="{{ asset('signatures/' . $courrier->signataire->signature_path) }}"
                                    class="img-fluid mb-2 d-block mx-auto"
                                    style="max-height: 100px; width: auto; mix-blend-mode: multiply;"
                                    alt="Signature de {{ $courrier->signataire->name }}">
                            @else
                                <div class="text-danger small mb-2"><i class="bi bi-exclamation-triangle"></i> Image introuvable</div>
                            @endif

                            <div class="border-top pt-2 mt-2">
                                <strong class="d-block text-dark small">{{ $courrier->signataire->name }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar-check me-1"></i>Signé le {{ \Carbon\Carbon::parse($courrier->signed_at)->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                        </div>
                     @else

                        {{-- CAS : NON SIGNÉ - Bouton d'action --}}
                        <div class="alert alert-light border text-center mb-0 p-3">
                            @if(auth()->user()->signature_path)
                                <p class="small text-muted mb-3">Prêt pour signature numérique</p>
                                <form action="{{ route('courriers.sign', $courrier->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm"
                                            onclick="return confirm('Confirmez-vous l\'apposition de votre signature sur ce courrier ?')">
                                        <i class="bi bi-pen me-2"></i> Signer maintenant
                                    </button>
                                </form>
                            @else
                                <p class="small text-danger mb-3 font-italic">Vous n'avez pas encore de signature configurée.</p>
                                <a href="{{ route('profile.signature') }}" class="btn btn-outline-danger btn-sm w-100 fw-bold">
                                    <i class="bi bi-gear-fill me-1"></i> Configurer ma signature
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- COLONNE DROITE : CONTENU ET FICHIER -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Objet : {{ $courrier->objet }}</h5>
                    <hr>
                    <p class="text-muted" style="white-space: pre-line;">
                        {{ $courrier->description ?: 'Aucune description fournie.' }}
                    </p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-pdf me-2"></i>Aperçu du document</h5>
                    @if($fileUrl)
                        <a href="{{ $fileUrl }}" download class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> Télécharger original
                        </a>
                    @endif
                </div>

                <div class="card-body bg-light p-0"> {{-- Padding 0 pour l'effet liseuse --}}
                    @if($courrier->chemin_fichier)
                        {{-- Conteneur défilant (Liseuse) --}}
                        <div class="document-viewer shadow-inner" style="height: 800px; overflow-y: auto; background: #525659; padding: 20px 0;">

                            {{-- 1. AFFICHAGE DU FICHIER --}}
                            <div class="bg-white mx-auto shadow-sm mb-4" style="width: 95%; max-width: 1000px; min-height: 700px;">
                                @if(strtolower($extension) == 'pdf')
                                    <iframe src="{{ $fileUrl }}#toolbar=0" width="100%" height="800px" style="border: none; display: block;"></iframe>
                                @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="text-center p-2">
                                        <img src="{{ $fileUrl }}" class="img-fluid" alt="Document">
                                    </div>
                                @endif
                            </div>

                            {{-- 2. LA PAGE DE SIGNATURE (S'affiche à la suite du document) --}}
                            @if($courrier->signed_by && $courrier->signataire)
                                <div class="signature-page bg-white p-5 shadow-sm mx-auto border" style="width: 95%; max-width: 1000px; min-height: 250px;">
                                    <div class="text-center mb-4">
                                        <h6 class="text-uppercase fw-bold text-primary border-bottom pb-2 d-inline-block px-5">
                                            Bordereau de Signature Numérique
                                        </h6>
                                    </div>

                                    <div class="row align-items-center mt-4">
                                        <div class="col-md-7 text-start ps-5">
                                            <div class="mb-3">
                                                <label class="text-muted small d-block">Signataire certifié :</label>
                                                <span class="fw-bold h5 text-dark">{{ $courrier->signataire->name }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted small d-block">Date et Heure de l'acte :</label>
                                                <span class="fw-semibold text-dark">
                                                    {{ \Carbon\Carbon::parse($courrier->signed_at)->format('d/m/Y à H:i:s') }}
                                                </span>
                                            </div>
                                            <div>
                                                <label class="text-muted small d-block">Référence du courrier :</label>
                                                <code class="text-primary fw-bold">{{ $courrier->reference }}</code>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center border-start">
                                            <label class="text-muted small d-block mb-2">Empreinte de signature</label>
                                            <img src="{{ asset('signatures/' . $courrier->signataire->signature_path) }}"
                                                style="max-height: 120px; width: auto; mix-blend-mode: multiply;"
                                                alt="Signature">
                                            <div class="mt-3">
                                                <span class="badge bg-success-subtle text-success border border-success px-3 py-2 text-uppercase">
                                                    <i class="bi bi-shield-check me-1"></i> Document Certifié
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <small class="text-muted" style="font-size: 0.65rem;">
                                            Ce document a été signé électroniquement conformément aux politiques de sécurité du système.
                                            L'intégrité de cette signature est garantie par l'horodatage système : ID-{{ $courrier->id }}
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5 bg-white">
                            <i class="bi bi-file-earmark-x h1 text-muted"></i>
                            <p class="text-muted mt-2">Aucune pièce jointe associée.</p>
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-white text-end small text-muted">
                    Dernière modification : {{ $courrier->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #e7f1ff; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
    @media print {
        .btn, .breadcrumb, .card-header button { display: none !important; }
    }
</style>

@endsection
