@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-11">
            {{-- Card avec bordure colorée --}}
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                {{-- Header avec dégradé éclatant --}}
                <div class="card-header p-4 d-flex align-items-center justify-content-between"
                     style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);">
                    <h5 class="m-0 text-white fw-bolder fs-4">
                        <i class="fas fa-layer-group me-2"></i> GESTION DES SERVICES
                    </h5>
                    <a href="{{ route('services.create') }}" class="btn btn-light rounded-pill px-4 fw-bold text-primary shadow">
                        <i class="fas fa-plus-circle me-1"></i> AJOUTER UN SERVICE
                    </a>
                </div>

                <div class="card-body p-0">
                    {{-- Alert Success stylisée --}}
                    @if (session('success'))
                        <div class="alert border-0 m-3 rounded-3 shadow-sm d-flex align-items-center"
                             style="background-color: #ecfdf5; color: #059669;">
                            <i class="fas fa-check-circle me-2 fs-5"></i>
                            <span class="fw-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #f8fafc;">
                                <tr class="text-uppercase small fw-black" style="letter-spacing: 1px; color: #64748b;">
                                    <th class="ps-4 py-3">ID</th>
                                    <th>Nom du Service</th>
                                    <th>Direction</th>
                                    <th>Responsable</th>
                                    <th class="text-center">Effectif</th>
                                    <th class="text-center pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold text-muted">#{{ $service->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bolder text-dark fs-6">{{ strtoupper($service->name) }}</div>
                                        </td>
                                        <td>
                                            @if($service->direction)
                                                <a href="{{ route('directions.show', $service->direction->id) }}"
                                                   class="badge bg-soft-primary text-primary text-decoration-none px-3 py-2 rounded-pill fw-bold"
                                                   style="background-color: #e0e7ff;">
                                                    <i class="fas fa-compass me-1"></i> {{ $service->direction->name }}
                                                </a>
                                            @else
                                                <span class="text-muted italic small">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->head)
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                        {{ substr($service->head->first_name, 0, 1) }}{{ substr($service->head->last_name, 0, 1) }}
                                                    </div>
                                                    <span class="fw-bold text-secondary">{{ $service->head->first_name }} {{ $service->head->last_name }}</span>
                                                </div>
                                            @else
                                                <span class="badge bg-light text-muted fw-normal">Non assigné</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-dark text-white rounded-pill px-3">
                                                {{ $service->agents->count() }} agents
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-white text-info border-end" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-white text-warning border-end" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-white text-danger" title="Supprimer"
                                                            onclick="return confirm('Supprimer ce service définitivement ?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Footer discret --}}
                <div class="card-footer bg-white border-0 py-3 text-center">
                    <small class="text-muted italic text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 2px;">
                        Direction de la Stratégie, des Études et des Statistiques Fiscales
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Effets de survol sur la table */
    .table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
        transition: all 0.2s ease;
    }
    /* Style des boutons du groupe d'action */
    .btn-white {
        background-color: #fff;
        border: none;
        padding: 8px 15px;
    }
    .btn-white:hover {
        background-color: #f8fafc;
        transform: scale(1.1);
    }
    .fw-black { font-weight: 900; }
</style>
@endsection
