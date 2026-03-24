@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
        <!-- En-tête de page : Titre centré et Bouton à droite sans chevauchement -->
    <div class="row align-items-center mb-4">
        <!-- Colonne GAUCHE : Bouton Fermer (Visible par tous) -->
        <div class="col-md-3 text-start mt-3 mt-md-0">
            <a href="{{ url('/home') }}" class="btn btn-outline-secondary btn-sm shadow-sm fw-bold"
            onclick="return confirm('Voulez-vous vraiment quitter ? Les données non enregistrées seront perdues.')">
                <i class="fas fa-arrow-left fa-sm me-1"></i> Retour à l'accueil
            </a>
        </div>

        <!-- Colonne CENTRALE : Titre -->
        <div class="col-md-6 text-center">
            <h1 class="h4 h3-md mb-0 text-gray-800 fw-bold">
                <i class="fas fa-calendar-check text-primary me-2"></i>Demande de Congés & Permissions
            </h1>
        </div>

        <!-- Colonne DROITE : Retour à la liste (Seulement Admin/Superviseur/DRH) -->
        <div class="col-md-3 text-end mt-3 mt-md-0">
            @hasanyrole('admin|Superviseur|drh|DRH')
                <a href="{{ route('absences.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm fw-bold">
                    <i class="fas fa-arrow-left fa-sm me-1"></i> Retour à la liste
                </a>
            @endhasanyrole
        </div>
    </div>



    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header avec dégradé et Bouton Fermer intégré -->
                    <div class="card-header bg-gradient-primary py-3 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-white text-uppercase tracking-wide">
                            <i class="fas fa-edit me-2"></i>Nouveau Formulaire d'Absence
                        </h6>

                        <!-- Bouton Fermer blanc et discret pour le dégradé -->
                        <a href="{{ url('/home') }}" class="btn btn-sm btn-light fw-bold shadow-sm px-3 text-primary"
                        onclick="return confirm('Voulez-vous vraiment quitter ? Les données non enregistrées seront perdues.')">
                            <i class="fas fa-times me-1"></i> FERMER
                        </a>
                    </div>

                <div class="card-body p-5 bg-white">
                    <!-- 1. PLACER LE CODE ICI (Messages d'erreur de session) -->
                    <!-- ZONE POUR LES ERREURS DÉTECTÉES EN TEMPS RÉEL (JS) -->
                        <div id="dynamicError"></div>
                        
                    <form id="absenceForm" action="{{ route('absences.monstore') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <!-- Bloc Agent : INFO (Bleu) -->
                        <!-- Bloc Agent : INFO (Bleu) -->
                        <div class="mb-5 p-3 rounded-4 bg-light border-start border-5 border-info shadow-sm">
                            <label class="form-label fw-bold small text-info text-uppercase mb-2">Agent Demandeur</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    @if(auth()->user()->agent && auth()->user()->agent->photo)
                                        <!-- Affichage de la photo de l'agent -->

                                        <img class="img-profile rounded-circle shadow object-fit-cover"
                                            src="{{ asset('agents_photos/' . auth()->user()->agent->photo) }}?v={{ time() }}"
                                            style="width: 128px; height: 128px; border: 3px solid #4e73df;">
                                                @else
                                        <!-- Icône par défaut si pas de photo -->
                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center shadow border border-2 border-white"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-user-tie fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <div class="fw-black text-dark fs-5" style="letter-spacing: -0.5px;">
                                        {{ auth()->user()->agent->first_name ?? '' }} {{ strtoupper(auth()->user()->agent->last_name ?? auth()->user()->name) }}
                                    </div>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-white text-info border border-info-subtle shadow-sm">
                                            <i class="fas fa-id-card me-1"></i>Matricule : {{ auth()->user()->agent->matricule ?? 'N/A' }}
                                        </span>
                                        <span class="badge bg-info text-white shadow-sm">
                                            {{ auth()->user()->agent->fonction ?? 'Agent' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row g-4">
                            <!-- Bloc Nature : INDIGO -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark fs-6"><i class="fas fa-tag text-indigo me-1"></i> Nature de l'absence <span class="text-danger">*</span></label>
                                <select name="type_absence_id" class="form-select form-select-lg border-2 border-indigo fw-bold text-indigo shadow-sm" style="background-color: #f5f3ff;" required>
                                    <option value="" selected disabled>— Sélectionner le motif —</option>
                                    @foreach($typeAbsences as $type)
                                        <option value="{{ $type->id }}" class="fw-bold">
                                            {{ strtoupper($type->nom_type ?? 'Motif inconnu') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_absence_id') <div class="text-danger small fw-bold mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Bloc Dates : WARNING / ORANGE -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-day text-warning me-1"></i> Date de début <span class="text-danger">*</span></label>
                                <input type="date" name="date_debut" class="form-control form-control-lg border-2 border-warning shadow-sm fw-bold"
                                       style="background-color: #fffbeb;" value="{{ old('date_debut') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-check text-warning me-1"></i> Date de fin <span class="text-danger">*</span></label>
                                <input type="date" name="date_fin" class="form-control form-control-lg border-2 border-warning shadow-sm fw-bold"
                                       style="background-color: #fffbeb;" value="{{ old('date_fin') }}" required>
                            </div>

                            <!-- Bloc Fichier : SUCCESS / VERT -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-paperclip text-success me-1"></i> Pièce justificative
                                    <small class="text-muted">(Tout type de document accepté)</small>
                                </label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-success text-white border-success"><i class="fas fa-upload"></i></span>
                                    <input type="file" name="document_justificatif"
                                        class="form-control form-control-lg border-2 border-success @error('document_justificatif') is-invalid @enderror">
                                </div>

                                {{-- Message d'erreur spécifique au fichier --}}
                                @error('document_justificatif')
                                    <div class="text-danger fw-bold mt-1 small">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text text-success fw-bold" style="font-size: 0.75rem;">
                                    Format libre. Taille maximale autorisée : <span class="text-danger">8 Mo</span>.
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 border-2">

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-3">

                            <button type="button" onclick="validerEtEnregistrer()" class="btn btn-primary btn-lg fw-black shadow-lg py-3 text-uppercase w-100">
                                <i class="fas fa-file-pdf me-2"></i> ENREGISTRER & GÉNÉRER LE PDF
                            </button>


                            <button type="reset" class="btn btn-light btn-sm text-muted fw-bold">
                                <i class="fas fa-undo me-1"></i> Effacer les saisies
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>




<style>
    /* --- Vos styles existants (Interface Web) --- */
    .border-indigo { border-color: #6610f2 !important; }
    .text-indigo { color: #6610f2 !important; }
    .bg-indigo-subtle { background-color: #e7d1ff !important; }
    .fw-black { font-weight: 900; }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }

    /* --- NOUVEAU : Masquer le document administratif sur l'écran --- */
    #absenceDocument {
        display: none !important;
    }

    /* --- Configuration Impression (Uniquement sur papier) --- */
    @media print {
        /* Tout masquer par défaut */
        body * { visibility: hidden; }

        /* Rendre visible UNIQUEMENT le document d'autorisation */
        #absenceDocument, #absenceDocument * {
            visibility: visible !important;
            display: block !important;
        }

        #absenceDocument {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0 !important;
            color: #000 !important;
            background-color: white !important;
        }

        /* Nettoyage pour le rendu papier */
        .card, .shadow-lg {
            box-shadow: none !important;
            border: none !important;
        }

        /* Paramètres de la page A4 */
        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        /* Forcer l'impression des bordures du tableau officiel */
        .table-bordered {
            border: 1px solid #000 !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
        }
    }
</style>


<script>
/**
 * 1. FONCTION DE VALIDATION ET D'ENREGISTREMENT
 */
async function validerEtEnregistrer() {
    const form = document.getElementById('absenceForm');
    const select = document.querySelector('select[name="type_absence_id"]');
    const debut = document.querySelector('input[name="date_debut"]');
    const fin = document.querySelector('input[name="date_fin"]');
    const dynamicError = document.getElementById('dynamicError');

    if (dynamicError) dynamicError.innerHTML = '';

    if (!select || !select.value || !debut.value || !fin.value) {
        alert("⚠️ Veuillez remplir le motif et les dates avant de continuer.");
        return;
    }

    try {
        const response = await fetch("{{ route('absences.checkOverlap') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                date_debut: debut.value,
                date_fin: fin.value
            })
        });

        const data = await response.json();

        if (data.conflict) {
            if (dynamicError) {
                dynamicError.innerHTML = `
                    <div class="alert alert-danger border-start border-4 border-danger shadow-sm mb-4 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i> ${data.message}
                    </div>
                `;
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
    } catch (error) {
        console.error("Erreur de vérification", error);
    }

    // Soumission du formulaire
    form.submit();
}

/**
 * 2. GESTION DU SUCCÈS ET TÉLÉCHARGEMENT DU PDF
 */
@if(session('success'))
    // Affichage du message de succès
    alert("{{ session('success') }}");

    @if(session('pdf_url'))
        // METHODE DU LIEN INVISIBLE : Évite le blocage popup
        const downloadLink = document.createElement("a");
        downloadLink.href = "{{ session('pdf_url') }}";
        downloadLink.target = "_self"; // On reste sur la page actuelle pour le téléchargement
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    @endif
@endif

@if(session('error'))
    window.scrollTo({ top: 0, behavior: 'smooth' });
@endif
</script>





@endsection
