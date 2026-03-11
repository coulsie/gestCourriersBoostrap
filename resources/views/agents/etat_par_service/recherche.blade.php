@extends('layouts.app')

<style>
@media print {
    .btn, .navbar, .sidebar, footer {
        display: none !important;
    }
}
</style>
@section('content')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 shadow-sm rounded-4 bg-white border-start border-5 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-primary fw-bold mb-1">
                            <i class="fas fa-search me-2"></i>Recherche d'Agents
                        </h2>
                        <p class="text-muted mb-0">Filtrez les effectifs par service, nom ou matricule.</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary fs-6 shadow-sm">{{ $agents->count() }} Agents trouvés</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone de Recherche et Filtres -->
   <div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        {{-- Utilisation de GET pour que la recherche soit mémorisée dans l'URL --}}
        <form action="{{ route('agents.par.service') }}" method="GET" class="row g-3">
            {{-- Pas de @csrf en méthode GET pour garder une URL propre --}}

            <div class="col-md-5">
                <label class="form-label fw-bold"><i class="fas fa-sitemap text-primary me-2"></i>Service</label>
                {{-- On garde le search s'il existe lors du changement de service --}}
                <select name="service_id" class="form-select border-2 shadow-none" onchange="this.form.submit()">
                    <option value="">Tous les services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} ({{ $service->code }})
                        </option>
                    @endforeach
                </select>
                {{-- Champ caché pour conserver la recherche texte lors du changement de service via le select --}}
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
            </div>

            <div class="col-md-5">
                <label class="form-label fw-bold"><i class="fas fa-user text-primary me-2"></i>Recherche rapide</label>
                <div class="input-group">
                    {{-- L'attribut name='search' permet au contrôleur de recevoir le '410' --}}
                    <input type="text" name="search" id="tableSearch" class="form-control border-2 shadow-none"
                         placeholder="Tapez un nom, un matricule..." value="{{ request('search') }}" autocomplete="off">
                    <span class="input-group-text bg-white border-2 border-start-0 text-muted">
                        <i class="fas fa-keyboard"></i>
                    </span>
                </div>
            </div>

            
        </form>
    </div>
</div>

    <!-- Résultats -->
        <!-- Résultats -->
    <div class="card border-0 shadow-lg overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="agentsTable">
                <thead class="bg-dark text-white">
                    <tr class="text-uppercase small fw-bold">
                        <th class="py-3 ps-4">Matricule</th>
                        <th>Identité</th>
                        <th>Statut & Grade</th>
                        <th>Contact</th>
                        <th class="text-end pe-4">Service</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($agents as $agent)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border fw-bold px-3 py-2">{{ $agent->matricule }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                         style="width: 40px; height: 40px; font-size: 1.2rem;">
                                        {{ substr($agent->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ strtoupper($agent->last_name) }}</div>
                                        <div class="text-muted small">{{ $agent->first_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $color = match(strtolower($agent->status)) {
                                        'chef de service' => 'success',
                                        'sous-directeur' => 'warning',
                                        'directeur' => 'danger',
                                        default => 'info',
                                    };
                                @endphp
                                <span class="badge bg-{{ $color }} text-white rounded-pill">
                                    {{ $agent->status }}
                                </span>
                            </td>
                            <td>
                                <div class="small"><i class="fas fa-envelope text-muted me-2"></i>{{ $log->user->email ?? $agent->email_professionnel }}</div>
                                <div class="small mt-1"><i class="fas fa-phone text-muted me-2"></i>{{ $agent->phone_number }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <span class="badge border border-primary text-primary px-3">{{ $agent->service->name ?? 'N/A' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <p class="text-muted fs-5">Aucun agent ne correspond à votre recherche pour "{{ request('search') }}".</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}

        @if($agents instanceof \Illuminate\Pagination\LengthAwarePaginator && $agents->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                {{-- ... votre code de pagination ... --}}
            </div>
        @endif
    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tableSearch');
    const tableRows = document.querySelectorAll('#agentsTable tbody tr:not(.no-result)');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();

        // Si le champ est vide, on réaffiche tout sur la page
        if (query === "") {
            tableRows.forEach(row => row.style.display = '');
            return;
        }

        tableRows.forEach(row => {
            // Ciblage précis des colonnes Matricule (1) et Identité (2)
            const matricule = row.querySelector('td:nth-child(1)')?.textContent.toLowerCase().trim() || '';
            const identite = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase().trim() || '';

            if (matricule.includes(query) || identite.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});


</script>


@endsection
