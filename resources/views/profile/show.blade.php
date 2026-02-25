@extends('layouts.app')

@section('content')
<div class="container-fluid">

            <!-- Bloc d'affichage des messages de succès -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-left-success" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>Succès !</strong> {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Bloc d'affichage des erreurs de validation (ex: mauvais mot de passe actuel) -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-left-danger" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Erreur !</strong> Veuillez vérifier les formulaires.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


    <!-- En-tête de page -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mon Profil Utilisateur</h1>

        <a href="{{ route('home') }}" class="btn btn-secondary shadow-sm font-weight-bold">
            <i class="fas fa-times mr-1"></i> Fermer et Quitter
        </a>

    </div>

    <div class="row">

        <!-- Carte de Profil Gauche -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-bottom-primary">
                <div class="card-body text-center">
                    <div class="mb-4 text-center">
                        @if(isset($user->agent) && $user->agent->photo)
                            <img class="img-profile rounded-circle shadow object-fit-cover"
                                src="{{ asset('agents_photos/' . $user->agent->photo) }}?v={{ time() }}"
                                style="width: 128px; height: 128px; border: 3px solid #4e73df;">
                        @else
                            <img class="img-profile rounded-circle shadow"
                               src="https://ui-avatars.com{{ urlencode($user->name) }}&background=4e73df&color=fff&size=128&bold=true"
                                style="width: 128px; height: 128px;">
                        @endif
                    </div>

                    <h4 class="font-weight-bold text-gray-800">{{ $user->name }}</h4>
                    <p class="text-primary small font-weight-bold mb-3">{{ $user->email }}</p>

                    <hr>

                    <div class="text-left px-3">
                        <h6 class="font-weight-bold text-dark">Ma Biographie :</h6>
                        <p class="text-gray-600 italic">
                            {{ $user->bio ?? "Aucune biographie renseignée." }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte des Détails Droite -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Détails du compte (DSESF 2026)</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="small mb-1 text-gray-500 font-weight-bold">Identifiant système (#ID)</label>
                            <div class="h6 text-gray-900">{{ $user->id }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1 text-gray-500 font-weight-bold">Date d'inscription</label>
                            <div class="h6 text-gray-900">{{ $user->created_at->format('d F Y') }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="small mb-1 text-gray-500 font-weight-bold">Adresse Email</label>
                            <div class="h6 text-gray-900">{{ $user->email }}</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="font-weight-bold text-danger mb-3">
                        <i class="fas fa-user-shield mr-2"></i>Paramètres de sécurité
                    </h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1 text-gray-500 font-weight-bold">Dernière mise à jour du mot de passe</label>
                            <div class="text-gray-900">
                                @if($user->password_changed_at)
                                    <span class="badge badge-light p-2 border">
                                        {{ \Carbon\Carbon::parse($user->password_changed_at)->diffForHumans() }}
                                    </span>
                                @else
                                    <span class="badge badge-warning">Action requise</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1 text-gray-500 font-weight-bold">État du compte</label>
                            <div>
                                @if($user->must_change_password)
                                    <span class="badge badge-danger px-3 py-2">Changement obligatoire</span>
                                @else
                                    <span class="badge badge-success px-3 py-2">Sécurisé</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button class="btn btn-primary shadow-sm" type="button"
                                data-toggle="modal" data-target="#editProfileModal">
                            <i class="fas fa-user-edit fa-sm text-white-50 mr-1"></i> Modifier mes infos
                        </button>

                        <button class="btn btn-dark shadow-sm ml-2" type="button"
                                data-toggle="modal" data-target="#passwordModal">
                            <i class="fas fa-lock fa-sm text-white-50 mr-1"></i> Modifier le mot de passe
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de changement de mot de passe -->
<!-- Modal de changement de mot de passe -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel text-dark font-weight-bold">
                    <i class="fas fa-key mr-2"></i>Changer le mot de passe
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

           <!-- Modal de changement de mot de passe -->
            <!-- 1. Changez l'action pour le nouveau nom de route -->
            <form action="{{ route('user.password.custom.update') }}" method="POST">
                @csrf

                {{-- 2. SUPPRIMEZ TOTALEMENT LA LIGNE @method('PUT') CI-DESSOUS --}}
                {{-- @method('PUT') --}}

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal de modification des infos -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary">Modifier mes informations</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH') {{-- PATCH est standard pour une mise à jour partielle --}}
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Nom complet</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Adresse Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Biographie</label>
                        <textarea name="bio" class="form-control" rows="3">{{ $user->bio }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary shadow-sm">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->has('current_password') || $errors->has('password'))
    <script>
        $(document).ready(function() {
            $('#passwordModal').modal('show');
        });
    </script>
@endif

@endsection
