@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h1 class="h3 fw-bold text-dark"><i class="fas fa-file-alt me-2 text-primary"></i>État des Réunions</h1>
        <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 shadow-sm">
            <i class="fas fa-print me-2 text-warning"></i> Imprimer le Rapport
        </button>
    </div>

    {{-- Formulaire de Filtre (Caché à l'impression) --}}
    <div class="card shadow-sm border-0 mb-4 no-print bg-light">
        <div class="card-body">
            <form action="{{ route('reunions.etat') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="small fw-bold">Du</label>
                    <input type="date" name="date_debut" class="form-control" value="{{ $debut->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Au</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ $fin->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="programmee" {{ $statut == 'programmee' ? 'selected' : '' }}>📅 Programmées</option>
                        <option value="terminee" {{ $statut == 'terminee' ? 'selected' : '' }}>✅ Exécutées</option>
                        <option value="annulee" {{ $statut == 'annulee' ? 'selected' : '' }}>❌ Annulées</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm"><i class="fas fa-search me-1"></i> Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Rapport --}}
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 text-center">
            <h4 class="fw-black mb-1">DSESF - ÉTAT RÉCAPITULATIF DES RÉUNIONS</h4>
            <p class="text-muted mb-0">Période du <strong>{{ $debut->format('d/m/Y') }}</strong> au <strong>{{ $fin->format('d/m/Y') }}</strong></p>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0 align-middle">
                <thead class="table-dark text-center small">
                    <tr>
                        <th>Date & Heure</th>
                        <th>Objet / Lieu</th>
                        <th>Animateur</th>
                        <th>Participants (Int/Ext)</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reunions as $r)
                    <tr>
                        <td class="text-center">
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($r->date_heure)->format('d/m/Y') }}</span><br>
                            <small class="text-danger fw-bold">{{ \Carbon\Carbon::parse($r->date_heure)->format('H:i') }}</small>
                        </td>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">{{ $r->objet }}</div>
                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $r->lieu }}</small>
                        </td>
                        <td>{{ strtoupper($r->animateur->last_name) }}</td>
                        <td class="small">
    {{-- 1. BLOC INTERNES : Blanc sur Vert Émeraude Éclatant --}}
    <div class="mb-2">
        <small class="d-block fw-bold mb-1" style="font-size: 0.65rem; color: #059669; text-transform: uppercase;">
            <i class="fas fa-user-tie me-1"></i> Internes DSESF ({{ $r->participants->count() }})
        </small>
        <div class="d-flex flex-wrap gap-1">
            @foreach($r->participants as $participant)
                <span class="badge shadow-sm text-white px-2 py-1"
                      style="background-color: #10b981; font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.2);">
                    {{ strtoupper(substr($participant->last_name, 0, 1)) }}. {{ $participant->first_name }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- 2. BLOC EXTERNES : Blanc sur Orange Éclatant --}}
    @php
        $ext = is_array($r->externes) ? $r->externes : json_decode($r->externes, true);
        $countExt = is_array($ext) ? count($ext) : 0;
    @endphp

    @if($countExt > 0)
        <div class="border-top pt-2">
            <small class="d-block fw-bold mb-1" style="font-size: 0.65rem; color: #d97706; text-transform: uppercase;">
                <i class="fas fa-external-link-alt me-1"></i> Externes DSESF ({{ $countExt }})
            </small>
            <div class="d-flex flex-wrap gap-1">
                @foreach($ext as $externe)
                    <span class="badge shadow-sm text-white px-2 py-1"
                          style="background-color: #f59e0b; font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.2);">
                        {{ $externe }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</td>



                        <td class="text-center">
                            <span class="fw-bold small text-{{ $r->status == 'terminee' ? 'success' : ($r->status == 'annulee' ? 'secondary' : 'primary') }}">
                                {{ strtoupper($r->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5">Aucune donnée sur cette période.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .card { border: 1px solid #000 !important; box-shadow: none !important; }
        .table-dark { background-color: #eee !important; color: #000 !important; }
        body { background: white !important; }
    }
</style>
@endsection
