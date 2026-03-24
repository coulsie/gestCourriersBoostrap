@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Card avec bordure supérieure colorée --}}
            <div class="card shadow-lg border-0 border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>Gestion des Autorisations d'Absences
                    </h4>
                    <a href="{{ route('absences.create') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter une Autorisation d'Absence
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success') || session('status'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') ?? session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-secondary">ID</th>
                                    <th class="text-secondary">Agent</th>
                                    <th class="text-secondary">Type & Justificatif</th>
                                    <th class="text-secondary text-center">Période</th>
                                    <th class="text-secondary text-center">Approuvée</th>
                                    <th class="text-secondary text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absences as $absence)
                                    <tr>
                                        <td class="fw-bold text-muted">#{{ $absence->id }}</td>
                                        <td>
                                            <div class="p-1">
                                                <!-- NOM ET PRÉNOM : Texte Noir Intense -->
                                                <div class="fw-black text-dark fs-5 mb-1" style="letter-spacing: -0.2px;">
                                                    @if($absence->agent)
                                                        <span class="text-primary"><i class="fas fa-user-circle me-1"></i></span>
                                                        {{ strtoupper($absence->agent->last_name) }} {{ $absence->agent->first_name }}
                                                    @else
                                                        <span class="badge bg-danger shadow-sm">
                                                            <i class="fas fa-exclamation-triangle me-1"></i> ID #{{ $absence->agent_id }} INCONNU
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- SERVICE : Couleurs Éclatantes (Dégradé de Bleu/Violet) -->
                                                <div class="mt-1">
                                                    @if($absence->agent?->service)
                                                        <span class="badge shadow-sm border-0 px-3 py-2"
                                                            style="background: linear-gradient(135deg, #6610f2 0%, #0d6efd 100%);
                                                                    color: white;
                                                                    font-weight: 800;
                                                                    font-size: 0.8rem;
                                                                    letter-spacing: 0.5px;
                                                                    border-radius: 8px;">
                                                            <i class="fas fa-building me-2"></i>{{ strtoupper($absence->agent->service->name) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 fw-bold">
                                                            <i class="fas fa-question-circle me-1"></i> SERVICE NON DÉFINI
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>


                                        </td>
                                        <td>
                                            <!-- Type d'absence avec fallback sécurisé -->
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 mb-1">
                                                {{ $absence->typeAbsence->nom ?? ($absence->typeAbsence->nom_type ?? 'Non défini') }}
                                            </span>
                                            <br>

                                            @if($absence->document_justificatif)
                                                {{-- Lien mis à jour pour pointer vers public/JustificatifAbsences --}}
                                                <a href="{{ asset('JustificatifAbsences/' . $absence->document_justificatif) }}"
                                                target="_blank"
                                                class="text-success small text-decoration-none fw-bold">
                                                    <i class="fas fa-file-pdf me-1"></i>Voir le scan
                                                </a>
                                            @else
                                                <small class="text-muted small italic">
                                                    <i class="fas fa-times-circle me-1 text-danger"></i>Sans justificatif
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="small fw-bold">{{ \Carbon\Carbon::parse($absence->date_debut)->translatedFormat('d M Y') }}</div>
                                            <div class="text-muted small">au {{ \Carbon\Carbon::parse($absence->date_fin)->translatedFormat('d M Y') }}</div>
                                        </td>

                                            <<td class="text-center">
                                            @if ($absence->approuvee == 1)
                                                {{-- Cas 1 : Approuvé --}}
                                                <span class="badge bg-success text-white px-3 py-2 shadow-sm">
                                                    <i class="fas fa-check-circle me-1"></i> OUI
                                                </span>
                                            @elseif ($absence->approuvee == 2)
                                                {{-- Cas 2 : Rejeté (votre valeur 2) --}}
                                                <span class="badge bg-danger text-white px-3 py-2 shadow-sm">
                                                    <i class="fas fa-times-circle me-1"></i> NON
                                                </span>
                                            @else
                                                {{-- Cas 0 ou autre : En attente --}}
                                                <span class="badge bg-warning text-dark px-3 py-2 shadow-sm">
                                                    <i class="fas fa-clock me-1"></i> EN ATTENTE
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group shadow-sm">
                                                <a href="{{ route('absences.show', $absence->id) }}" class="btn btn-sm btn-outline-info" title="Détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('absences.edit', $absence->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="if(confirm('Supprimer cette absence ?')) document.getElementById('delete-{{ $absence->id }}').submit();" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-{{ $absence->id }}" action="{{ route('absences.destroy', $absence->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination stylisée --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $absences->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover { background-color: #f8f9ff; transition: 0.2s; }
    .badge { font-weight: 600; letter-spacing: 0.3px; }
    .bg-primary-subtle { background-color: #e7f0ff !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }

    /* Effet de ligne selon le statut */
tr.table-danger-light { background-color: #fff5f5; }
tr.table-success-light { background-color: #f6fff6; }

/* Style pour les avatars et icônes */
.avatar-sm {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
}

.italic { font-style: italic; }
.bg-info-subtle { background-color: #e1f5fe !important; color: #01579b !important; }
</style>
@endsection
