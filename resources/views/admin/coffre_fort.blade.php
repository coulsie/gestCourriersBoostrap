@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <!-- Header avec dégradé moderne -->
        <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-key me-2"></i> Coffre-fort Numérique</h5>
            <span class="badge rounded-pill bg-warning text-dark fw-bold">Niveau: Administrateur</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Référence</th>
                            <th>Objet</th>
                            <th>Date d'Enreg.</th>
                            <th class="text-center">Code Confidentiel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courriers as $courrier)
                        <tr>
                            <td class="ps-4 text-primary fw-bold">{{ $courrier->reference }}</td>
                            <td class="text-secondary">{{ Str::limit($courrier->objet, 50) }}</td>
                            <td>
                                <span class="badge bg-danger text-white fw-bold shadow-sm">
                                    {{ \Carbon\Carbon::parse($courrier->created_at)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="input-group input-group-sm justify-content-center">
                                    <input type="password" 
                                           class="form-control text-center fw-bold border-info bg-light" 
                                           style="max-width: 120px; color: #0d6efd;" 
                                           value="{{ Crypt::decryptString($courrier->code_acces) }}" 
                                           id="input-{{ $courrier->id }}" 
                                           readonly>
                                    <button class="btn btn-outline-info" type="button" onclick="toggleCode({{ $courrier->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Aucun code enregistré dans le coffre-fort.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCode(id) {
    const input = document.getElementById('input-' + id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
