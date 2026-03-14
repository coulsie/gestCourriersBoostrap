@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fas fa-user-shield shadow-sm p-2 rounded bg-white me-2 text-primary"></i>Détails de l'Intérim #{{ $interim->id }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('interims.index') }}">Liste des Intérims</a></li>
                    <li class="breadcrumb-item active">Détails</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('interims.index') }}" class="btn btn-outline-secondary shadow-sm fw-bold">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <a href="{{ route('interims.edit', $interim->id) }}" class="btn btn-warning shadow-sm fw-bold text-dark">
                <i class="fas fa-edit"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- COLONNE GAUCHE : Acteurs -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Passation de Pouvoir</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center text-center">
                        <!-- Titulaire -->
                        <div class="col-md-5">
                            <div class="p-3 border rounded-4 bg-light mb-3">
                                <i class="fas fa-user-tie fa-3x mb-3 text-danger opacity-75"></i>
                                <h6 class="text-uppercase small fw-bold text-muted">Titulaire (Absent)</h6>
                                <h5 class="fw-bold text-dark mb-1">{{ $interim->agent->last_name }} {{ $interim->agent->first_name }}</h5>
                                <span class="badge bg-danger-subtle text-danger px-3">{{ $interim->agent->status }}</span>
                            </div>
                        </div>

                        <!-- Flèche de transfert -->
                        <div class="col-md-2 d-none d-md-block">
                            <i class="fas fa-long-arrow-alt-right fa-3x text-primary opacity-50"></i>
                        </div>

                        <!-- Remplaçant -->
                        <div class="col-md-5">
                            <div class="p-3 border rounded-4 bg-light mb-3">
                                <i class="fas fa-user-check fa-3x mb-3 text-success opacity-75"></i>
                                <h6 class="text-uppercase small fw-bold text-muted">Intérimaire (Remplaçant)</h6>
                                <h5 class="fw-bold text-dark mb-1">{{ $interim->interimaire->last_name }} {{ $interim->interimaire->first_name }}</h5>
                                <span class="badge bg-success-subtle text-success px-3">{{ $interim->interimaire->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motif et Détails -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold small text-muted mb-3">Motif de l'intérim</h6>
                    <div class="p-3 bg-light rounded border-start border-4 border-primary">
                        {{ $interim->motif ?: 'Aucun motif spécifié.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- COLONNE DROITE : Statut et Dates -->
        <div class="col-lg-5">
            <!-- État de l'intérim -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold small text-muted mb-3 text-center">Période et Statut</h6>

                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Date de Début :</span>
                        <span class="fw-bold">{{ \Carbon\Carbon::parse($interim->date_debut)->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 border-bottom pb-2">
                        <span class="text-muted">Date de Fin :</span>
                        <span class="fw-bold">{{ \Carbon\Carbon::parse($interim->date_fin)->format('d/m/Y') }}</span>
                    </div>

                    @php
                        $today = now()->startOfDay();
                        $debut = \Carbon\Carbon::parse($interim->date_debut);
                        $fin = \Carbon\Carbon::parse($interim->date_fin);
                    @endphp

                    <div class="text-center py-2">
                        @if(!$interim->is_active)
                            <div class="alert alert-danger mb-0 fw-bold text-uppercase"><i class="fas fa-times-circle me-2"></i> Annulé</div>
                        @elseif($today->between($debut, $fin))
                            <div class="alert alert-success mb-0 fw-bold text-uppercase shadow-sm"><i class="fas fa-check-circle me-2"></i> Actuellement Actif</div>
                        @elseif($today->lt($debut))
                            <div class="alert alert-info mb-0 fw-bold text-uppercase"><i class="fas fa-calendar-alt me-2"></i> À Venir</div>
                        @else
                            <div class="alert alert-secondary mb-0 fw-bold text-uppercase"><i class="fas fa-archive me-2"></i> Terminé</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- État de l'Absence liée -->
            <div class="card border-0 shadow-sm border-left-info">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold small text-info mb-3">Validation de l'Absence</h6>
                    @php
                        $absence = \App\Models\Absence::where('agent_id', $interim->agent_id)
                            ->where('date_debut', $interim->date_debut)
                            ->where('date_fin', $interim->date_fin)
                            ->first();
                    @endphp

                    @if($absence)
                        <div class="d-flex align-items-center">
                            @if($absence->approuvee == 2)
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block text-success">Absence Approuvée</span>
                                    <small class="text-muted italic">Générée automatiquement le {{ $absence->created_at->format('d/m/Y') }}</small>
                                </div>
                            @else
                                <div class="bg-warning text-dark rounded-circle p-2 me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <span class="fw-bold text-warning">Absence en attente de validation</span>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-light border mb-0 small">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i> Aucune absence liée trouvée en base.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
