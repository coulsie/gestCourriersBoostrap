@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header & Filtres (Cachés à l'impression) -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h3 class="fw-bold">📈 Tableau Croisé des Activités</h3>
        <div class="d-flex gap-2">
            <form action="{{ route('activities.reporting') }}" method="GET" class="d-flex gap-2">
                <select name="type" class="form-select border-0 shadow-sm" onchange="this.form.submit()">
                    <option value="mois" {{ $type == 'mois' ? 'selected' : '' }}>Vue Mensuelle</option>
                    <option value="semaine" {{ $type == 'semaine' ? 'selected' : '' }}>Vue Hebdomadaire</option>
                </select>
                <input type="number" name="annee" value="{{ $annee }}" class="form-control border-0 shadow-sm" style="width: 100px;">
            </form>
            <button onclick="window.print()" class="btn btn-dark shadow-sm">
                <i class="fas fa-print me-2"></i>Imprimer le Rapport
            </button>
        </div>
    </div>

    <!-- Le Tableau Croisé -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light text-center">
                    <tr>
                        <th rowspan="2" class="align-middle bg-white" style="min-width: 250px;">Directions / Services</th>
                        <th colspan="{{ count($colonnes) }}" class="py-2 text-uppercase small fw-bold">Périodes ({{ $annee }})</th>
                        <th rowspan="2" class="align-middle bg-primary text-white">Total</th>
                    </tr>
                    <tr>
                        @foreach($colonnes as $col)
                            <th style="width: 40px;">{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($directions as $dir)
                        <!-- Ligne Direction (Grisée) -->
                        <tr class="table-secondary fw-bold">
                            <td colspan="{{ count($colonnes) + 2 }}">{{ $dir->name }}</td>
                        </tr>
                        @foreach($dir->services as $service)
                        <tr>
                            <td class="ps-4 text-secondary">{{ $service->name }}</td>
                            @php $totalRow = 0; @endphp
                            @foreach($colonnes as $col)
                                @php
                                    $val = $matrix[$service->id][$col] ?? 0;
                                    $totalRow += $val;
                                @endphp
                                <td class="text-center {{ $val > 0 ? 'fw-bold text-primary' : 'text-muted opacity-25' }}">
                                    {{ $val ?: '.' }}
                                </td>
                            @endforeach
                            <td class="text-center fw-bold bg-light">{{ $totalRow }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white; }
        .table-responsive { overflow: visible !important; }
        table { width: 100% !important; border-collapse: collapse; }
        @page { size: landscape; margin: 1cm; }
    }
    .table th, .table td { border-color: #ebedf2 !important; }
</style>
@endsection
