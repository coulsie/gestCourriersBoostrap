@extends('layouts.app')

@section('content')

<div class="container-fluid py-4" style="background-color: #f0f2f5;">

    {{-- Message d'information --}}
    <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center mb-4">
        <i class="fas fa-info-circle fa-lg me-3"></i>
        <div>
            <strong>Astuce :</strong> Les réunions terminées affichent désormais les icônes de téléchargement pour la liste de présence et le rapport.
        </div>
    </div>

   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark fw-bolder">🗓️ Programmation Hebdomadaire</h1>
        <div class="d-flex gap-2 flex-wrap">
            <!-- BOUTON WHATSAPP DIRECT (Prod) -->
            <button type="button" onclick="shareDirect('WA')" class="btn btn-success shadow-sm px-3 py-2 rounded-pill border-0 fw-bold no-print">
                <i class="fab fa-whatsapp me-1"></i> WhatsApp
            </button>

            <!-- BOUTON MESSENGER DIRECT (Prod) -->
            <button type="button" onclick="shareDirect('FB')" class="btn btn-primary shadow-sm px-3 py-2 rounded-pill border-0 fw-bold no-print">
                <i class="fab fa-facebook-messenger me-1"></i> Messenger
            </button>


          <!-- BOUTON COPIER POUR WHATSAPP (S'affiche en vert) -->
            <button type="button" onclick="copyProgramToClipboard()" class="btn btn-success shadow-sm px-4 py-2 rounded-pill border-0 fw-bold">
                <i class="fas fa-copy me-2"></i> Copier pour WhatsApp
            </button>

            <!-- VOS AUTRES BOUTONS -->
            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-dark shadow-sm px-3 py-2 rounded-pill border-0 fw-bold no-print">
                <i class="fas fa-print me-1 text-warning"></i> Imprimer
            </a>

            <button type="button" class="btn btn-outline-dark shadow-sm px-3 py-2 rounded-pill border-2 fw-bold bg-white no-print"
                    data-bs-toggle="modal" data-bs-target="#modalAutresReunions">
                <i class="fas fa-calendar-alt me-1 text-primary"></i> Hors-semaine
            </button>

            <a href="{{ route('reunions.create') }}" class="btn shadow-lg px-4 py-2 rounded-pill border-0 text-white fw-bold no-print" style="background: linear-gradient(45deg, #6366f1, #a855f7);">
                <i class="fas fa-plus-circle me-1"></i> Nouvelle Réunion
            </a>

                        <!-- Message de confirmation discret -->
            <div id="copy-status" class="badge bg-dark text-white p-2 mt-2 d-none" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
                ✅ Programme copié ! Collez-le (Ctrl+V) au Directeur.
            </div>
        </div>
    </div>




    {{-- Tableau de la semaine --}}
    <div class="card shadow-lg mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 bg-white border-0 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold" style="color: #6366f1;">
                <i class="fas fa-bolt me-2 text-warning"></i>Semaine du {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m') }} au {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0" id="tableauHebdo">
                    <thead style="background: #1e293b; color: #f8fafc;">
                        <tr class="text-uppercase small fw-bold">
                            <th class="ps-4 py-3">Jour & Heure</th>
                            <th>Objet & Lieu</th>
                            <th>Rôles Maîtres</th>
                            <th>Équipe / Documents</th>
                            <th class="text-center no-print pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reunions as $reunion)
                        <tr>
                            {{-- 1. DATE ET HEURE --}}
                            <td class="ps-4">
                                <span class="badge rounded-pill px-3 py-2 mb-1 shadow-sm" style="background-color: #22d3ee; color: #083344;">
                                    {{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F') }}
                                </span><br>
                                <span class="fw-bold fs-4" style="color: #f43f5e;">
                                    {{ \Carbon\Carbon::parse($reunion->date_heure)->format('H:i') }}
                                </span>
                            </td>

                            {{-- 2. OBJET, STATUT ET LIEU --}}
                            <td>
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                    <h6 class="fw-bold mb-0 text-dark">{{ $reunion->objet }}</h6>

                                    @if($reunion->status == 'terminee')
                                        <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #10b981; font-size: 0.75rem;">
                                            <i class="fas fa-check-circle me-1"></i>EXÉCUTÉE
                                        </span>
                                    @elseif($reunion->status == 'annulee')
                                        <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #4b5563; font-size: 0.75rem;">
                                            <i class="fas fa-times-circle me-1"></i>ANNULÉE
                                        </span>
                                    @elseif(\Carbon\Carbon::parse($reunion->date_heure)->isPast())
                                        <span class="badge shadow-sm text-white px-2 py-1 animate__animated animate__flash animate__infinite" style="background-color: #ef4444; font-size: 0.75rem;">
                                            <i class="fas fa-exclamation-triangle me-1"></i>À CLÔTURER
                                        </span>
                                    @else
                                        <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #3b82f6; font-size: 0.75rem;">
                                            <i class="fas fa-clock me-1"></i>PROGRAMMÉE
                                        </span>
                                    @endif
                                </div>

                                {{-- URL Google Maps DÉFINITIVEMENT CORRIGÉE --}}
                                <div class="mb-1 small">
                                    <a href="https://google.com{{ urlencode($reunion->lieu) }}"
                                        target="_blank" class="text-primary fw-bold text-decoration-none" title="Localiser sur Google Maps">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        {{ $reunion->lieu ?? 'Lieu non défini' }}
                                    </a>
                                </div>
                                <small class="text-muted d-block italic">{{ $reunion->ordre_du_jour ?? '---' }}</small>
                            </td>

                            {{-- 3. RÔLES MAÎTRES --}}
                            <td>
                                <div class="small">
                                    <div class="mb-1 text-nowrap">
                                        <i class="fas fa-microphone text-indigo me-1"></i>
                                        <strong>Animateur:</strong> {{ strtoupper($reunion->animateur->last_name) }} {{ $reunion->animateur->first_name }}
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="fas fa-pen-nib text-success me-1"></i>
                                        <strong>Rédacteur:</strong> {{ strtoupper($reunion->redacteur->last_name) }} {{ $reunion->redacteur->first_name }}
                                    </div>
                                </div>
                            </td>

                            {{-- 4. ÉQUIPE ET DOCUMENTS --}}
                            <td>
                                {{-- 1. Participants Internes (Blanc sur Vert Éclatant) --}}
                                <div class="mb-2">
                                    @foreach($reunion->participants as $participant)
                                        <span class="badge shadow-sm text-white mb-1 px-2 py-1"
                                            style="background-color: #10b981; font-size: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="fas fa-user-tie fa-xs me-1"></i>
                                            {{ strtoupper(substr($participant->last_name, 0, 1)) }}. {{ $participant->first_name }}
                                        </span>
                                    @endforeach
                                </div>

                                {{-- 2. Participants Externes (Affichage de tous les noms - Blanc sur Orange) --}}
                                @if($reunion->externes)
                                    @php
                                        $externes = is_string($reunion->externes) ? json_decode($reunion->externes, true) : $reunion->externes;
                                    @endphp
                                    @if(is_array($externes) && count($externes) > 0)
                                        <div class="border-top pt-2 mt-1 d-flex flex-wrap gap-1">
                                            @foreach($externes as $externe)
                                                <span class="badge shadow-sm text-white mb-1 px-2 py-1"
                                                    style="background-color: #f59e0b; font-size: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                                                    <i class="fas fa-external-link-alt fa-xs me-1"></i> {{ $externe }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif

                                {{-- 3. Fichiers joints (Archives) --}}
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    @if($reunion->presence_file)
                                        {{-- Bouton si le fichier existe --}}
                                        <a href="{{ asset('Rapport_Reunions/' . $reunion->presence_file) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary shadow-sm fw-bold px-3"
                                        title="Voir la liste de présence">
                                            <i class="fas fa-file-download me-1"></i> PRÉSENCE
                                        </a>
                                    @elseif($reunion->status == 'terminee')
                                        {{-- Badge discret si la réunion est finie mais sans fichier --}}
                                        <span class="badge bg-soft-warning text-warning border border-warning px-2 py-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-clock me-1"></i> EN ATTENTE LISTE DE PRESENCE
                                        </span>
                                    @else
                                        {{-- Optionnel : Texte si la réunion n'est pas encore terminée --}}
                                        <span class="text-muted small italic">Aucun document</span>
                                    @endif

                                    @if($reunion->report_file)
                                        {{-- Bouton si le compte-rendu existe --}}
                                        <a href="{{ asset('Rapport_Reunions/' . $reunion->report_file) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-success shadow-sm fw-bold px-3"
                                        title="Voir le compte-rendu">
                                            <i class="fas fa-file-pdf me-1"></i> COMPTE-RENDU
                                        </a>
                                    @elseif($reunion->status == 'terminee')
                                        {{-- Badge si la réunion est terminée mais le rapport manque --}}
                                        <span class="badge bg-soft-danger text-danger border border-danger px-2 py-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-exclamation-triangle me-1"></i> EN ATTENTE DU CR
                                        </span>
                                    @else
                                        {{-- État pour les réunions planifiées ou en cours --}}
                                        <span class="text-muted small fst-italic">  Aucun document</span>
                                    @endif

                                </div>
                            </td>


                            {{-- 5. ACTIONS --}}
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm rounded-pill border bg-white overflow-hidden">
                                    <a href="{{ route('reunions.show', $reunion->id) }}" class="btn btn-sm text-primary px-2" title="Voir"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('reunions.edit', $reunion->id) }}" class="btn btn-sm text-warning px-2" title="Traiter-Modifier/Clôturer">
                                        <i class="fas fa-check-double"></i>
                                    </a>
                                    <form action="{{ route('reunions.destroy', $reunion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer définitivement ?');">
                                     @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-danger px-2"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Aucune réunion programmée cette semaine.</td></tr>
                        @endforelse


                        <!-- À mettre avant la fin de votre </body> -->
                        <script src="https://jsdelivr.net"></script>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- STRUCTURE DU MODAL --}}
    <div class="modal fade" id="modalAutresReunions" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-history me-2 text-warning"></i> HORS-SEMAINE</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    {{-- Vérification de sécurité --}}
                    @if(isset($autresReunions) && $autresReunions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="small fw-bold text-uppercase">
                                        <th class="ps-4">Date</th>
                                        <th>Objet & Lieu</th>
                                        <th>Animateur</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($autresReunions as $r)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold">{{ \Carbon\Carbon::parse($r->date_heure)->format('d/m/Y') }}</span><br>
                                            <small class="text-danger fw-bold">{{ \Carbon\Carbon::parse($r->date_heure)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $r->objet }}</div>
                                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $r->lieu }}</small>
                                        </td>
                                        <td>
                                            <span class="small">{{ strtoupper($r->animateur->last_name ?? 'N/A') }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{-- Style blanc sur couleur vive pour le statut --}}
                                            @if($r->status == 'terminee')
                                                <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #10b981; font-size: 0.7rem;">EXÉCUTÉE</span>
                                            @else
                                                <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #3b82f6; font-size: 0.7rem;">PROGRAMMÉE</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                            <p class="text-muted fw-bold">Aucune réunion archivée ou hors-semaine.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light p-3">
                    {{-- On utilise data-bs-dismiss pour FERMER --}}

                    <button type="button" class="btn btn-secondary fw-bold shadow-sm" data-bs-dismiss="modal" data-dismiss="modal">FERMER</button>
                </div>

            </div>
        </div>
    </div>

</div>
{{-- Fermeture du container-fluid --}}

{{-- CHARGEMENT FORCÉ DES SCRIPTS --}}
{{-- CHARGEMENT DES BIBLIOTHÈQUES (LIENS COMPLETS) --}}
<!-- 1. JQUERY -->
<!-- 1. Importations réelles (INDISPENSABLE) -->
<!-- Liens CDN Corrects (Bootstrap 5 nécessite bootstrap.bundle.min.js) -->
<script src="https://jquery.com"></script>
<script src="https://jsdelivr.net"></script>

<script>
$(document).ready(function () {
    console.log("Système GestCourrier prêt.");

    // Initialisation manuelle des Modals si nécessaire
    const modalAutres = document.getElementById('modalAutresReunions');
    if (modalAutres) {
        const myModalAutres = new bootstrap.Modal(modalAutres);
        $('[data-bs-target="#modalAutresReunions"]').on('click', function(e) {
            e.preventDefault();
            myModalAutres.show();
        });
    }

    const modalMois = document.getElementById('modalReunionsMois');
    if (modalMois) {
        const myModalMois = new bootstrap.Modal(modalMois);
        $('[data-bs-target="#modalReunionsMois"]').on('click', function(e) {
            e.preventDefault();
            myModalMois.show();
        });
    }
});

/**
 * COPIER LE PROGRAMME DANS LE PRESSE-PAPIER
 * Cible uniquement le tableau de la semaine (id="tableauHebdo")
 */
function copyProgramToClipboard() {
    const table = document.getElementById('tableauHebdo');
    if (!table) {
        alert("Erreur : Le tableau principal est introuvable.");
        return;
    }

    const rows = table.querySelectorAll('tbody tr');
    let text = "*🗓️ PROGRAMME HEBDOMADAIRE DES RÉUNIONS*\n";
    text += "------------------------------------------\n\n";

    let hasData = false;

    rows.forEach((row) => {
        // Extraction des 3 premières colonnes (Date, Objet, Lieu)
        const date = row.cells[0]?.innerText.trim() || "";
        const objet = row.cells[1]?.innerText.trim() || "";
        const lieu = row.cells[2]?.innerText.trim() || "";

        // Filtrage des lignes vides ou messages "Aucune réunion"
        if (objet && !objet.toLowerCase().includes("aucune")) {
            hasData = true;
            // Nettoyage des espaces et retours à la ligne pour WhatsApp
            const cleanDate = date.replace(/\s+/g, " ");
            const cleanObjet = objet.replace(/\s+/g, " ");
            const cleanLieu = lieu.replace(/\s+/g, " ");

            text += `🔹 *${cleanDate}*\n📌 *OBJET :* ${cleanObjet}\n📍 *LIEU :* ${cleanLieu}\n\n`;
        }
    });

    if (!hasData) {
        alert("Aucune réunion valide à copier.");
        return;
    }

    text += "------------------------------------------\n_Généré via GestCourrier_";

    // API Clipboard
    navigator.clipboard.writeText(text).then(() => {
        const status = document.getElementById('copy-status');
        if (status) {
            status.classList.remove('d-none');
            setTimeout(() => status.classList.add('d-none'), 4000);
        }
        alert("✅ Programme de la semaine copié !\n\nVous pouvez maintenant le coller (Ctrl+V) sur WhatsApp pour envoie.");
    }).catch(err => {
        alert("Erreur lors de la copie. Vérifiez les permissions de votre navigateur.");
    });
}

/**
 * PARTAGE DIRECT SUR WHATSAPP
 */
function shareDirectWA() {
    const table = document.getElementById('tableauHebdo');
    if (!table) return;

    let message = "*🗓️ PROGRAMME DES RÉUNIONS*\n\n";
    const rows = table.querySelectorAll('tbody tr');

    rows.forEach((row) => {
        const date = row.cells[0]?.innerText.trim() || "";
        const objet = row.cells[1]?.innerText.trim() || "";
        if (objet && !objet.toLowerCase().includes("aucune")) {
            message += `🔹 *${date.replace(/\s+/g, " ")}*\n📌 ${objet.replace(/\s+/g, " ")}\n\n`;
        }
    });

    message += "_Généré via GestCourrier_";

    // Correction de l'URL API WhatsApp
    const waUrl = "https://whatsapp.com" + encodeURIComponent(message);
    window.open(waUrl, '_blank');
}
</script>

<style>
    .fw-black { font-weight: 900; }

    /* Effet au survol des boutons */
    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
    }

    /* Ajustement des z-index pour éviter que le menu cache le modal */
    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }

    /* Styles pour l'impression */
    @media print {
        .no-print, .btn, .sidebar, .navbar, .alert, footer, .modal {
            display: none !important;
        }

        body { background-color: white !important; }

        .container-fluid, .card, .card-body {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            border: none !important;
            box-shadow: none !important;
        }

        table {
            width: 100% !important;
            border: 1px solid #000 !important;
            font-size: 10pt !important;
        }

        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }

        .badge {
            color: black !important;
            border: 1px solid #000 !important;
            background: none !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>


@endsection
