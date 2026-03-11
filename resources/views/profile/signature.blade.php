@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-pen-nib me-2"></i> MA SIGNATURE NUMÉRIQUE
                </div>
                <div class="card-body text-center">

                    {{-- Affichage de la signature actuelle --}}
                    @if(auth()->user()->signature_path)
                        <div class="mb-4">
                            <h6 class="text-muted small text-uppercase fw-bold">Signature actuelle :</h6>
                            <img src="{{ asset('signatures/' . auth()->user()->signature_path) }}"
     class="border rounded p-2 bg-light" style="max-height: 100px;">
                        </div>
                    @endif


                    <form action="{{ route('profile.signature.update') }}" method="POST" id="signature-form">
                        @csrf
                        <h6 class="fw-bold text-dark mb-3">Dessinez votre nouvelle signature ci-dessous :</h6>

                        <canvas id="signature-pad" class="border rounded bg-white mb-3"
                             style="width: 100%; height: 300px; cursor: crosshair; touch-action: none; display: block;"></canvas>

                        <input type="hidden" name="signature_data" id="signature_data">

                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" id="clear" class="btn btn-outline-danger px-4">
                                <i class="fas fa-eraser me-1"></i> Effacer
                            </button>
                            <button type="submit" id="save" class="btn btn-success px-5 fw-bold">
                                <i class="fas fa-save me-1"></i> Enregistrer la signature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Charge le fichier que vous venez de créer localement --}}
<script src="{{ asset('js/signature_pad.js') }}"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signature-pad');

    // Initialisation avec vérification
    if (typeof SignaturePad === 'undefined') {
        alert("Erreur : La bibliothèque de signature n'est pas chargée. Vérifiez votre connexion internet.");
        return;
    }

    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    // FONCTION VITALE : Ajuster la taille interne du canvas au démarrage
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear(); // Important pour réinitialiser le tampon interne
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas(); // Appel immédiat

    // BOUTON EFFACER
    document.getElementById('clear').addEventListener('click', function(e) {
        e.preventDefault();
        signaturePad.clear();
    });

    // BOUTON ENREGISTRER (Soumission du formulaire)
    const form = document.getElementById('signature-form');
    form.addEventListener('submit', function (e) {
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert("Veuillez dessiner votre signature avant d'enregistrer.");
        } else {
            // On met l'image Base64 dans le champ caché avant d'envoyer
            const dataURL = signaturePad.toDataURL();
            document.getElementById('signature_data').value = dataURL;
        }
    });
});
</script>
@endsection
