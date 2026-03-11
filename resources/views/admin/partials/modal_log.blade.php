


<div class="modal fade" id="modalLog{{ $log->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-history me-2"></i>Détails de l'Action #{{ $log->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- ÉTAT PRÉCÉDENT --}}
                    <div class="col-md-6 border-end">
                        <h6 class="fw-bold text-danger small text-uppercase border-bottom pb-2">
                            <i class="fas fa-arrow-left me-1"></i> État Précédent
                        </h6>
                        @if($log->old_values && $log->old_values !== 'null')
                            <pre class="bg-light p-3 rounded border small text-danger" style="max-height: 300px; overflow-y: auto; font-family: monospace;">@php
                                    $old = is_string($log->old_values) ? json_decode($log->old_values, true) : $log->old_values;
                                    echo json_encode($old, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                                @endphp</pre>
                        @else
                            <div class="alert alert-light border text-center py-4">
                                <small class="text-muted fst-italic">Aucune donnée précédente</small>
                            </div>
                        @endif
                    </div>

                    {{-- NOUVEL ÉTAT --}}
                    <div class="col-md-6">
                        <h6 class="fw-bold text-success small text-uppercase border-bottom pb-2">
                            <i class="fas fa-arrow-right me-1"></i> Nouvel État
                        </h6>
                        @if($log->new_values && $log->new_values !== 'null')
                            <pre class="bg-light p-3 rounded border small text-success" style="max-height: 300px; overflow-y: auto; font-family: monospace;">@php
                                    $new = is_string($log->new_values) ? json_decode($log->new_values, true) : $log->new_values;
                                    echo json_encode($new, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                                @endphp</pre>
                        @else
                            <div class="alert alert-light border text-center py-4">
                                <small class="text-muted fst-italic text-danger">Donnée supprimée ou vide</small>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- INFOS TECHNIQUES --}}
                <div class="mt-3 p-2 bg-light rounded border">
                    <div class="row small text-muted">
                        <div class="col-md-6"><strong>IP:</strong> {{ $log->ip_address }}</div>
                        <div class="col-md-6 text-md-end"><strong>Date:</strong> {{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
         <button type="button" class="btn btn-secondary btn-sm fw-bold px-4"
                onclick="
                    const m = this.closest('.modal');
                    m.classList.remove('show');
                    m.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    document.body.style = '';
                    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                ">
            Fermer
        </button>

        </div>
    </div>
</div>
