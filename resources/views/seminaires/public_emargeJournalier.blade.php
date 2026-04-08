@extends('layouts.guest') {{-- Ou un layout sans barre de navigation --}}

@section('content')
<div class="container py-5 text-center">
    <h3 class="fw-bold mb-3">{{ $seminaire->titre }}</h3>
    <div class="alert alert-info rounded-4 border-0">
        <i class="fas fa-calendar-alt me-2"></i> Émargement du <strong>{{ $aujourdhui }}</strong>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('seminaires.public.validerJournalier', $seminaire->uuid) }}" method="POST" class="mt-4 text-start">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-bold text-muted small">Veuillez sélectionner votre nom :</label>
            <select name="participant_id" class="form-select form-select-lg border-primary rounded-4 shadow-sm" required>
                <option value="">-- Qui êtes-vous ? --</option>
                @foreach($seminaire->participants->sortBy('nom_complet') as $p)
                    <option value="{{ $p->id }}">{{ $p->nom_complet }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow">
            Valider ma présence
        </button>
    </form>
</div>
@endsection
