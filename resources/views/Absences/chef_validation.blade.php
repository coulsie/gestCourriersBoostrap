@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-user-check"></i> Validations des Absences (Chef de Service)</h4>
            <span class="badge bg-light text-dark">{{ $demandes->count() }} demande(s) en attente</span>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Agent</th>
                            <th>Période</th>
                            <th>Type</th>
                            <th>Commentaire (Optionnel)</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demandes as $demande)
                        <tr>
                            <td>
                                <strong>{{ $demande->agent->first_name }} {{ $demande->agent->last_name }}</strong><br>
                                <small class="text-muted">Matricule: {{ $demande->agent->matricule }}</small>
                            </td>
                            <td>
                                <span class="text-primary">Du {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }}</span><br>
                                <span class="text-primary">Au {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}</span>
                            </td>
                            <td>{{ $demande->typeAbsence->name ?? 'N/A' }}</td>
                            <td>
                                {{-- Formulaire intégré pour chaque ligne --}}
                                <form action="{{ route('chef.absences.valider', $demande->id) }}" method="POST" id="form-valider-{{ $demande->id }}">
                                    @csrf
                                    <input type="text" name="commentaire" class="form-control form-control-sm" placeholder="Ex: Avis favorable...">
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    {{-- Bouton Valider --}}
                                    <button type="submit" form="form-valider-{{ $demande->id }}"
                                            onclick="this.form.action='{{ route('chef.absences.valider', $demande->id) }}'"
                                            class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Valider
                                    </button>

                                    {{-- Bouton Rejeter --}}
                                    <button type="submit" form="form-valider-{{ $demande->id }}"
                                            onclick="this.form.action='{{ route('chef.absences.rejeter', $demande->id) }}'"
                                            class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Rejeter
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-coffee fa-2x mb-3"></i><br>
                                    Aucune demande en attente de validation pour votre service.
                                </div>
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
