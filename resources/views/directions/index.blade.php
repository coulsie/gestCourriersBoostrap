@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-2xl border-0 rounded-4 overflow-hidden">
                {{-- Header avec dégradé Vif & Éclatant --}}
                <div class="card-header p-4 d-flex align-items-center justify-content-between"
                     style="background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);">
                    <h4 class="m-0 text-white fw-900 text-uppercase" style="letter-spacing: 2px;">
                        <i class="fas fa-sitemap me-2"></i> Répertoire des Directions
                    </h4>
                    <a href="{{ route('directions.create') }}" class="btn btn-white rounded-pill px-4 fw-bold shadow-lg animate__animated animate__pulse animate__infinite">
                        <i class="fas fa-plus-circle me-1 text-danger"></i> AJOUTER UNE DIRECTION
                    </a>
                </div>

                <div class="card-body p-0 bg-white">
                    {{-- Message de succès stylisé --}}
                    @if (session('success'))
                        <div class="alert border-0 m-4 rounded-3 shadow-sm d-flex align-items-center"
                             style="background: #fff5f5; color: #ff0844; border-left: 5px solid #ff0844 !important;">
                            <i class="fas fa-check-circle me-3 fs-4"></i>
                            <span class="fw-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #fff5f5;">
                                <tr class="text-uppercase small fw-black" style="letter-spacing: 1px; color: #ff0844;">
                                    <th class="ps-4 py-4">ID</th>
                                    <th>Nom de la Direction</th>
                                    <th class="text-center">Code</th>
                                    <th>Responsable</th>
                                    <th class="text-center">Services</th>
                                    <th class="text-center pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($directions as $direction)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            <span class="badge bg-light text-dark rounded-pill px-3 shadow-sm border">#{{ $direction->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bolder text-dark fs-5">{{ strtoupper($direction->name) }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge shadow-sm px-3 py-2" style="background: #fff5f5; color: #ff0844; border: 1px dashed #ff0844;">
                                                {{ $direction->code ?? '---' }}
                                            </span>
                                        </td>
                                       <td>
                                            @if($direction->head)
                                                <div class="d-flex align-items-center">
                                                    {{-- Avatar avec l'initiale du NOM --}}
                                                    <div class="avatar-sm bg-gradient-danger rounded-circle text-white d-flex align-items-center justify-content-center me-2 shadow-sm"
                                                        style="width:35px; height:35px; background: linear-gradient(45deg, #ff0844, #ffb199); flex-shrink: 0;">
                                                        {{ strtoupper(substr($direction->head->last_name, 0, 1)) }}
                                                    </div>

                                                    {{-- Nom en gras et Prénom --}}
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                            {{ strtoupper($direction->head->last_name) }} {{ $direction->head->first_name }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted small italic">
                                                    <i class="fas fa-user-slash me-1"></i> Non assigné
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="position-relative d-inline-block">
                                                <button class="badge rounded-pill px-3 py-2 fs-6 shadow text-white border-0"
                                                        style="background: linear-gradient(45deg, #f59e0b, #ef4444); cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-toggle="modal"
                                                        data-bs-target="#modalServices{{ $direction->id }}"
                                                        data-target="#modalServices{{ $direction->id }}">
                                                    <i class="fas fa-layer-group me-1"></i>
                                                    <span class="fw-black">{{ $direction->services->count() }}</span>
                                                </button>

                                            </div>

                                            <!-- Modal spécifique à chaque direction -->
                                            <div class="modal fade" id="modalServices{{ $direction->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 rounded-4 shadow-lg">
                                                        <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);">
                                                            <h5 class="modal-title text-white fw-bold text-uppercase">
                                                                <i class="fas fa-list me-2"></i> Services : {{ $direction->name }}
                                                            </h5>

                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            @if($direction->services->count() > 0)
                                                                <ul class="list-group list-group-flush">
                                                                    @foreach($direction->services->sortBy('name') as $service)
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3 border-bottom">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                                                    <i class="fas fa-check text-danger small"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <span class="fw-bold text-dark d-block">{{ strtoupper($service->name) }}</span>
                                                                                    <small class="text-muted italic">Code: {{ $service->code ?? 'N/A' }}</small>
                                                                                </div>
                                                                            </div>
                                                                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">Voir</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <div class="text-center py-4">
                                                                    <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                                                                    <p class="text-muted fw-bold">Aucun service rattaché à cette direction.</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer border-0 p-3">
                                                           <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm" data-bs-dismiss="modal" data-dismiss="modal">
                                                                Fermer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>




                                        <td class="text-center pe-4">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('directions.show', $direction->id) }}" class="btn btn-action btn-info shadow-sm" title="Voir">
                                                    <i class="fas fa-eye text-white"></i>
                                                </a>
                                                <a href="{{ route('directions.edit', $direction->id) }}" class="btn btn-action btn-warning shadow-sm" title="Modifier">
                                                    <i class="fas fa-edit text-white"></i>
                                                </a>
                                                <form action="{{ route('directions.destroy', $direction->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-action btn-danger shadow-sm"
                                                            onclick="return confirm('Supprimer cette direction ?')" title="Supprimer">
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

                <div class="card-footer bg-white border-0 py-4 text-center">
                    <p class="text-muted small mb-0 text-uppercase fw-bold" style="letter-spacing: 3px;">
                        Département de la Stratégie et de l'Innovation - DSESF
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .fw-black { font-weight: 800; }

    /* Boutons ronds éclatants */
    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-action:hover {
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
    }

    .btn-white {
        background-color: white;
        color: #ff0844;
        border: none;
    }

    .btn-white:hover {
        background-color: #fff5f5;
        color: #d9043d;
    }

    /* Effets de ligne de tableau */
    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-hover tbody tr:hover {
        background-color: #fff9f9 !important;
    }

    .transition-all { transition: all 0.3s ease; }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(255, 8, 68, 0.15);
    }
</style>
@endsection
