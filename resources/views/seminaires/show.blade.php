@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc;">

    <!-- Header avec Actions -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('seminaires.index') }}" class="text-decoration-none text-muted">Séminaires</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Détails & Émargement</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-dark fw-bolder">🎓 {{ $seminaire->titre }}</h1>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-outline-secondary shadow-sm rounded-pill px-3 me-2">
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

            <!-- TABLEAU D'ÉMARGEMENT (LISTE DE PRÉSENCE) -->
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-check-double me-2 text-success"></i>Liste d'Émargement</h6>
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
                                <th class="text-center no-print">Pointage</th>
                                <th class="text-end pe-4">Signature / Heure</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($seminaire->participations as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $p->nom_complet }}</div>
                                    @if($p->agent) <small class="text-muted">Mat: {{ $p->agent->matricule }}</small> @endif
                                </td>
                                <td>
                                    <span class="badge px-2 py-1 rounded-pill {{ $p->agent_id ? 'bg-soft-info text-info' : 'bg-soft-warning text-warning' }}" style="font-size: 0.7rem;">
                                        {{ $p->structure }}
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    <form action="{{ route('seminaires.pointer', [$seminaire->id, $p->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $p->est_present ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-3 fw-bold">
                                            <i class="fas {{ $p->est_present ? 'fa-check' : 'fa-fingerprint' }} me-1"></i>
                                            {{ $p->est_present ? 'Présent' : 'Pointer' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end pe-4 text-muted small italic">
                                    {{ $p->heure_pointage ? $p->heure_pointage->format('H:i') : '..........................' }}
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
                    <button type="button" class="btn btn-sm btn-light py-0 px-2 fw-bold" onclick="toggleAll()" style="font-size: 0.7rem;">Tout cocher</button>
                </div>
                <div class="card-body">
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
                </div>
            </div>

            <!-- Inscription Externe -->
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

            <!-- Archivage Rapport -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-file-pdf me-2 text-danger"></i>Rapport Final</h6>
                    <form action="{{ route('seminaires.documents.store', $seminaire->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- On définit le type via un champ caché car c'est un "rapport" -->
                        <input type="hidden" name="type" value="rapport">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Document (PDF, Word, Image)</label>
                            <input type="file" name="fichier" class="form-control mb-2 border-0 bg-light rounded-3" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold">
                            <i class="fas fa-file-archive me-2"></i>Archiver le Rapport
                        </button>
                    </form>

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
