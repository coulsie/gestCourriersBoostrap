@extends('layouts.app')

@section('content')
@php
    $fileUrl = $courrier->chemin_fichier ? asset('documents/courriers/' . $courrier->chemin_fichier) : null;
    $extension = $courrier->chemin_fichier ? pathinfo($courrier->chemin_fichier, PATHINFO_EXTENSION) : null;
@endphp

<div class="container-fluid py-4 px-5">
    <!-- Header -->
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
                <i class="bi bi-printer"></i> Imprimer
            </button>
            @if($courrier->signed_by)
                {{-- Ce bouton ouvre la modale mailModal définie plus bas --}}
                <button type="button" class="btn btn-primary shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#mailModal">
                    <i class="bi bi-envelope-at me-2"></i> Envoyer par Mail
                </button>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- COLONNE GAUCHE -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="p-3 {{ $courrier->statut == 'pending' ? 'bg-warning' : 'bg-success text-white' }} text-center fw-bold">
                    STATUT : {{ strtoupper($courrier->statut) }}
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Identifiants</h5>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Référence</label>
                        <span class="fw-bold h5 text-dark">{{ $courrier->reference }}</span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="text-muted small d-block">Type</label>
                            <span class="badge bg-primary-subtle text-primary p-2">{{ $courrier->type }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-danger fw-bold small">Expéditeur</h6>
                    <p class="mb-3"><strong>{{ $courrier->expediteur_nom }}</strong><br>{{ $courrier->expediteur_contact }}</p>
                    <h6 class="text-uppercase text-primary fw-bold small">Destinataire</h6>
                    <p class="mb-0"><strong>{{ $courrier->destinataire_nom }}</strong><br>{{ $courrier->destinataire_contact }}</p>
                </div>
            </div>



            <!-- Bloc Action Signature -->
            <!-- Bloc Action Signature -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-dark fw-bold small mb-3 text-start">Signature Numérique</h6>

                    @if($courrier->signed_by && $courrier->signataire)
                        {{-- CAS 1 : LE COURRIER EST DÉJÀ SIGNÉ --}}
                        <div class="p-3 rounded bg-white border border-primary shadow-sm">
                            <img src="{{ asset('signatures/' . $courrier->signataire->signature_path) }}" class="img-fluid mb-2" style="max-height: 80px; mix-blend-mode: multiply;">
                            <div class="small border-top pt-2">
                                <strong>{{ $courrier->signataire->name }}</strong><br>
                                <span class="text-muted">Signé le {{ \Carbon\Carbon::parse($courrier->signed_at)->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    @else
                        {{-- CAS 2 : LE COURRIER N'EST PAS ENCORE SIGNÉ --}}

                        {{-- ON VÉRIFIE SI L'UTILISATEUR A LE DROIT (PROPRE OU PAR INTÉRIM) --}}
                        @can('has-role', 'Directeur')
                            @if(auth()->user()->signature_path)
                                {{-- S'il a le droit et qu'il a configuré sa signature --}}
                                <form action="{{ route('courriers.sign', $courrier->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm" onclick="return confirm('Signer ce courrier en tant que Direction ?')">
                                        <i class="bi bi-pen me-2"></i> Signer maintenant
                                    </button>
                                </form>
                            @else
                                {{-- S'il a le droit mais n'a pas chargé son image de signature --}}
                                <div class="alert alert-warning small mb-0">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Droits de signature actifs, mais aucune signature configurée.
                                    <a href="{{ route('profile.signature') }}" class="btn btn-link btn-sm p-0 fw-bold">Configurer ici</a>
                                </div>
                            @endif
                        @else
                            {{-- CAS 3 : L'UTILISATEUR N'A PAS LE DROIT DE SIGNER --}}
                            <div class="p-3 bg-light rounded border text-muted small">
                                <i class="bi bi-lock-fill me-1"></i> Signature réservée à la Direction ou à l'intérimaire désigné.
                            </div>
                        @endcan

                    @endif
                </div>
            </div>

        </div>

        <!-- COLONNE DROITE -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold">Objet : {{ $courrier->objet }}</h5>
                    <hr>
                    <p class="text-muted" style="white-space: pre-line;">{{ $courrier->description ?: 'Aucune description.' }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Aperçu du document</h5>
                    @if($fileUrl)
                        <a href="{{ $fileUrl }}" download class="btn btn-sm btn-outline-primary">Télécharger</a>
                    @endif
                </div>
                <div class="card-body bg-light p-0">
                    <div style="height: 800px; overflow-y: auto; background: #525659; padding: 20px 0;">
                        <div class="bg-white mx-auto shadow-sm mb-4" style="width: 95%; max-width: 900px; min-height: 700px;">
                            @if(strtolower($extension) == 'pdf')
                                <iframe src="{{ $fileUrl }}#toolbar=0" width="100%" height="800px" style="border: none;"></iframe>
                            @else
                                <div class="text-center p-2"><img src="{{ $fileUrl }}" class="img-fluid"></div>
                            @endif
                        </div>

                        @if($courrier->signed_by && $courrier->signataire)
                        <div class="signature-page bg-white p-5 shadow-sm mx-auto border" style="width: 95%; max-width: 900px;">
                            <h6 class="text-uppercase fw-bold text-primary border-bottom pb-2 mb-4">Bordereau de Signature</h6>
                            <div class="row align-items-center">
                                <div class="col-md-7 text-start">
                                    <p><strong>Signataire :</strong> {{ $courrier->signataire->name }}</p>
                                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($courrier->signed_at)->format('d/m/Y à H:i') }}</p>
                                    <p><strong>Réf :</strong> {{ $courrier->reference }}</p>
                                </div>
                                <div class="col-md-5 text-center">
                                    <img src="{{ asset('signatures/' . $courrier->signataire->signature_path) }}" style="max-height: 100px; mix-blend-mode: multiply;">
                                    <div class="mt-2"><span class="badge bg-success-subtle text-success border border-success px-3 py-2 text-uppercase">Document Certifié</span></div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALE D'ENVOI MAIL (Placée à la fin pour éviter les conflits CSS) -->
<div class="modal fade" id="mailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('courriers.send-mail', $courrier->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-send me-2"></i>Envoyer par Mail</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Destinataire</label>
                        <input type="email" name="recipient_email" class="form-control" value="{{ $courrier->destinataire_contact }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Message (optionnel)</label>
                        <textarea name="custom_message" class="form-control" rows="4" placeholder="Veuillez trouver ci-joint..."></textarea>
                    </div>
                </div>
                <<div class="modal-footer bg-light">
                    {{-- Bouton Annuler avec ID unique --}}
                    <button type="button" class="btn btn-secondary" id="btnAnnulerMail">Annuler</button>

                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        Envoyer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- Script Bootstrap indispensable pour l'ouverture de la modale --}}


<script src="https://cdn.jsdelivr.net"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('mailModal');
    const form = modalEl.querySelector('form');

    // 1. Initialisation de la modale via Bootstrap
    const myModal = new bootstrap.Modal(modalEl);

    // 2. Gestion de l'ouverture (Bouton principal)
    document.querySelector('[data-bs-target="#mailModal"]').addEventListener('click', function (e) {
        e.preventDefault();
        myModal.show();
    });

    // 3. Gestion de la FERMETURE (Bouton Annuler et Croix)
    // On ne cible que les boutons qui ne sont PAS de type submit
    const closeBtns = modalEl.querySelectorAll('[data-bs-dismiss="modal"], #btnAnnulerMail, .btn-close');

    closeBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.type !== 'submit') {
                e.preventDefault();
                myModal.hide();
            }
        });
    });

    // 4. RÉINITIALISATION DU FORMULAIRE à la fermeture
    modalEl.addEventListener('hidden.bs.modal', function () {
        form.reset(); // Vide les champs (email et message)

        // Nettoyage forcé des résidus Bootstrap si nécessaire
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
    });
});
</script>

@endsection
