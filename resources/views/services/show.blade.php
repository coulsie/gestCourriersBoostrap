@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            {{-- Card Principale avec effet Glassmorphism léger --}}
            <div class="card shadow-2xl border-0 rounded-5 overflow-hidden animate__animated animate__fadeInUp">

                {{-- Header Électrique --}}
                <div class="card-header p-5 text-center position-relative" style="background: linear-gradient(to right, #00dbde 0%, #fc00ff 100%);">
                    <div class="position-absolute top-0 start-0 p-3">
                        <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-bold shadow-sm">ID #{{ $service->id }}</span>
                    </div>
                    <div class="bg-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-layer-group fa-2x" style="background: -webkit-linear-gradient(#00dbde, #fc00ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <h1 class="display-5 fw-900 text-white text-uppercase mb-0" style="text-shadow: 2px 4px 10px rgba(0,0,0,0.2);">{{ $service->name }}</h1>
                    <p class="text-white opacity-75 fs-4 fw-bold mt-2">CODE : {{ $service->code }}</p>
                </div>

                <div class="card-body p-5 bg-white">
                    <div class="row g-4">
                        {{-- Bloc Description --}}
                        <div class="col-12">
                            <div class="p-4 rounded-4" style="background-color: #f8fafc; border-left: 6px solid #fc00ff;">
                                <h6 class="text-uppercase fw-black text-muted mb-2 small" style="letter-spacing: 2px;">
                                    <i class="fas fa-quote-left me-2 text-primary"></i>Missions & Description
                                </h6>
                                <p class="fs-5 text-dark mb-0 italic">{{ $service->description ?? 'Aucune description fournie pour ce service.' }}</p>
                            </div>
                        </div>

                        {{-- Bloc Direction --}}
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: #f0f4ff;">
                                <label class="fw-black text-primary small text-uppercase mb-2">Direction de rattachement</label>
                                @if($service->direction)
                                    <h5 class="fw-bold mb-1">{{ $service->direction->name }}</h5>
                                    <a href="{{ route('directions.show', $service->direction) }}" class="btn btn-sm btn-primary rounded-pill px-3 w-fit mt-2">
                                        <i class="fas fa-external-link-alt me-1"></i> Voir la Direction
                                    </a>
                                @else
                                    <p class="text-muted italic mb-0">Aucune direction parente.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Bloc Responsable --}}
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: #fff5f5;">
                                <label class="fw-black text-danger small text-uppercase mb-2">Responsable du Service</label>
                                @if($service->head)
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="avatar-circle bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <span class="fw-bold fs-5">{{ substr($service->head->last_name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0">{{ strtoupper($service->head->last_name) }}</h5>
                                            <span class="text-muted small">{{ $service->head->first_name }}</span>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-danger fw-bold italic mb-0"><i class="fas fa-exclamation-triangle me-1"></i> Poste non pourvu</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('services.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold p-0">
                            <i class="fas fa-chevron-left me-2"></i>RETOUR À LA LISTE
                        </a>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow-lg"
                           style="background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); border: none;">
                            <i class="fas fa-edit me-2"></i>MODIFIER LE SERVICE
                        </a>
                    </div>
                </div>

                {{-- Footer Stylisé --}}
                <div class="card-footer bg-light border-0 p-4">
                    <div class="row text-center text-md-start">
                        <div class="col-md-6 mb-2 mb-md-0 small text-muted">
                            <i class="far fa-calendar-plus me-1 text-info"></i> Créé le : <strong>{{ $service->created_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                        <div class="col-md-6 text-md-end small text-muted">
                            <i class="far fa-calendar-check me-1 text-success"></i> Dernière mise à jour : <strong>{{ $service->updated_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .fw-black { font-weight: 800; }
    .w-fit { width: fit-content; }

    .rounded-5 { border-radius: 2rem !important; }
    .rounded-4 { border-radius: 1rem !important; }

    .animate__animated { animation-duration: 0.8s; }

    /* Effet de survol sur le bouton modifier */
    .btn-lg:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(79, 172, 254, 0.5) !important;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-5px); }
</style>
@endsection
