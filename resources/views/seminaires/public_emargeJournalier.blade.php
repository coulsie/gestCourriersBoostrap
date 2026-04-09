@extends('layouts.guest') {{-- Ou un layout sans barre de navigation --}}

@section('content')
<div class="container py-5 text-center">
    <h3 class="fw-bold mb-3">{{ $seminaire->titre }}</h3>

    <div class="alert alert-info rounded-4 border-0 shadow-sm">
        <i class="fas fa-calendar-alt me-2"></i> Émargement du <strong>{{ $aujourdhui }}</strong>
    </div>

    {{-- Affichage du message de succès --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-4 border-0">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Affichage des messages d'erreur (ex: mauvais jour de scan) --}}
    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-4 border-0">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('seminaires.public.validerJournalier', $seminaire->uuid) }}" method="POST" class="mt-4 text-start">
        @csrf
        <input type="hidden" name="date_pointage" value="{{ request()->route('date_pointage') }}">

        <div class="mb-4">
            <label class="form-label fw-bold text-muted small ms-2">Rechercher / Sélectionner votre nom :</label>

            <!-- Nouveau : Barre de recherche rapide -->
            <input type="text" id="nameFilter" class="form-control mb-2 rounded-4 border-primary-subtle" placeholder="Tapez votre nom...">

            <select name="participant_id" id="participantSelect" class="form-select form-select-lg border-primary rounded-4 shadow-sm" required size="5">
                <option value="" disabled selected>-- Qui êtes-vous ? --</option>
                @foreach($seminaire->participations->sortBy('nom_complet') as $p)
                    <option value="{{ $p->id }}">{{ $p->nom_complet }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-lg border-0 py-3 fw-bold">
            <i class="fas fa-fingerprint me-2"></i> Valider ma présence
        </button>
    </form>

<!-- Petit script de filtrage instantané -->
<script>
    document.getElementById('nameFilter').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let options = document.getElementById('participantSelect').options;
        for (let i = 1; i < options.length; i++) {
            let text = options[i].text.toLowerCase();
            options[i].style.display = text.includes(filter) ? "" : "none";
        }
    });
</script>


    <p class="text-muted mt-4 small">
        <i class="fas fa-info-circle me-1"></i> Votre heure de pointage sera enregistrée automatiquement.
    </p>
</div>
@endsection
