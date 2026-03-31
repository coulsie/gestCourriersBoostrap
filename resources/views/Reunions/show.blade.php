@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc;">

    <!-- Header avec Actions -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('reunions.hebdo') }}" class="text-decoration-none text-muted">Réunions</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Détails</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-dark fw-bolder">📝 {{ $reunion->objet }}</h1>
        </div>
        <div class="no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary shadow-sm rounded-pill px-3 me-2">
                <i class="fas fa-print me-1"></i> Imprimer
            </button>
            <a href="{{ route('reunions.edit', $reunion->id) }}" class="btn btn-warning shadow-sm rounded-pill px-4 text-white fw-bold">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Colonne Gauche : Infos Principales -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row text-center mb-4">
                        <div class="col-md-4 border-end">
                            <p class="text-muted small text-uppercase fw-bold mb-1">Date & Jour</p>
                            <h5 class="fw-bold text-primary">
                                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F Y') }}
                            </h5>
                        </div>
                        <div class="col-md-4 border-end">
                            <p class="text-muted small text-uppercase fw-bold mb-1">Heure & Durée</p>
                            <h5 class="fw-bold text-danger">
                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($reunion->date_heure)->format('H:i') }}
                                <span class="badge bg-soft-danger text-danger fs-6 ms-1" style="background: #fff1f2;">({{ $reunion->duree_minutes ?? '60' }} min)</span>
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted small text-uppercase fw-bold mb-1">Lieu / Emplacement</p>
                            <h5 class="fw-bold text-dark">
                                <i class="fas fa-map-marker-alt me-2 text-info"></i>
                                <a href="https://google.com{{ urlencode($reunion->lieu) }}" target="_blank" class="text-dark text-decoration-none" title="Localiser sur Google Maps">
                                    {{ $reunion->lieu ?? 'Non spécifié' }}
                                </a>
                            </h5>
                        </div>
                    </div>

                    <hr class="opacity-50">

                    <div class="mt-4">
                        <h6 class="fw-black text-uppercase text-secondary mb-3" style="letter-spacing: 1px;">
                            <i class="fas fa-align-left me-2 text-primary"></i>Ordre du jour & Notes
                        </h6>
                        <div class="p-4 rounded-4 bg-light min-vh-25" style="border-left: 5px solid #4e73df;">
                            {!! nl2br(e($reunion->ordre_du_jour ?? 'Aucun ordre du jour spécifié.')) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participants -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-users-cog me-2 text-primary"></i>Liste des Participants</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Internes -->
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-2 d-block">Agents Internes DSESF</label>
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($reunion->participants as $participant)
                                    <span class="badge rounded-pill px-3 py-2 border text-dark bg-white shadow-sm">
                                        <i class="fas fa-user-circle me-1 text-danger"></i>
                                        {{ strtoupper($participant->last_name) }} {{ $participant->first_name }}
                                    </span>
                                @empty
                                    <span class="text-muted italic small">Aucun agent interne listé.</span>
                                @endforelse
                            </div>
                        </div>
                        <!-- Externes -->
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-2 d-block">Personnes Externes DSESF</label>
                            <div class="d-flex flex-wrap gap-2">
                                @php $externes = is_string($reunion->externes) ? json_decode($reunion->externes, true) : $reunion->externes; @endphp
                                @forelse($externes ?? [] as $externe)
                                    <span class="badge rounded-pill px-3 py-2 text-dark border-0 shadow-sm" style="background-color: #fef3c7;">
                                        <i class="fas fa-external-link-alt me-1 text-warning"></i>{{ $externe }}
                                    </span>
                                @empty
                                    <span class="text-muted italic small">Aucun participant externe.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Rôles Clés & Métadonnées -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="p-4 bg-primary text-white">
                        <h6 class="text-uppercase small fw-bold opacity-75 mb-3">Rôles de la séance</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;"><i class="fas fa-microphone text-primary"></i></div>
                            <div>
                                <small class="d-block opacity-75">Animateur</small>
                                <span class="fw-bold fs-5">{{ strtoupper($reunion->animateur->last_name) }} {{ $reunion->animateur->first_name }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;"><i class="fas fa-pen-nib text-success"></i></div>
                            <div>
                                <small class="d-block opacity-75">Rédacteur</small>
                                <span class="fw-bold fs-5">{{ strtoupper($reunion->redacteur->last_name) }} {{ $reunion->redacteur->first_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                            <span class="text-muted small">Créé le :</span>
                            <span class="small fw-bold">{{ $reunion->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Dernière modif :</span>
                            <span class="small fw-bold">{{ $reunion->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background-color: white !important; }
        .card { shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endsection
