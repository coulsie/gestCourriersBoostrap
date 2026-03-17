@extends('layouts.app')

@section('content')
<style>
    /* Effets de survol et bordures colorées par ligne */
    .interim-row-actif { border-left: 5px solid #198754 !important; background-color: rgba(25, 135, 84, 0.02); }
    .interim-row-programme { border-left: 5px solid #0dcaf0 !important; background-color: rgba(13, 202, 240, 0.02); }
    .interim-row-termine { border-left: 5px solid #6c757d !important; }
    .interim-row-annule { border-left: 5px solid #dc3545 !important; background-color: rgba(220, 53, 69, 0.02); }

    .table-hover tbody tr:hover { background-color: rgba(0,0,0,.04) !important; transition: 0.3s; }
    .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.2s; }
    .btn-action:hover { transform: translateY(-2px); }
</style>

<div class="container-fluid py-4 px-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fas fa-user-shield shadow-sm p-2 rounded bg-primary text-white me-2"></i>Suivi des Intérims
            </h2>
            <p class="text-muted small mb-0 font-italic">Gestion et historique des délégations de signature</p>
        </div>
        <a href="{{ route('interims.create') }}" class="btn btn-primary shadow-sm fw-bold px-4 rounded-pill">
            <i class="fas fa-plus-circle me-2"></i> NOUVEL INTÉRIM
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white text-uppercase small">
                        <tr>
                            <th class="ps-4 py-3">Titulaire (Absent)</th>
                            <th>Intérimaire (Remplaçant)</th>
                            <th>Période & Dates</th>
                            <th>Statut</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($interims as $interim)
                            @php
                                $today = now()->startOfDay();
                                $debut = \Carbon\Carbon::parse($interim->date_debut)->startOfDay();
                                $fin = \Carbon\Carbon::parse($interim->date_fin)->endOfDay();

                                // Détermination de la classe de ligne
                                $rowClass = 'interim-row-termine';
                                if(!$interim->is_active) $rowClass = 'interim-row-annule';
                                elseif($today->between($debut, $fin)) $rowClass = 'interim-row-actif';
                                elseif($today->lt($debut)) $rowClass = 'interim-row-programme';
                            @endphp

                            <tr class="{{ $rowClass }}">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark text-uppercase">{{ $interim->agent->last_name }} {{ $interim->agent->first_name }}</div>
                                    <span class="badge bg-danger-soft text-danger small px-2 py-1"><i class="fas fa-user-minus me-1"></i>{{ $interim->agent->status }}</span>
                                </td>

                                <td>
                                    @if($interim->interimaire)
                                        <div class="fw-bold text-primary">{{ $interim->interimaire->last_name }} {{ $interim->interimaire->first_name }}</div>
                                        <span class="badge bg-success-soft text-success small px-2 py-1"><i class="fas fa-user-check me-1"></i>{{ $interim->interimaire->status }}</span>
                                    @else
                                        <span class="text-danger small fw-bold"><i class="fas fa-exclamation-triangle me-1"></i>Agent introuvable</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 text-primary"><i class="far fa-calendar-alt fa-lg"></i></div>
                                        <div class="small">
                                            <span class="d-block fw-bold text-success">Du : {{ $debut->format('d/m/Y') }}</span>
                                            <span class="d-block fw-bold text-danger">Au : {{ $fin->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if(!$interim->is_active)
                                        <span class="badge rounded-pill px-3 py-2 bg-danger text-white shadow-sm w-100"><i class="fas fa-ban me-1"></i> ANNULÉ</span>
                                    @elseif($today->between($debut, $fin))
                                        <span class="badge rounded-pill px-3 py-2 bg-success text-white shadow-sm w-100 border-2 border-white"><i class="fas fa-sync fa-spin me-1"></i> ACTIF</span>
                                    @elseif($today->lt($debut))
                                        <span class="badge rounded-pill px-3 py-2 bg-info text-white shadow-sm w-100"><i class="fas fa-hourglass-start me-1"></i> PROGRAMMÉ</span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 bg-secondary text-white shadow-sm w-100"><i class="fas fa-archive me-1"></i> TERMINÉ</span>
                                    @endif
                                </td>

                                <td class="text-center pe-4">
                                    <div class="btn-group gap-1">
                                        <a href="{{ route('interims.show', $interim->id) }}" class="btn btn-info btn-action" title="Voir"><i class="fas fa-eye text-white"></i></a>
                                        <a href="{{ route('interims.edit', $interim->id) }}" class="btn btn-warning btn-action" title="Modifier"><i class="fas fa-edit text-dark"></i></a>

                                        @if($interim->is_active && $today->lte($fin))
                                            <form action="{{ route('interims.stop', $interim->id) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-dark btn-action" title="Arrêter" onclick="return confirm('Arrêter prématurément ?')"><i class="fas fa-stop-circle text-white"></i></button>
                                            </form>
                                        @endif

                                        <form action="{{ route('interims.destroy', $interim->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action" title="Supprimer" onclick="return confirm('Supprimer l\'intérim et l\'absence liée ?')"><i class="fas fa-trash-alt text-white"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 bg-light">
                                    <i class="fas fa-user-slash display-4 text-muted opacity-25"></i>
                                    <p class="mt-3 fw-bold text-secondary">Aucun intérim répertorié à ce jour.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
