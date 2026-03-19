<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiques</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts & Icons -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- LIEN COMPLET FONTAWESOME (Version 5.15.4 stable) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/welcome_style.css') }}" rel="stylesheet">

    <style>
        /* Fusion de l'icône avec le champ texte */
        .input-group-text {
            cursor: pointer;
            border-left: none;
            background-color: #fff !important;
            min-width: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #password {
            border-right: none;
        }

        /* FORCE LA VISIBILITÉ DE L'ICÔNE (Couleur noire) */
        #togglePassword i {
            color: #333 !important;
            font-size: 16px;
            visibility: visible !important;
            display: inline-block !important;
        }

        /* Correction pour l'affichage des erreurs Bootstrap */
        .is-invalid + .input-group-append .input-group-text {
            border-color: #e3342f;
        }
    </style>
</head>


    <body class="container-fluid" style>
        {{--<div class="container-fluid h-100" id="app" style="background: rgba(255, 255, 255, 0.2)">--}}
        <div class="container-fluid h-100" id="app">
            <div class="row" >
                <div class="col-md-7 text-white d-flex d-flex-column align-items-center justify-content-between h-100 left" id="intro">
                    {{--<div class="row h-100" style="background: rgba(251, 255, 251, 0.5)">--}}
                    <div class="row d-flex-column justify-content-between align-items-center">
                        <div class="marge-gauche-20">
                            <<div style="text-align: center; padding: 20px;">
                                <img class="logo" src="{{asset('images/ArmoiriePlus-removebg-preview.png')}}"
                                    alt="Description de l'image"
                                    style="width: 50%; max-width: 400px; height: auto; display: block; margin: 0 auto;">
                            </div>
                            <hr>
                            <p class="marge-gauche-20">
                                <h5 class="col-md-12"><span class="text-white small">{{__('DSESF ')}}</span></h5>
                                <h3 class="col-md-12"><strong class="text-orange small">{{__('Direction de la Strategie, des Etudes et Statistiques Fiscales de la DGI')}}</strong> <div class="text-italique"> {{__('Suivi et Exécution des Tâches')}} </div></h3>
                            </p>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>

                <div class="col-md-5 right" >
                    {{--<div class="d-flex flex-column justify-content-center h-100" id="header" >--}}
                    <div class="d-flex justify-content-center h-100 " id="header" >


                        <div class="col-md-12 row ">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 ">

                                <h6 class="display-6" >

                                    <div class="form-group col-md-12">

                                        <p class="text-center ">
                                                {{--<img class="logo" src="{{asset('img/Edr2.jpg')}}" alt="" width="350px">--}}
                                                {{-- <img class="logo" src="{{asset('images/logo-MFP.png')}}" alt="" width="180px"> --}}
                                                <img class="logo" src="{{asset('images/DGI.png')}}" alt="" width="180px">
                                        </p>

                                       {{--
                                        <label for="">{{__('lang.libelleLang')}}</label>
                                        <select class="form-control col-md-12" name="laLangue" id="laLangue">
                                            <option value="fr" {{(session('locale') && session('locale')==='fr')?'selected':''}}><a href="{{route('changeLangue','fr')}}">{{__('lang.langFr')}}</a></option>
                                            <option value="en" {{(session('locale') && session('locale')==='en')?'selected':''}}><a href="{{route('changeLangue','en')}}">{{__('lang.langEn')}}</a></option>
                                        </select>
                                        --}}
                                    </div>
                                    <div class="form-group col-md-12">
                                            <hr>
                                    </div>
                                </h6>
                                <h3 class="form-group text-center">{{__('Login')}}</h3>
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p> <small>{{ $message }}</small></p>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}" class="shadow-lg p-3 mb-5 bg-white rounded">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email" class="col-md-12 col-form-label">{{ __('email') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-12 col-form-label">{{ __('password') }}</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required style="border-right: none;">

                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-white" id="togglePassword" style="cursor: pointer; border-left: none; min-width: 45px;">
                                                        <!-- SVG de l'oeil (Noir, Toujours visible) -->
                                                        <svg id="eyeIcon" xmlns="http://www.w3.org" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.827 8c-.05.088-.112.187-.19.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="col-md-12 o ffset-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('remenber') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-sm form-control couleur-orange">
                                            {{--<button type="submit" class="btn btn-sm form-control bg-success text-white">--}}
                                                {{ __('login') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link text-danger" href="{{ route('password.request') }}">
                                                    {{ __('Mot de passe oublie') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net"></script>

<script>
    $(document).ready(function() {
        // --- GESTION DE L'OEIL (MOT DE PASSE) ---
        $(document).on('click', '#togglePassword', function(e) {
            e.preventDefault();
            const passwordField = $("#password");
            const container = $(this);

            // Définition des deux icônes SVG
            const eyeOpen = '<svg xmlns="http://www.w3.org" width="18" height="18" fill="#333" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.827 8c-.05.088-.112.187-.19.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>';
            const eyeClosed = '<svg xmlns="http://www.w3.org" width="18" height="18" fill="#333" viewBox="0 0 16 16"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755l.691.695zM10.117 8l.958.958c.073-.133.118-.28.118-.438 0-1.04-.84-1.88-1.88-1.88-.158 0-.305.045-.438.118L10.117 8zM7.5 5.5a.5.5 0 0 1 .5.5v.117l.5.5V6a1.5 1.5 0 0 0-1.5-1.5H7.5v1zM6.025 7.5l.496.496A1.494 1.494 0 0 1 6 8c0 .83.67 1.5 1.5 1.5.174 0 .333-.03.48-.08l.5.5A2.497 2.497 0 0 1 7.5 10.5a2.5 2.5 0 0 1-2.5-2.5c0-.188.021-.368.06-.541l.965.965z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.828 2.829l.823.822zm-4.12 1.351L9.176 12.527a6.99 6.99 0 0 1-1.176.14c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8c.06-.086.124-.181.198-.284.341-.476.84-1.107 1.472-1.734l.706.706c-.603.582-1.07 1.185-1.385 1.63a11.234 11.234 0 0 0 1.552 2.123C4.121 11.332 5.881 12.5 8 12.5c.346 0 .685-.031 1.012-.09l-.835-.835zm1.517 1.517l.742.742A7.145 7.145 0 0 1 8 13c-5 0-8-5.5-8-5.5a7.029 7.029 0 0 1 1.537-1.895l.708.708A5.958 5.958 0 0 0 1.172 8c.046.078.108.175.188.285.34.481.846 1.122 1.5 1.765C4.121 11.332 5.881 12.5 8 12.5c.441 0 .868-.051 1.275-.148L7.383 10.977l-.853-.853z"/><path d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/></svg>';

            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
                container.html(eyeClosed);
            } else {
                passwordField.attr("type", "password");
                container.html(eyeOpen);
            }
        });

        // --- GESTION DE LA LANGUE ---
        $("select#laLangue").change(function(){
            var selectedCountry = $(this).val();
            window.location.href = "{{URL('/changeLangue')}}/" + selectedCountry;
        });
    });
</script>

<style>
    .input-group-text {
        background-color: #fff !important;
        border-left: none !important;
        cursor: pointer;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 46px;
    }
    #password {
        border-right: none !important;
    }
    #password.is-invalid + .input-group-append .input-group-text {
        border-color: #dc3545 !important;
    }
    /* Empêche le SVG d'être invisible */
    svg {
        display: inline-block !important;
        visibility: visible !important;
    }
</style>


    </body>
</html>
