@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        {{-- Header avec bleu éclatant --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(45deg, #007bff, #00d4ff);">
            <h4 class="mb-0 fw-bold"><i class="fas fa-calendar-alt"></i> Mes Demandes d'Autorisation d'Absence</h4>
            <a href="{{ route('absences.monautorisation') }}" class="btn btn-light btn-sm fw-bold text-primary shadow-sm">
                <i class="fas fa-plus-circle"></i> Nouvelle Demande
            </a>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm fw-bold text-center" style="background-color: #d4edda; color: #155724;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #f8f9fa;">
                        <tr class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                            <th class="text-primary">Référence</th>
                            <th class="text-primary">Type d'absence</th>
                            <th class="text-primary">Période (Dates)</th>
                            <th class="text-center text-primary">Progression / Statut</th>
                            <th class="text-end text-primary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absences as $absence)
                        <tr>
                            <td class="fw-bold text-dark">#ABS-{{ $absence->id }}</td>
                            <td>
                                <span class="badge bg-info text-white px-3 py-2 shadow-sm" style="font-size: 0.9rem;">
                                    {{ $absence->typeAbsence->nom_type ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border-start border-primary border-4">
                                    <small class="text-muted">Du</small> <strong class="text-dark">{{ \Carbon\Carbon::parse($absence->date_debut)->format('d/m/Y') }}</strong><br>
                                    <small class="text-muted">Au</small> <strong class="text-dark">{{ \Carbon\Carbon::parse($absence->date_fin)->format('d/m/Y') }}</strong>
                                </div>
                            </td>
                            <td class="text-center" style="min-width: 200px;">
                                @if($absence->statut_autorisation_absence == 'en_attente')
                                    {{-- Noir sur Jaune éclatant --}}
                                    <span class="badge w-100 py-2 shadow-sm" style="background-color: #ffc107; color: #000; font-size: 0.85rem;">
                                        <i class="fas fa-clock"></i> ⏳ EN ATTENTE DU CHEF
                                    </span>
                                    <div class="progress mt-2 shadow-sm" style="height: 10px; background-color: #e9ecef;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 50%"></div>
                                    </div>
                                @elseif($absence->statut_autorisation_absence == 'valide_chef')
                                    {{-- Vert sur fond Rouge (ou texte Vert éclatant sur fond clair) --}}
                                    {{-- Pour respecter Vert/Rouge : Fond rouge avec texte blanc/vert --}}
                                    <span class="badge w-100 py-2 shadow-sm text-uppercase" style="background-color: #28a745; color: #fff; border: 2px solid #dc3545; font-size: 0.85rem;">
                                        <i class="fas fa-check-circle"></i> ✅ VALIDÉE PAR LE CHEF
                                    </span>
                                    <div class="progress mt-2 shadow-sm" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                @else
                                    {{-- Blanc sur Rouge éclatant --}}
                                    <span class="badge w-100 py-2 shadow-sm text-uppercase" style="background-color: #dc3545; color: #fff; font-size: 0.85rem;">
                                        <i class="fas fa-times-circle"></i> ❌ DEMANDE REJETÉE
                                    </span>
                                    <div class="progress mt-2 shadow-sm" style="height: 10px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($absence->statut_autorisation_absence == 'valide_chef')
                                    <a href="{{ route('absences.print', $absence->id) }}" class="btn btn-primary btn-sm shadow fw-bold px-3" target="_blank" style="background-color: #007bff; border: none;">
                                        <i class="fas fa-print"></i> IMPRIMER PDF
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-light text-muted border shadow-sm" disabled>
                                        <i class="fas fa-lock"></i> Indisponible
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                                <p class="text-muted fw-bold">Aucune demande d'absence trouvée dans vos archives.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Effet de surbrillance sur les lignes au passage de la souris */
    .table-hover tbody tr:hover {
        background-color: #f0f7ff !important;
        transition: 0.3s;
    }
    .badge { letter-spacing: 0.5px; }
</style>
@endsection
