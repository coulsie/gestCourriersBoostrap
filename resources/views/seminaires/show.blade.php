@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc;">

    <!-- Header avec Actions -->
    <!-- Header avec Actions (Masqué à l'impression grâce à no-print) -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 d-flex align-items-center gap-2">
                    {{-- Bouton Poussoir Séminaires --}}
                    <li class="breadcrumb-item d-flex align-items-center m-0">
                        <a href="{{ route('seminaires.index') }}" class="btn-poussoir-rouge">
                            <i class="fas fa-graduation-cap me-1"></i> Retour au Séminaires
                        </a>
                    </li>

                    {{-- Séparateur et Titre Actuel --}}
                    <li class="breadcrumb-item active text-primary fw-bold fs-6 d-flex align-items-center ms-1" aria-current="page">
                        <span class="text-muted fw-normal me-2">/&nbsp;</span> Détails & Émargement
                    </li>


                </ol>
            </nav>
            <h1 class="h3 mb-0 text-dark fw-bolder">🎓 {{ $seminaire->titre }}</h1>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('seminaires.qrcode', $seminaire->id) }}" target="_blank" class="btn btn-dark shadow-sm rounded-pill px-4 fw-bold">
                <i class="fas fa-qrcode me-2"></i> QR Code Global
            </a>
            <a href="{{ route('seminaires.qrcodeJournalier', $seminaire->id) }}" target="_blank" class="btn btn-info shadow-sm rounded-pill px-4 fw-bold text-white">
                <i class="fas fa-qrcode me-2"></i> QR Quotidien
            </a>
            <a href="{{ route('seminaires.emargement', $seminaire->id) }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
                <i class="fas fa-clipboard-check me-2"></i> Émargement Quotidien
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary shadow-sm rounded-pill px-3">
                <i class="fas fa-print me-1"></i> Imprimer
            </button>
            <a href="{{ route('seminaires.edit', $seminaire->id) }}" class="btn btn-warning shadow-sm rounded-pill px-4 text-white fw-bold">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>


    <!-- Titre d'impression (Visible uniquement sur papier) -->
    <div class="d-none d-print-block text-center mb-4">
        <h2 class="fw-bold text-uppercase">Liste d'Émargement</h2>
        <h4 class="text-primary">{{ $seminaire->titre }}</h4>
        <hr>
    </div>

    <div class="row">
        <!-- Colonne Gauche : Infos & Émargement -->
        <div class="col-lg-8">

            <!-- Carte Info Principale -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row text-center mb-4">
                        <div class="col-md-4 border-end">
                            <p class="text-muted small text-uppercase fw-bold mb-1">Date & Jour</p>
                            <h5 class="fw-bold text-primary">
                                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($seminaire->date_debut)->translatedFormat('l d F Y') }}
                            </h5>
                        </div>
                        <div class="col-md-4 border-end">
                            <p class="text-muted small text-uppercase fw-bold mb-1">Heure de début</p>
                            <h5 class="fw-bold text-danger">
                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($seminaire->date_debut)->format('H:i') }}
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted small text-uppercase fw-bold mb-1">Lieu / Salle</p>
                            <h5 class="fw-bold text-dark">
                                <i class="fas fa-map-marker-alt me-2 text-info"></i>{{ $seminaire->lieu }}
                            </h5>
                        </div>
                    </div>

                    <div class="mt-4 no-print">
                        <h6 class="fw-black text-uppercase text-secondary mb-3" style="letter-spacing: 1px;">
                            <i class="fas fa-align-left me-2 text-primary"></i>Description & Objectifs
                        </h6>
                        <div class="p-3 rounded-4 bg-light" style="border-left: 5px solid #6366f1;">
                            {!! nl2br(e($seminaire->description ?? 'Aucune description spécifiée.')) !!}
                        </div>
                    </div>
                </div>
            </div>

       <!-- TABLEAU D'ÉMARGEMENT MODIFIÉ -->
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-check-double me-2 text-success"></i>Pointage des Présences</h6>
                    <span class="badge rounded-pill bg-soft-primary text-primary px-3 py-2 no-print">
                        {{ $seminaire->participations->count() }} Inscrits
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #f8fafc;">
                            <tr class="text-uppercase small fw-bold text-muted">
                                <th class="ps-4">Participant</th>
                                <th>Structure</th>
                                <th class="text-center no-print">Action Rapide</th>
                                {{-- Retrait du no-print pour que le titre de la colonne s'imprime --}}
                                <th class="pe-4" style="min-width: 250px;">Date & Heure d'arrivée</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($seminaire->participations as $p)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-dark mb-0">{{ $p->nom_complet }}</div>
                                    @if($p->agent) <small class="text-muted text-uppercase" style="font-size: 0.65rem;">Matricule: {{ $p->agent->matricule }}</small> @endif
                                </td>
                                <td>
                                    <span class="badge px-2 py-1 rounded-pill {{ $p->agent_id ? 'bg-soft-info text-info' : 'bg-soft-warning text-warning' }}" style="font-size: 0.7rem;">
                                        {{ $p->structure }}
                                    </span>
                                </td>

                                <!-- ACTION DE POINTAGE (Caché à l'impression) -->
                                <td class="text-center no-print" style="width: 150px;">
                                    @if($seminaire->statut == 'termine' || $seminaire->statut == 'annule')
                                        {{-- Bouton figé et désactivé si terminé ou annulé --}}
                                        <button type="button" class="btn btn-sm {{ $p->est_present ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3 fw-bold opacity-75 w-100" disabled>
                                            <i class="fas {{ $p->est_present ? 'fa-check-circle' : 'fa-lock' }} me-1"></i>
                                            {{ $p->est_present ? 'Présent' : 'Clos' }}
                                        </button>
                                    @else
                                        {{-- Formulaire actif si le séminaire est en cours --}}
                                        <form action="{{ route('seminaires.pointer', [$seminaire->id, $p->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $p->est_present ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-3 fw-bold shadow-sm w-100">
                                                <i class="fas {{ $p->est_present ? 'fa-check-circle' : 'fa-fingerprint' }} me-1"></i>
                                                {{ $p->est_present ? 'Présent' : 'Pointer' }}
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Affichage de l'heure sous le bouton si déjà pointé --}}
                                    @if($p->heure_pointage)
                                        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                                            <i class="far fa-clock me-1"></i>{{ $p->heure_pointage->format('H:i') }}
                                        </small>
                                    @endif
                                </td>

                                <!-- SAISIE MANUELLE ET RENDER D'IMPRESSION (La classe no-print générale est retirée d'ici) -->
                                <td class="pe-3" style="min-width: 250px;">

                                    {{-- 1. AFFICHAGE TEXTUEL : Visible UNIQUEMENT à l'impression --}}
                                    <div class="d-none d-print-block fw-bold text-dark" style="font-size: 0.85rem;">
                                        @if($p->heure_pointage)
                                            {{ $p->heure_pointage->format('d/m/Y à H:i') }}
                                        @else
                                            <span class="text-muted fw-normal">Absent</span>
                                        @endif
                                    </div>

                                    {{-- 2. FORMULAIRE : Caché automatiquement à l'impression grâce à no-print --}}
                                    <form action="{{ route('seminaires.update-pointage', [$seminaire->id, $p->id]) }}" method="POST" class="d-flex align-items-center gap-2 no-print">
                                        @csrf
                                        <input type="hidden" name="est_present" value="1">

                                        @php
                                            $estBloque = ($seminaire->statut == 'termine' || $seminaire->statut == 'annule');
                                        @endphp

                                        <!-- Groupe Date/Heure -->
                                        <div class="flex-shrink-0">
                                            <div class="d-flex bg-light rounded-3 border shadow-sm p-1" style="{{ $estBloque ? 'background-color: #e9ecef !important;' : 'background-color: #fff !important;' }}">
                                                <input type="date" name="date_presence" value="{{ $p->heure_pointage ? $p->heure_pointage->format('Y-m-d') : date('Y-m-d') }}"
                                                    class="form-control form-control-sm border-0 bg-transparent p-0 px-1" style="font-size: 0.75rem; width: 105px;" {{ $estBloque ? 'disabled' : '' }}>
                                                <div class="vr mx-1"></div>
                                                <input type="time" name="heure_presence" value="{{ $p->heure_pointage ? $p->heure_pointage->format('H:i') : date('H:i') }}"
                                                    class="form-control form-control-sm border-0 bg-transparent p-0 px-1" style="font-size: 0.75rem; width: 65px;" {{ $estBloque ? 'disabled' : '' }}>
                                            </div>
                                        </div>

                                        <!-- Groupe Contacts -->
                                        <div class="flex-grow-1">
                                            <div class="input-group input-group-sm mb-1">
                                                <span class="input-group-text bg-light border-0" style="font-size: 0.6rem;"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" placeholder="Email" value="{{ $p->email }}" class="form-control border-light" style="font-size: 0.7rem;" {{ $estBloque ? 'readonly' : '' }}>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light border-0" style="font-size: 0.6rem;"><i class="fas fa-phone"></i></span>
                                                <input type="text" name="telephone" placeholder="Téléphone" value="{{ $p->telephone }}" class="form-control border-light" style="font-size: 0.7rem;" {{ $estBloque ? 'readonly' : '' }}>
                                            </div>
                                        </div>

                                        <!-- Validation -->
                                        @if(!$estBloque)
                                            <button type="submit" class="btn btn-primary btn-sm rounded-3 shadow-sm px-2" title="Enregistrer les infos complémentaires">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm rounded-3 px-2" title="Modification impossible" disabled>
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </form>
                                </td>

                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">Aucun participant inscrit.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>



        </div>

        <!-- Colonne Droite : Inscriptions & Rapports -->
        <div class="col-lg-4 no-print">

            <!-- Inscription Massive (CORRIGÉ) -->
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden text-start">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold"><i class="fas fa-user-plus me-2"></i>Inscrire des Agents</h6>
                    {{-- On cache le bouton "Tout cocher" si le séminaire est terminé ou annulé --}}
                    @if($seminaire->statut !== 'termine' && $seminaire->statut !== 'annule')
                        <button type="button" class="btn btn-sm btn-light py-0 px-2 fw-bold" onclick="toggleAll()" style="font-size: 0.7rem;">Tout cocher</button>
                    @endif
                </div>
                <div class="card-body">
                    {{-- Condition stricte basée sur vos statuts --}}
                    @if($seminaire->statut == 'termine' || $seminaire->statut == 'annule')
                        <!-- Message d'alerte à la place du formulaire -->
                        <div class="alert alert-danger border-0 rounded-3 text-center p-4 m-0 shadow-sm" role="alert">
                            <i class="fas fa-exclamation-triangle fs-3 d-block mb-2"></i>
                            <span class="fw-bold fs-5">Séminaire achevé</span>
                            <p class="small text-muted mb-0 mt-1">Il n'est plus possible d'inscrire de nouveaux agents à cet événement.</p>
                        </div>
                    @else
                        <!-- Formulaire normal si actif -->
                        <form action="{{ route('seminaires.add_multiple_agents', $seminaire->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <!-- Conteneur avec défilement propre -->
                                <div id="agentList" style="max-height: 400px; overflow-y: auto; border: 1px solid #eef2f7; border-radius: 12px;">
                                    @foreach($agents as $agent)
                                    <!-- Utilisation de label comme conteneur pour que toute la ligne soit cliquable et liée -->
                                    <label class="d-flex align-items-center p-3 border-bottom w-100 m-0" for="ag-{{ $agent->id }}" style="cursor: pointer; transition: background 0.2s;">
                                        <!-- Case à cocher (fermement ancrée à gauche) -->
                                        <div class="form-check m-0">
                                            <input class="form-check-input border-primary agent-checkbox"
                                                type="checkbox"
                                                name="agent_ids[]"
                                                value="{{ $agent->id }}"
                                                id="ag-{{ $agent->id }}"
                                                style="width: 1.3rem; height: 1.3rem; margin-top: 0;">
                                        </div>

                                        <!-- Infos Agent (liées à la case) -->
                                        <div class="ms-3">
                                            <span class="small text-dark fw-bold d-block text-uppercase" style="line-height: 1.2;">
                                                {{ $agent->last_name }} {{ $agent->first_name }}
                                            </span>
                                            <span class="fw-bold text-primary" style="font-size: 0.75rem;">
                                                <i class="fas fa-building me-1"></i>{{ $agent->service->name ?? '---' }}
                                            </span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2">
                                <i class="fas fa-check-circle me-1"></i> Valider l'inscription
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Inscription Externe -->
            {{-- On affiche le bloc d'inscription externe uniquement si le séminaire n'est ni terminé ni annulé --}}
            @if($seminaire->statut !== 'termine' && $seminaire->statut !== 'annule')
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-external-link-alt me-2 text-warning"></i>Ajouter un Externe</h6>
                        <form action="{{ route('seminaires.add_externe', $seminaire->id) }}" method="POST">
                            @csrf
                            <input type="text" name="nom_externe" class="form-control mb-2 rounded-3 bg-light border-0" placeholder="Nom complet" required>
                            <input type="text" name="organisme_externe" class="form-control mb-3 rounded-3 bg-light border-0" placeholder="Organisme / Structure" required>
                            <button type="submit" class="btn btn-warning w-100 rounded-pill text-white fw-bold">Inscrire l'invité</button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Archivage Rapport -->
           {{-- Ce bloc reste visible en tout temps pour permettre de charger ou consulter le rapport de clôture --}}
            {{-- Ce bloc reste visible en tout temps pour permettre de charger ou consulter le rapport de clôture --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-4">
        <h6 class="fw-bold text-dark mb-3">
            <i class="fas fa-file-pdf me-2 text-danger"></i>Rapport Final
        </h6>

        {{-- Récupération du document de type 'rapport' basé sur votre table seminaire_documents --}}
        @php
            $rapport = $seminaire->documents->where('type', 'rapport')->first();
        @endphp

        @if($rapport)
            <!-- Si un rapport existe : Mode Consultation / Affichage -->
            <div class="bg-light p-3 rounded-3 mb-3 border text-center">
                @php
                    // Récupération de l'extension du fichier en minuscules (ex: pdf, docx, png)
                    $extension = strtolower(pathinfo($rapport->fichier_path, PATHINFO_EXTENSION));
                @endphp

                {{-- Icône dynamique et couleur selon le type de fichier --}}
                @if($extension === 'pdf')
                    <i class="fas fa-file-pdf fa-3x text-danger mb-2" title="Document PDF"></i>
                @elseif(in_array($extension, ['doc', 'docx']))
                    <i class="fas fa-file-word fa-3x text-primary mb-2" title="Document Word"></i>
                @elseif(in_array($extension, ['xls', 'xlsx']))
                    <i class="fas fa-file-excel fa-3x text-success mb-2" title="Fichier Excel"></i>
                @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <i class="fas fa-file-image fa-3x text-info mb-2" title="Image / Photo"></i>
                @else
                    <i class="fas fa-file-alt fa-3x text-secondary mb-2" title="Fichier"></i>
                @endif

                <p class="small fw-bold text-dark mb-1">{{ $rapport->nom_document }}</p>
                <span class="badge bg-danger text-white fw-bold rounded-pill mb-2">Archivé avec succès</span>
            </div>

            <!-- Bouton pour ouvrir / consulter le fichier directement depuis le dossier public/seminaires_rapport -->
            <a href="{{ asset('seminaires_rapport/' . $rapport->fichier_path) }}" target="_blank" class="btn btn-primary w-100 rounded-pill fw-bold mb-2">
                <i class="fas fa-external-link-alt me-2"></i>Ouvrir / Consulter le Rapport
            </a>

            <hr class="my-3 text-muted">
            <p class="text-center text-muted small mb-0">Un rapport est déjà présent. Pour le remplacer, supprimez-le ou téléversez-en un nouveau si votre logique le permet.</p>
        @else
            <!-- Formulaire d'upload si aucun rapport n'est trouvé -->
            <form action="{{ route('seminaires.documents.store', $seminaire->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="rapport">

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Document (PDF, Word, Image)</label>
                    <input type="file" name="fichier" class="form-control mb-2 border-0 bg-light rounded-3" required>
                </div>

                <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold">
                    <i class="fas fa-file-archive me-2"></i>Archiver le Rapport
                </button>
            </form>
        @endif
    </div>
</div>




        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Moteur de recherche pour la liste des agents à droite
    const searchInput = document.getElementById('searchAgent');
    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('.agent-row');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
});
</script>
    <style>
    /* Style personnalisé pour l'effet bouton poussoir 3D */
    .btn-poussoir-rouge {
        display: inline-block;
        padding: 6px 16px;
        font-size: 0.85rem;
        font-weight: bold;
        color: #ffffff !important;
        text-decoration: none !important;
        background-color: #dc3545; /* Rouge Bootstrap */
        border-radius: 8px;
        border: none;
        /* Ombre basse pour créer le relief 3D */
        box-shadow: 0 4px 0 #b02a37, 0 5px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.1s ease;
    }

    /* Effet au survol (léger éclaircissement) */
    .btn-poussoir-rouge:hover {
        background-color: #e44252;
    }

    /* L'effet poussoir au clic (Active) */
    .btn-poussoir-rouge:active {
        box-shadow: 0 1px 0 #b02a37, 0 1px 3px rgba(0, 0, 0, 0.2);
        transform: translateY(3px); /* Le bouton s'enfonce de 3px */
    }

    /* Nettoyage du séparateur par défaut de Bootstrap si nécessaire */
    .breadcrumb-item + .breadcrumb-item::before {
        display: none !important;
    }
    </style>

<style>
    .transition-hover:hover {
        background-color: #f0f7ff; /* Léger bleu au survol */
        border-radius: 8px;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-bolder { font-weight: 800 !important; }
    .bg-soft-primary { background: #e0e7ff; }
    .bg-soft-info { background: #e0f2fe; }
    .bg-soft-warning { background: #fef3c7; }
    .rounded-4 { border-radius: 1rem !important; }
    .italic { font-style: italic; }

    @media print {
        .no-print { display: none !important; }
        .container-fluid { padding: 0 !important; background: white !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        .table { width: 100% !important; }
        .table th { background: #f8fafc !important; color: black !important; }
    }
</style>
<style>
    /* Effet de survol pour bien voir quelle ligne on coche */
    #agentList label:hover {
        background-color: #f8faff;
    }
</style>

<script>
function toggleAll() {
    const checkboxes = document.querySelectorAll('.agent-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}

</script>
@endsection
