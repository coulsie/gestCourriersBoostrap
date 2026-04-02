@extends('layouts.app')

@section('content')
<style>
    .fw-black { font-weight: 800 !important; }
    .backdrop-blur { backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); }
    .rounded-4 { border-radius: 1.5rem !important; }

    @media print {
        .no-print { display: none !important; }
        .card { border: 1px solid #000 !important; box-shadow: none !important; }
        .table-dark { background-color: #333 !important; color: #fff !important; }
        body { background: white !important; }
        .card-header { background: #f8f9fa !important; color: #000 !important; border: 1px solid #000 !important; }
    }
</style>

<div class="container-fluid py-4">

    {{-- 1. EN-TETE PRINCIPAL (BADGES & TITRE) --}}
    <div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-header border-0 p-4 p-md-5 text-center text-white shadow-sm"
            style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%); border-radius: 1.5rem 1.5rem 1.5rem 1.5rem;">

            <!-- Badge de l'entité -->
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase shadow-sm" style="letter-spacing: 2px; font-size: 0.75rem;">
                Direction de la Stratégie, des Etudes et des Statistiques Fiscales (DSESF)
            </span>

            <!-- Titre Principal -->
            <h2 class="display-6 fw-black text-white mb-2 tracking-tight uppercase" style="letter-spacing: -1px;">
                ÉTAT RÉCAPITULATIF DES RÉUNIONS
            </h2>

            <!-- Période -->
            <div class="d-inline-flex align-items-center bg-white bg-opacity-10 px-4 py-2 rounded-pill backdrop-blur">
                <i class="bi bi-calendar3 me-2"></i>
                <p class="mb-0 fw-bold text-dark text-uppercase" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                    Période du <span class="badge bg-dark text-white px-2 py-1 mx-1">{{ $debut->format('d/m/Y') }}</span>
                    au <span class="badge bg-dark text-white px-2 py-1 mx-1">{{ $fin->format('d/m/Y') }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- 2. FILTRES ET RECHERCHE (CACHÉ À L'IMPRESSION) --}}
    <div class="card shadow-sm border-0 mb-4 no-print bg-white rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0"><i class="fas fa-search me-2"></i>Critères de recherche</h5>
                <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 shadow-sm">
                    <i class="fas fa-print me-2 text-warning"></i> Imprimer
                </button>
            </div>
            <form action="{{ route('reunions.etat') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="small fw-bold text-muted uppercase">Date de début</label>
                    <input type="date" name="date_debut" class="form-control rounded-3 border-light shadow-sm" value="{{ $debut->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted uppercase">Date de fin</label>
                    <input type="date" name="date_fin" class="form-control rounded-3 border-light shadow-sm" value="{{ $fin->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted uppercase">Filtrer par Statut</label>
                    <select name="status" class="form-select rounded-3 border-light shadow-sm">
                        <option value="">Tous les statuts</option>
                        <option value="programmee" {{ $statut == 'programmee' ? 'selected' : '' }}>📅 Programmées</option>
                        <option value="terminee" {{ $statut == 'terminee' ? 'selected' : '' }}>✅ Exécutées</option>
                        <option value="annulee" {{ $statut == 'annulee' ? 'selected' : '' }}>❌ Annulées</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm fw-bold">
                        <i class="fas fa-filter me-1"></i> APPLIQUER LE FILTRE
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. TABLEAU DES RESULTATS --}}
    <div class="card shadow border-0 rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 align-middle">
                    <thead class="table-dark text-center small fw-bold">
                        <tr>
                            <th style="width: 12%;">Date & Heure</th>
                            <th style="width: 25%;">Objet / Lieu</th>
                            <th style="width: 15%;">Animateur</th>
                            <th style="width: 35%;">Participants (Internes / Externes)</th>
                            <th style="width: 13%;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reunions as $r)
                        <tr>
                            <td class="text-center">
                                <span class="fw-bold d-block text-dark">{{ \Carbon\Carbon::parse($r->date_heure)->format('d/m/Y') }}</span>
                                <span class="badge bg-danger text-white fw-bold shadow-sm" style="font-size: 0.8rem; padding: 0.4em 0.8em;">
                                    <i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($r->date_heure)->format('H:i') }}
                                </span>
                            </td>

                            <td class="ps-3">
                                <div class="fw-bold text-dark mb-1">{{ $r->objet }}</div>
                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $r->lieu }}</small>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-uppercase">{{ $r->animateur->last_name }}</span>
                                <br><small class="text-muted">{{ $r->animateur->first_name }}</small>
                            </td>
                            <td class="small py-3">
                                {{-- Internes --}}
                                <div class="mb-3">
                                    <small class="d-block fw-bold mb-2 text-uppercase" style="font-size: 0.65rem; color: #059669;">
                                        <i class="fas fa-user-tie me-1"></i> Internes DSESF ({{ $r->participants->count() }})
                                    </small>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($r->participants as $participant)
                                            <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #10b981; font-size: 0.7rem;">
                                                {{ strtoupper(substr($participant->last_name, 0, 1)) }}. {{ $participant->first_name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Externes --}}
                                @php
                                    $ext = is_array($r->externes) ? $r->externes : json_decode($r->externes, true);
                                    $countExt = is_array($ext) ? count($ext) : 0;
                                @endphp
                                @if($countExt > 0)
                                    <div class="border-top pt-2">
                                        <small class="d-block fw-bold mb-2 text-uppercase" style="font-size: 0.65rem; color: #d97706;">
                                            <i class="fas fa-external-link-alt me-1"></i> Participants Externes ({{ $countExt }})
                                        </small>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($ext as $externe)
                                                <span class="badge shadow-sm text-white px-2 py-1" style="background-color: #f59e0b; font-size: 0.7rem;">
                                                    {{ $externe }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge px-3 py-2 rounded-pill fw-bold text-uppercase"
                                      style="font-size: 0.7rem; background-color: {{ $r->status == 'terminee' ? '#d1fae5' : ($r->status == 'annulee' ? '#f3f4f6' : '#dbeafe') }}; color: {{ $r->status == 'terminee' ? '#065f46' : ($r->status == 'annulee' ? '#374151' : '#1e40af') }};">
                                    {{ $r->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted fw-bold italic">Aucune donnée trouvée pour cette période.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
