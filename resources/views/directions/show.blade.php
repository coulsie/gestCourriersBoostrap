@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            {{-- Card Principale avec Ombre Royale --}}
            <div class="card shadow-2xl border-0 rounded-5 overflow-hidden animate__animated animate__fadeIn">

                {{-- Header Éclatant --}}
                <div class="card-header p-5 text-center position-relative" style="background: linear-gradient(90deg, #ff8c00 0%, #ff4500 100%);">
                    <div class="position-absolute top-0 start-0 p-3">
                        <span class="badge bg-white text-danger rounded-pill px-3 py-2 fw-bold shadow-sm">DIRECTION</span>
                    </div>

                    <div class="bg-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                        <i class="fas fa-sitemap fa-3x" style="color: #ff4500;"></i>
                    </div>

                    <h1 class="display-4 fw-900 text-white text-uppercase mb-0" style="text-shadow: 2px 4px 10px rgba(0,0,0,0.2);">
                        {{ $direction->name }}
                    </h1>
                    <div class="d-inline-block mt-3 px-4 py-2 rounded-pill" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(5px);">
                        <span class="text-white fw-bold fs-5">CODE : {{ $direction->code ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="card-body p-5 bg-white">
                    <div class="row g-4">
                        {{-- Section Description --}}
                        <div class="col-12">
                            <div class="p-4 rounded-4" style="background-color: #fff9f5; border-left: 6px solid #ff8c00;">
                                <h6 class="text-uppercase fw-black text-warning mb-3 small" style="letter-spacing: 2px;">
                                    <i class="fas fa-info-circle me-2"></i>Missions Stratégiques
                                </h6>
                                <p class="fs-5 text-dark mb-0 leading-relaxed">
                                    {{ $direction->description ?? 'Cette direction n’a pas encore de description officielle enregistrée.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Section Responsable (Focus Visuel) --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(to right, #ffffff, #fff5f2);">
                                <h6 class="text-uppercase fw-black text-danger mb-4 small" style="letter-spacing: 2px;">
                                    <i class="fas fa-user-shield me-2"></i>Responsable de Direction (Head)
                                </h6>
                                @if($direction->head)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg rounded-circle d-flex align-items-center justify-content-center text-white shadow-lg"
                                             style="width: 70px; height: 70px; background: linear-gradient(45deg, #ff4500, #ff8c00);">
                                            <span class="fs-2 fw-bold">{{ strtoupper(substr($direction->head->last_name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ms-4">
                                            <h3 class="fw-bold text-dark mb-0">{{ strtoupper($direction->head->last_name) }} {{ $direction->head->first_name }}</h3>
                                            <span class="badge bg-soft-danger text-danger px-3 py-1 rounded-pill mt-1">Directeur / Responsable</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-light border-dashed text-center py-4 rounded-4">
                                        <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                                        <p class="text-muted fw-bold mb-0">Aucun responsable n'est actuellement assigné à cette direction.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('directions.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold p-0 transition-all">
                            <i class="fas fa-arrow-left me-2"></i>RETOUR À LA LISTE
                        </a>
                        <a href="{{ route('directions.edit', $direction) }}" class="btn btn-lg rounded-pill px-5 text-white fw-900 shadow-xl"
                           style="background: linear-gradient(90deg, #ff8c00 0%, #ff4500 100%); border: none;">
                            <i class="fas fa-edit me-2"></i>MODIFIER LA DIRECTION
                        </a>
                    </div>
                </div>

                {{-- Footer Temporel --}}
                <div class="card-footer bg-light border-0 p-4">
                    <div class="row text-center text-md-start">
                        <div class="col-md-6 mb-2 mb-md-0 small text-muted font-monospace">
                            <i class="far fa-clock me-1 text-warning"></i> CRÉÉ LE : {{ $direction->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6 text-md-end small text-muted font-monospace">
                            <i class="fas fa-sync-alt me-1 text-danger"></i> MAJ LE : {{ $direction->updated_at->format('d/m/Y H:i') }}
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
    .rounded-5 { border-radius: 2.5rem !important; }
    .rounded-4 { border-radius: 1.5rem !important; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(255, 69, 0, 0.25) !important; }

    /* Animation au survol */
    .transition-all:hover {
        transform: translateX(-5px);
        color: #ff4500 !important;
    }

    .btn-lg:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(255, 69, 0, 0.4) !important;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
</style>
@endsection
