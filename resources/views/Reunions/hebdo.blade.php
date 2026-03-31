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
                <table class="table table-hover align-middle mb-0">
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
                                        <a href="{{ asset('Rapport_Reunions/' . $reunion->presence_file) }}" target="_blank" class="btn btn-sm btn-light border shadow-sm text-primary" title="Liste de présence">
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                    @endif
                                    @if($reunion->report_file)
                                        <a href="{{ asset('Rapport_Reunions/' . $reunion->report_file) }}" target="_blank" class="btn btn-sm btn-light border shadow-sm text-success" title="Compte-rendu">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>


                            {{-- 5. ACTIONS --}}
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm rounded-pill border bg-white overflow-hidden">
                                    <a href="{{ route('reunions.show', $reunion->id) }}" class="btn btn-sm text-primary px-2" title="Voir"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('reunions.edit', $reunion->id) }}" class="btn btn-sm text-warning px-2" title="Modifier/Clôturer"><i class="fas fa-magic"></i></a>
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
<script src="https://jquery.com"></script>
<script src="https://jsdelivr.net"></script>
<!-- Fichiers réels indispensables -->


<script>
$(document).ready(function () {
    console.log("Système prêt.");

    // GESTION DU MODAL
    var modalEl = document.getElementById('modalAutresReunions');
    if (modalEl) {
        var myModal = new bootstrap.Modal(modalEl);
        $('[data-bs-target="#modalAutresReunions"]').on('click', function(e) {
            e.preventDefault();
            myModal.show();
        });
    }
});

// FONCTION DE PARTAGE DU TABLEAU
function shareProgram() {
    let message = "*🗓️ PROGRAMME DES RÉUNIONS*\n\n";
    const rows = document.querySelectorAll('table tbody tr');

    if (rows.length === 0) {
        alert("Aucune réunion à partager.");
        return;
    }

    rows.forEach((row) => {
        // On vérifie que la ligne a assez de colonnes
        if (row.cells.length >= 3) {
            const date = row.cells[0]?.innerText.trim() || "";
            const objet = row.cells[1]?.innerText.trim() || "";
            const lieu = row.cells[2]?.innerText.trim() || "";

            if (objet && objet !== "" && objet !== "Aucune réunion trouvée") {
                message += `🔹 *${date}*\n📌 ${objet}\n📍 ${lieu}\n\n`;
            }
        }
    });

    message += "--------------------------\n_Généré via GestCourrier_";

    // URL OFFICIELLE : Correction de l'adresse WhatsApp
    const waUrl = "https://whatsapp.com" + encodeURIComponent(message);

    // Navigation directe pour éviter le blocage "about:blank"
    window.location.href = waUrl;
}
</script>

<script>
function copyProgramToClipboard() {
        // 1. Construction du texte à partir du tableau
        let text = "*🗓️ PROGRAMME HEBDOMADAIRE DES RÉUNIONS*\n";
        text += "------------------------------------------\n\n";

        const rows = document.querySelectorAll('table tbody tr');

        if (rows.length === 0) {
            alert("Aucune réunion à copier.");
            return;
        }

        rows.forEach((row) => {
            const date = row.cells[0]?.innerText.trim() || "";
            const objet = row.cells[1]?.innerText.trim() || "";
            const lieu = row.cells[2]?.innerText.trim() || "";

            if (objet && objet !== "" && objet !== "Aucune réunion") {
                text += `🔹 *${date}*\n📌 *OBJET :* ${objet}\n📍 *LIEU :* ${lieu}\n\n`;
            }
        });

        text += "------------------------------------------\n_Généré via GestCourrier_";

        // 2. Commande de copie au presse-papier (Inbloquable par about:blank)
        navigator.clipboard.writeText(text).then(() => {
            // Affichage de la petite bulle de confirmation
            const status = document.getElementById('copy-status');
            status.classList.remove('d-none');
            setTimeout(() => status.classList.add('d-none'), 4000);

            // Alerte classique en cas de doute
            alert("Le programme a été copié ! Allez sur WhatsApp et faites 'Coller' (Ctrl+V) dans la discussion du Directeur.");
        }).catch(err => {
            alert("Erreur lors de la copie. Essayez de sélectionner le texte manuellement.");
        });
    }
    function shareDirect(plateforme) {
        const urlCourante = window.location.href;
        const texteBase = "*🗓️ PROGRAMME HEBDOMADAIRE DES RÉUNIONS*\n\nVoici le planning de la semaine : " + urlCourante;

        let targetUrl = "";

        if (plateforme === 'WA') {
            // Lien de partage WhatsApp (Texte + Lien)
            targetUrl = "https://whatsapp.com" + encodeURIComponent(texteBase);
        } else {
            // Lien de partage Messenger/Facebook (URL brute pour l'aperçu)
            targetUrl = "https://facebook.com" + encodeURIComponent(urlCourante);
        }

        // Ouverture en mode "Prod" (Fonctionnera sans blocage en HTTPS)
        window.open(targetUrl, '_blank');
    }

</script>


<style>
    .fw-black { font-weight: 900; }
    .btn:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
    /* Correction pour l'affichage du modal sur mobile */
    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }
</style>

<style>
    @media print {
        /* Masquer tout sauf le contenu principal */
        .no-print,
        .sidebar,
        .navbar,
        .btn,
        .alert,
        .modal-trigger,
        footer {
            display: none !important;
        }

        /* Étendre le tableau sur toute la largeur de la page */
        .container-fluid, .card, .card-body {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Forcer l'affichage des couleurs des badges à l'impression */
        .badge {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #ccc !important;
        }

        h1 {
            font-size: 18pt !important;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            font-size: 10pt !important;
            border-collapse: collapse !important;
        }
    }
</style>
<style>
@media print {
    .no-print { display: none !important; }
}
</style>



@endsection
