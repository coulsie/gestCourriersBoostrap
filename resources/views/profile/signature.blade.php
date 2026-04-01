@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- 1. Affichage des erreurs de validation (Flash Rouge en haut) --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                <div>
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. Message de succès (Flash Vert) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <div class="fw-bold">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-pen-nib me-2"></i> MA SIGNATURE NUMÉRIQUE</span>
                    <a href="javascript:history.back()" class="btn-close btn-close-white" aria-label="Close"></a>
                </div>
                <div class="card-body text-center">

                    {{-- Affichage de la signature actuelle --}}
                    @if(auth()->user()->signature_path)
                        <div class="mb-4">
                            <h6 class="text-muted small text-uppercase fw-bold">Signature actuelle :</h6>
                            <img src="{{ asset('signatures/' . auth()->user()->signature_path) }}"
                                 class="border rounded p-2 bg-light shadow-sm" style="max-height: 100px;">
                        </div>
                    @endif

                    <form action="{{ route('profile.signature.update') }}" method="POST" id="signature-form" enctype="multipart/form-data">
                        @csrf

                        {{-- OPTION 1 : DESSIN --}}
                        <h6 class="fw-bold text-dark mb-3 text-start"><i class="fas fa-paint-brush me-2 text-primary"></i>Option 1 : Dessinez votre signature</h6>
                        <canvas id="signature-pad" class="border rounded bg-white mb-3 shadow-sm"
                             style="width: 100%; height: 300px; cursor: crosshair; touch-action: none; display: block;"></canvas>

                        <input type="hidden" name="signature_data" id="signature_data">

                        <div class="text-start mb-4">
                            <button type="button" id="clear" class="btn btn-sm btn-outline-danger shadow-sm">
                                <i class="fas fa-eraser me-1"></i> Effacer le dessin
                            </button>
                        </div>

                        <hr class="my-4">

                        {{-- OPTION 2 : SCAN --}}
                        <h6 class="fw-bold text-dark mb-3 text-start">
                            <i class="fas fa-upload me-2 text-primary"></i>Option 2 : Importez une signature scannée
                        </h6>

                        <div class="mb-4 text-start">
                            <input type="file" name="signature_file" id="signature_file"
                                class="form-control @error('signature_file') is-invalid @enderror"
                                accept="image/png, image/jpeg">

                            {{-- Rappel de l'erreur sous le champ également --}}
                            @error('signature_file')
                                <div class="invalid-feedback fw-bold small">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">Formats acceptés : PNG, JPG ou JPEG (Max 2Mo)</div>
                        </div>

                        <div class="d-flex justify-content-center gap-2 flex-wrap mt-5">
                           <a href="{{ route('home') }}" class="btn btn-danger px-4 shadow-sm">
                                <i class="fas fa-times me-1"></i> Fermer
                            </a>


                            <button type="submit" id="save" class="btn btn-success px-5 fw-bold shadow">
                                <i class="fas fa-save me-1"></i> Enregistrer la signature
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts JS --}}
<script src="{{ asset('js/signature_pad.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signature-pad');
    const fileInput = document.getElementById('signature_file');
    const signatureDataInput = document.getElementById('signature_data');

    if (typeof SignaturePad === 'undefined') {
        alert("Erreur : La bibliothèque de signature n'est pas chargée.");
        return;
    }

    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    document.getElementById('clear').addEventListener('click', function(e) {
        e.preventDefault();
        signaturePad.clear();
        signatureDataInput.value = "";
    });

    const form = document.getElementById('signature-form');
    form.addEventListener('submit', function (e) {
        const isPadEmpty = signaturePad.isEmpty();
        const isFileEmpty = fileInput.files.length === 0;

        if (isPadEmpty && isFileEmpty) {
            e.preventDefault();
            alert("Veuillez soit dessiner une signature, soit sélectionner un fichier.");
            return;
        }

        if (!isPadEmpty) {
            signatureDataInput.value = signaturePad.toDataURL();
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            signaturePad.clear();
        }
    });
});
</script>
@endsection
