@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">🗓️ Programmation Hebdomadaire</h1>
        <a href="{{ route('reunions.create') }}" class="btn btn-primary shadow-sm border-0">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Programmer une réunion
        </a>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                Semaine du {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m') }} au {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>Jour & Heure</th>
                            <th>Objet / Ordre du jour</th>
                            <th>Rôles Clés</th>
                            <th>Participants</th>
                            <th class="no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reunions as $reunion)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-info text-white px-3 py-2 mb-1">
                                    {{ \Carbon\Carbon::parse($reunion->date_heure)->translatedFormat('l d F') }}
                                </span>
                                <br>
                                <strong class="text-danger fs-5">
                                    {{ \Carbon\Carbon::parse($reunion->date_heure)->format('H:i') }}
                                </strong>
                            </td>
                            <td>
                                <h6 class="font-weight-bold mb-1 text-dark">{{ $reunion->objet }}</h6>
                                <small class="text-muted d-block text-truncate" style="max-width: 200px;" title="{{ $reunion->ordre_du_jour }}">
                                    {{ $reunion->ordre_du_jour ?? 'Aucun ordre du jour saisi.' }}
                                </small>
                            </td>
                            <td>
                                <div class="small">
                                    <div class="mb-1 text-nowrap">
                                        <i class="fas fa-microphone text-indigo me-1"></i>
                                        <strong>Animateur:</strong> {{ strtoupper($reunion->animateur->last_name) }} {{ $reunion->animateur->first_name }}
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="fas fa-pen-nib text-success me-1"></i>
                                        <strong>Rédacteur:</strong> {{ strtoupper($reunion->redacteur->last_name) }} {{ $reunion->redacteur->first_name }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{-- 1. Participants Internes (Agents) --}}
                                <div class="mb-1">
                                    @foreach($reunion->participants as $participant)
                                        <span class="badge bg-secondary text-white mb-1" title="Interne">
                                            <i class="fas fa-user-tie fa-xs me-1"></i>
                                            {{ strtoupper(substr($participant->last_name, 0, 1)) }}. {{ $participant->first_name }}
                                        </span>
                                    @endforeach
                                </div>

                                {{-- 2. Participants Externes (Décodage JSON) --}}
                                @if($reunion->externes)
                                    <div class="border-top pt-1 mt-1">
                                        @php
                                            // Sécurité : on décode le JSON en tableau si nécessaire
                                            $externes = is_string($reunion->externes) ? json_decode($reunion->externes, true) : $reunion->externes;
                                        @endphp
                                        @if(is_array($externes))
                                            @foreach($externes as $externe)
                                                <span class="badge bg-warning text-dark mb-1" title="Externe">
                                                    <i class="fas fa-external-link-alt fa-xs me-1"></i>{{ $externe }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="text-center no-print">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('reunions.show', $reunion->id) }}" class="btn btn-sm btn-outline-info" title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('reunions.edit', $reunion->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-light mb-3"></i>
                                <p class="text-muted fw-bold">Aucune réunion programmée pour cette semaine.</p>
                                <a href="{{ route('reunions.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                    <i class="fas fa-plus me-1"></i> Programmer maintenant
                                </a>
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
