@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7fe;">

    {{-- Bulle d'info Flashy --}}
    <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: white;">
        <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
            <i class="fas fa-mouse-pointer text-primary"></i>
        </div>
        <div>
            <span class="fw-bold">Astuce Multi-sélection :</span> Pour les participants, maintenez la touche <kbd class="bg-white text-dark shadow-sm fw-bold border-0">Ctrl</kbd> (ou <kbd class="bg-white text-dark shadow-sm fw-bold border-0">Cmd</kbd>) enfoncée pour choisir plusieurs agents rapidement.
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: linear-gradient(45deg, #1e293b, #334155);">
            <h6 class="m-0 font-weight-bold text-white fs-5">
                <i class="fas fa-calendar-plus me-2 text-info"></i> Programmer une nouvelle réunion
            </h6>
            <span class="badge bg-info text-dark rounded-pill px-3">Nouveau</span>
        </div>

        <div class="card-body p-4 bg-white">
            <form action="{{ route('reunions.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <!-- Objet -->
                    <div class="col-md-8">
                        <label class="form-label fw-black text-dark text-uppercase small">Objet de la réunion</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-primary"><i class="fas fa-tag"></i></span>
                            <input type="text" name="objet" class="form-control border-start-0 ps-0 bg-light fw-bold" placeholder="ex: Comité de Direction" required style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>
                    <!-- Date et Heure -->
                    <div class="col-md-4">
                        <label class="form-label fw-black text-danger text-uppercase small">Date et Heure</label>
                        <input type="datetime-local" name="date_heure" class="form-control border-0 shadow-sm text-danger fw-bold" required style="background-color: #fff1f2;">
                    </div>

                    <!-- Lieu de la réunion -->
                    <div class="col-12">
                        <label class="form-label fw-black text-dark text-uppercase small">Lieu de la réunion</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light border-end-0 text-secondary">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>

                            <input type="text" name="lieu" id="lieu_reunion"
                                class="form-control border-start-0 ps-0 bg-light fw-bold"
                                placeholder="ex: Bouaké Belleville..." required>

                            <!-- UTILISATION D'UN SPAN (INBLOQUABLE) AU LIEU D'UN BUTTON -->
                            <span class="btn btn-outline-danger bg-white border-start-0 d-flex align-items-center"
                                style="cursor: pointer !important; opacity: 1 !important; pointer-events: auto !important;"
                                onclick="openGoogleMaps()">
                                <i class="fab fa-google text-danger me-1"></i> Maps
                            </span>
                        </div>
                    </div>



                    <!-- Animateur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #eef2ff; border-left: 5px solid #6366f1;">
                            <label class="form-label fw-bold text-indigo"><i class="fas fa-microphone me-2"></i> Animateur</label>
                            <select name="animateur_id" class="form-select select2 shadow-none border-0" required>
                                <option value="">Sélectionner...</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Rédacteur -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-4" style="background-color: #ecfdf5; border-left: 5px solid #10b981;">
                            <label class="form-label fw-bold text-success"><i class="fas fa-pen-nib me-2"></i> Rédacteur du rapport</label>
                            <select name="redacteur_id" class="form-select select2 shadow-none border-0" required>
                                <option value="">Sélectionner...</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Participants Internes -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary"><i class="fas fa-users me-2"></i> Participants Internes</label>
                        <select name="participants[]" class="form-control select2 shadow-sm border-light" multiple="multiple" data-placeholder="Cliquer pour ajouter">
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ strtoupper($agent->last_name) }} {{ $agent->first_name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2 ps-1">
                            <span class="badge bg-soft-primary text-primary" style="background: #e0e7ff;">Maintenez Ctrl pour en choisir plusieurs</span>
                        </div>
                    </div>

                    <!-- Participants Externes Dynamiques -->
                    <div class="col-md-12">
                        <div class="p-3 rounded-4" style="background-color: #fffbeb; border-left: 5px solid #f59e0b;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-bold text-warning mb-0">
                                    <i class="fas fa-user-plus me-2"></i> PERSONNES EXTÉRIEURES (PARTENAIRES)
                                </label>
                                <button type="button" class="btn btn-warning btn-sm rounded-pill fw-bold text-white px-3" onclick="addExterneRow()">
                                    <i class="fas fa-plus me-1"></i> Ajouter un externe
                                </button>
                            </div>

                            <div id="externes-container">
                                <!-- Les lignes apparaîtront ici -->
                                <div class="row g-2 mb-2 externe-row">
                                    <div class="col-md-3">
                                        <input type="text" name="externes[0][nom_complet]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Nom complet" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="externes[0][origine]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Structure (ex: Ministère)">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="externes[0][fonction]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Fonction">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="externes[0][telephone]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Téléphone">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-center">
                                        <input type="email" name="externes[0][email]" class="form-control form-control-sm border-0 shadow-sm me-2" placeholder="Email">
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeExterneRow(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ordre du jour -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark"><i class="fas fa-list-ul me-2 text-secondary"></i> Ordre du jour / Notes</label>
                        <textarea name="ordre_du_jour" class="form-control border-0 shadow-sm bg-light" rows="4" placeholder="Quels sont les points clés ?"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <a href="{{ route('reunions.hebdo') }}" class="btn btn-link text-secondary text-decoration-none fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Annuler
                    </a>
                    <button type="submit" class="btn px-5 py-3 rounded-pill shadow-lg text-white fw-black" style="background: linear-gradient(45deg, #10b981, #059669); transition: all 0.3s;">
                        <i class="fas fa-save me-2"></i> ENREGISTRER LA RÉUNION
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.25 red; /* Invisible but triggers transition */
    }
    .btn:hover { transform: scale(1.05); }
    kbd { font-family: sans-serif; padding: 3px 6px; }
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 10px;
    }
</style>

<script>
    function openGoogleMaps() {
        const input = document.getElementById('lieu_reunion');

        if (input && input.value.trim() !== "") {
            // URL OFFICIELLE : Notez le "/maps/search/" et le "?api=1&query="
            const url = "https://google.com/maps/search/?api=1&query=" + encodeURIComponent(input.value);

            window.open(url, '_blank');
        } else {
            alert("Veuillez saisir un lieu (ex: Bouaké Belleville) avant de cliquer sur Maps.");
        }
    }
</script>
<script>
    function initAutocomplete() {
        const input = document.getElementById('lieu_reunion');

        // Options pour limiter la recherche (ex: Côte d'Ivoire)
        const options = {
            componentRestrictions: { country: "CI" },
            fields: ["name", "address_components", "formatted_address"],
        };

        const autocomplete = new google.maps.places.Autocomplete(input, options);

        // Se déclenche quand l'utilisateur clique sur une suggestion
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            if (!place.name) return;

            // Extraire la ville des composants de l'adresse
            let city = "";
            if (place.address_components) {
                for (const component of place.address_components) {
                    if (component.types.includes("locality")) {
                        city = component.long_name;
                        break;
                    }
                }
            }

            // Formater le texte final : "Nom du lieu, Ville"
            const finalAddress = city ? `${place.name}, ${city}` : place.name;

            // Remplir le champ avec le résultat
            input.value = finalAddress;
        });
    }

    // Lancer l'initialisation au chargement de la page
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>
<script>
let externeCount = 1;

function addExterneRow() {
    const container = document.getElementById('externes-container');
    const html = `
        <div class="row g-2 mb-2 externe-row animate__animated animate__fadeIn">
            <div class="col-md-3">
                <input type="text" name="externes[${externeCount}][nom_complet]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Nom complet" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="externes[${externeCount}][origine]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Structure">
            </div>
            <div class="col-md-2">
                <input type="text" name="externes[${externeCount}][fonction]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Fonction">
            </div>
            <div class="col-md-2">
                <input type="text" name="externes[${externeCount}][telephone]" class="form-control form-control-sm border-0 shadow-sm" placeholder="Téléphone">
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <input type="email" name="externes[${externeCount}][email]" class="form-control form-control-sm border-0 shadow-sm me-2" placeholder="Email">
                <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeExterneRow(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    externeCount++;
}

function removeExterneRow(btn) {
    const rows = document.querySelectorAll('.externe-row');
    if (rows.length > 1) {
        btn.closest('.externe-row').remove();
    } else {
        alert("Il faut au moins un emplacement ou vider les champs.");
    }
}
</script>

@endsection

