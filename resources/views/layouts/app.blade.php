<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>e-COURRIER - 2026</title>

    <!-- Fonts & Icons -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- À mettre entre <head> et </head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net">


    <style>
    /* 1. Configuration de la Sidebar et de l'ascenseur */
    #accordionSidebar {
        max-height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        position: sticky;
        top: 0;
        width: 18rem !important; /* Largeur confortable */
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.2) transparent;
    }

    /* 2. AUTORISER LE RETOUR À LA LIGNE POUR LES TEXTES LONGS */
    .sidebar .nav-item .collapse .collapse-inner .collapse-item {
        white-space: normal !important; /* Permet le retour à la ligne */
        word-wrap: break-word;        /* Casse les mots si nécessaire */
        line-height: 1.2;              /* Espace réduit entre les lignes */
        padding: 0.6rem 0.7rem !important; /* Un peu d'air autour du texte */
        display: block;                /* Assure que le lien prend toute la largeur */
        margin-bottom: 2px;
        font-size: 0.82rem;            /* Taille de police optimale */
    }

    /* 3. Style de l'ascenseur (Chrome/Safari) */
    #accordionSidebar::-webkit-scrollbar {
        width: 5px;
    }
    #accordionSidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    /* Ajustement de la largeur responsive */
    @media (min-width: 768px) {
        .sidebar {
            width: 18rem !important;
        }
    }
</style>


    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>

</head>


<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <div class="sidebar-brand-text mx-3">e-DSESF</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de Bord</span>
                </a>
            </li>

            <hr class="sidebar-divider">

        <!-- SECTION ADMINISTRATION : Réservée aux Admins (ORANGE ÉLECTRIQUE) -->
        @hasanyrole('admin|Superviseur|utilisateur')

            <hr class="sidebar-divider" style="border-top: 2px solid #ff9f43; opacity: 0.2;">
            <div class="sidebar-heading fw-bold" style="color: #ff9f43; letter-spacing: 1px;">
                <i class="fas fa-tools me-1"></i> ADMINISTRATION & CONSULTATION
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true">
                    <i class="fas fa-fw fa-shield-alt" style="color: #ff9f43;"></i>
                    <span style="color: #ff9f43; font-weight: 800;">CONTRÔLE & RH</span>
                </a>
                <div id="collapseAdmin" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded shadow-lg" style="border-left: 5px solid #ff9f43; border-right: 1px solid #fff3e0;">

                        {{-- 1. LIEN MA SIGNATURE (Visible par admin, superviseur et utilisateur) --}}
                        <a class="collapse-item fw-bold text-dark transition-hover {{ request()->routeIs('profile.signature.*') ? 'bg-light' : '' }}"
                            href="{{ route('profile.signature.edit') }}">
                            <i class="fas fa-pen-fancy me-2" style="color: #6610f2;"></i> Ma Signature
                        </a>

                        @hasanyrole('admin|Superviseur')
                            <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #ee5253;">
                                <i class="fas fa-user-shield me-1"></i> GESTION SYSTÈME
                            </h6>


                            {{-- LISTE UTILISATEURS --}}
                            <a class="collapse-item fw-bold text-dark transition-hover" href="{{ route('users.index') }}">
                                <i class="fas fa-users-cog me-2" style="color: #ff9f43;"></i> Liste Utilisateurs
                            </a>

                            {{-- SUIVI DES INTÉRIMS (Ambre) --}}
                            <a class="collapse-item fw-bold text-dark transition-hover {{ request()->routeIs('interims.index') ? 'bg-light' : '' }}" href="{{ route('interims.index') }}">
                                <i class="fas fa-user-shield me-2" style="color: #f6993f;"></i> Suivi des Intérims
                            </a>

                            {{-- BOUTON CRÉER INTÉRIM (Vert Émeraude) --}}
                            <a class="collapse-item fw-bold text-white shadow-sm rounded mx-2 my-1 d-flex align-items-center justify-content-center"
                            href="{{ route('interims.create') }}"
                            style="background-color: #10b981; height: 35px; border-bottom: 3px solid #059669; text-decoration: none;">
                                <i class="fas fa-plus-circle me-2"></i> NOUVEL INTÉRIM
                            </a>

                            <a class="collapse-item fw-bold text-dark" href="{{ route('admin.logs.index') }}">
                                <i class="fas fa-fingerprint me-2" style="color: #ff9f43;"></i> Journal Événements
                            </a>

                            <a class="collapse-item fw-bold text-dark" href="{{ route('roles.index') }}">
                                <i class="fas fa-user-lock me-2" style="color: #ff9f43;"></i> Gestion des Rôles
                            </a>

                            {{-- BOUTON COFFRE FORT (CRIMSON ÉCLATANT) --}}
                            <a class="collapse-item fw-bold text-white shadow-sm rounded mx-2 my-2 d-flex align-items-center justify-content-center"
                            href="{{ route('admin.coffre-fort') }}" style="background-color: #ee5253; height: 35px; text-decoration: none;">
                                <i class="fas fa-vault me-2"></i> COFFRE FORT
                            </a>

                            <div class="px-3 py-1">
                                <a class="collapse-item fw-bold small text-indigo p-0" href="{{ route('agents.nouveau') }}"><i class="fas fa-plus-circle me-1"></i> Nouveau Compte</a>
                                <a class="collapse-item fw-bold small text-success p-0" href="{{ route('agents.index') }}"><i class="fas fa-user-tie me-1"></i> Ressources Humaines</a>

                                <!-- AJOUT DU SUIVI DES RÉUNIONS ICI -->
                                <a class="collapse-item fw-bold small text-primary p-0" href="{{ route('reunions.hebdo') }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Suivi des Réunions
                                </a>

                                <a class="collapse-item fw-bold small text-secondary p-0" href="{{ route('extraction.index') }}"><i class="fas fa-download me-1"></i> Extraction</a>
                            </div>

                        @endhasanyrole

                        {{-- BLOC CONSULTATION --}}
                        <div class="dropdown-divider" style="border-top: 2px solid #ff9f43; opacity: 0.15;"></div>
                        <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #6c5ce7;">
                            <i class="fas fa-search me-1"></i> CONSULTATION
                        </h6>
                        <a class="collapse-item fw-bold text-white shadow-sm rounded mx-2 mb-1" href="{{ route('agents.par.service') }}" style="background-color: #6c5ce7; text-decoration: none;">
                            <i class="fas fa-building me-2"></i> Agents par Service
                        </a>

                        @hasanyrole('admin|Superviseur')
                            <a class="collapse-item fw-bold text-indigo" href="{{ route('agents.par.service.recherche') }}">
                                <i class="fas fa-user-search me-2"></i> Recherche Agents
                            </a>

                            {{-- ANALYSES --}}
                            <div class="dropdown-divider" style="border-top: 2px solid #ff9f43; opacity: 0.15;"></div>
                            <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #e67e22;">
                                <i class="fas fa-chart-line me-1"></i> ANALYSES
                            </h6>
                            <a class="collapse-item fw-bold" style="color: #e67e22;" href="{{ route('statistiques.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard Stats
                            </a>
                            <a class="collapse-item fw-bold text-muted" href="{{ route('typeabsences.index') }}">
                                <i class="fas fa-cog me-2"></i> Paramétrage Absence
                            </a>
                        @endhasanyrole
                    </div>
                </div>
            </li>
        @endhasanyrole

        <hr class="sidebar-divider">

                            <!-- SECTION COURRIERS : OPÉRATIONS (CYAN ÉCLATANT) -->
            <div class="sidebar-heading text-cyan fw-bolder" style="color: #00e5ff !important; letter-spacing: 1px;">
                <i class="fas fa-rocket me-1"></i> OPÉRATIONS
            </div>

            <li class="nav-item {{ request()->routeIs('courriers.*', 'imputations.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourriers" aria-expanded="true">
                    <i class="fas fa-fw fa-envelope-open-text" style="color: #00e5ff;"></i>
                    <span style="color: #00e5ff; font-weight: 800;">GESTION COURRIERS</span>
                </a>
                <div id="collapseCourriers" class="collapse {{ request()->routeIs('courriers.*', 'imputations.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                    <!-- Menu avec Bordure dégradée (via CSS inline) et ombre néon -->
                    <div class="bg-white py-2 collapse-inner rounded shadow-lg" style="border-left: 5px solid #00e5ff; border-right: 1px solid #00e5ff;">

                        {{-- ACTIONS DE GESTION : VIOLET / ROSE ÉCLATANT --}}
                        @hasanyrole('admin|editeur|rh|Superviseur')
                            <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #d63384;">
                                <i class="fas fa-tools me-1"></i> TRAITEMENT
                            </h6>
                            <a class="collapse-item fw-bold text-dark mb-1 transition-hover" href="{{ route('courriers.index') }}">
                                <i class="fas fa-list-ul me-2" style="color: #6610f2;"></i> Enregistrement
                            </a>
                            <a class="collapse-item fw-bold text-white bg-success rounded mx-2 mb-1 shadow-sm" href="{{ route('courriers.create') }}">
                                <i class="fas fa-plus-circle me-1"></i> Créer un courrier
                            </a>
                            <a class="collapse-item fw-bold" style="color: #fd7e14;" href="{{ route('courriers.archives') }}">
                                <i class="fas fa-archive me-2"></i> Archives
                            </a>
                            <a class="collapse-item fw-bold text-info" href="{{ route('imputations.index') }}">
                                <i class="fas fa-share-square me-2"></i> Toutes les Imputations
                            </a>
                        @endhasanyrole

                        {{-- ACTIONS UTILISATEUR : INDIGO ÉCLATANT --}}
                        <div class="dropdown-divider" style="border-top: 2px solid #00e5ff; opacity: 0.2;"></div>
                        <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #6f42c1;">
                            <i class="fas fa-fingerprint me-1"></i> MON ESPACE
                        </h6>
                        <a class="collapse-item fw-bold text-indigo" href="{{ route('imputations.mes_imputations') }}" style="background-color: #f8f0ff;">
                            <i class="fas fa-thumbtack me-2"></i> Mes imputations
                        </a>
                        <a class="collapse-item fw-bold text-primary" href="{{ route('courriers.RechercheAffichage') }}">
                            <i class="fas fa-search-plus me-2"></i> Recherche avancée
                        </a>

                        {{-- STATISTIQUES : ORANGE / AMBRE --}}
                        @hasanyrole('admin|Superviseur|rh')
                            <div class="dropdown-divider" style="border-top: 2px solid #00e5ff; opacity: 0.2;"></div>
                            <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #fd7e14;">
                                <i class="fas fa-chart-line me-1"></i> ANALYSES
                            </h6>
                            <a class="collapse-item fw-bold" style="color: #20c997;" href="{{ route('statistiques.index') }}">
                                <i class="fas fa-chart-bar me-2"></i> Statistiques
                            </a>
                            <a class="collapse-item fw-bold" style="color: #0dcaf0;" href="{{ route('statistiques.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard Global
                            </a>
                        @endhasanyrole
                    </div>
                </div>
            </li>


                    <!-- NOUVELLE SECTION : GESTION DES PRÉSENCES (VERT EMERAUDE ÉCLATANT) -->
            <li class="nav-item {{ request()->routeIs('presences.*', 'absences.*', 'typeabsences.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePresences" aria-expanded="true">
                    <i class="fas fa-fw fa-user-check" style="color: #2ed573;"></i>
                    <span style="color: #2ed573; font-weight: 800;">GESTION PRÉSENCES</span>
                </a>
                <div id="collapsePresences" class="collapse {{ request()->routeIs('presences.*', 'absences.*', 'typeabsences.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                    <!-- Menu avec Bordure Épaisse Emeraude et Ombre Douce -->
                    <div class="bg-white py-2 collapse-inner rounded shadow-lg" style="border-left: 5px solid #2ed573; border-right: 1px solid #e1f5fe;">

                        {{-- ACCÈS PERSONNEL : VERT MENTHE --}}
                        <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #1abc9c;">
                            <i class="fas fa-user-tag me-1"></i> MON ESPACE
                        </h6>
                        <a class="collapse-item fw-bold text-white shadow-sm rounded mx-2 mb-1" href="{{ route('presences.monPointage') }}" style="background: linear-gradient(45deg, #2ed573, #7bed9f);">
                            <i class="fas fa-fingerprint me-2"></i> Marquer Présence
                        </a>
                        <a class="collapse-item text-dark fw-bold transition-hover" href="{{ route('presences.monHistorique') }}">
                            <i class="fas fa-history me-2" style="color: #2ed573;"></i> Mon Historique
                        </a>


                        <a class="collapse-item text-dark fw-bold" href="{{ route('absences.indexAutorisation') }}">
                            <i class="fas fa-calendar-check me-2" style="color: #ffa502;"></i> Mes demandes de Congés & Permissions
                        </a>

                        {{-- ACCÈS CONTRÔLE ET RH : AMBRE & VERT SOMBRE --}}
                        @hasanyrole('admin|rh|Superviseur')
                            <div class="dropdown-divider" style="border-top: 2px solid #2ed573; opacity: 0.15;"></div>
                            <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #2f3542;">
                                <i class="fas fa-user-shield me-1"></i> CONTRÔLE & RH
                            </h6>

                            <a class="collapse-item text-secondary fw-bold" href="{{ route('holidays.index') }}">
                                <i class="fas fa-umbrella-beach me-2"></i>Jours fériés
                            </a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('presences.index') }}">
                                <i class="fas fa-stopwatch me-2"></i>Enregistrement pointage
                            </a>

                            <a class="collapse-item text-secondary fw-bold" href="{{ route('chef.absences.index') }}">
                                <i class="fas fa-check-double me-2"></i>Validation Absences.
                            </a>


                            <div class="dropdown-divider" style="border-top: 1px dashed #2ed573; opacity: 0.2;"></div>

                            <a class="collapse-item text-muted fw-bold small" href="{{ route('typeabsences.index') }}">Types d'Autorisations</a>
                            <a class="collapse-item text-muted fw-bold small" href="{{ route('absences.index') }}">Liste des Autorisations d'absence</a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('absences.createListe') }}">
                                <i class="fas fa-users-cog me-2"></i>Demande Autorisation d'Absence Groupée
                            </a>
                            <a class="collapse-item fw-bold text-white shadow-sm rounded mx-2 mt-1" href="{{ route('absences.validation_liste') }}" style="background-color: #ffa502;">
                                <i class="fas fa-tasks me-2"></i> Validation Autorisation d'Absence
                            </a>
                            <a class="collapse-item fw-bold text-white shadow-sm rounded mx-2 mt-1"
                                href="{{ route('presences.validation-hebdo') }}"
                                style="background-color: #27ae60;">
                                <i class="fas fa-tasks me-2"></i> Validation hebdomadaire de présences
                            </a>



                            {{-- RAPPORTS : BLEU NUIT --}}
                            <div class="dropdown-divider" style="border-top: 2px solid #2ed573; opacity: 0.15;"></div>
                            <h6 class="collapse-header fw-bold border-bottom pb-1 mx-2 mb-2" style="color: #1e3799;">
                                <i class="fas fa-file-signature me-1"></i> RAPPORTS
                            </h6>

                            <a class="collapse-item text-secondary fw-bold" href="{{ route('presences.listeFiltree') }}">
                                <i class="fas fa-stream me-2"></i>Liste de présence
                            </a>

                            <a class="collapse-item fw-bold text-dark bg-light-success rounded mx-2 my-1" href="{{ route('presences.etat') }}">
                                <i class="fas fa-clipboard-list me-2" style="color: #2ed573;"></i> État des Présences
                            </a>

                            <a class="collapse-item fw-bold text-dark" href="{{ route('rapports.presences.periodique') }}">
                                <i class="fas fa-file-medical-alt me-2" style="color: #1e3799;"></i> Rapport Périodique
                            </a>
                            <a class="collapse-item fw-bold text-dark" href="{{ route('rapports.mensuel') }}">
                                <i class="fas fa-file-invoice me-2" style="color: #1e3799;"></i> Rapport Mensuel
                            </a>
                        @endhasanyrole
                    </div>
                </div>
            </li>



            <!-- SECTION ANNONCES -->
            <li class="nav-item {{ request()->routeIs('annonces.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('annonces.index') }}">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Annonces</span>
                    {{-- Optionnel : un badge si l'utilisateur est admin pour rappeler son rôle --}}
                    @hasanyrole('admin|rh|Superviseur')
                        <span class="badge badge-light ml-1" style="font-size: 0.6rem;">Gérer</span>
                    @endhasanyrole
                </a>
            </li>

            <!-- PROFIL -->
            <li class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.show') }}">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Mon Profil</span>
                </a>
                <a class="collapse-item" href="{{ route('password.request') }}">{{ __('Mot de passe oublié ?') }}</a>

            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.topbar')

                <!-- Dans resources/views/layouts/app.blade.php -->

                <div class="container-fluid py-4">
                    {{-- 1. Affichage des messages Flash (Succès / Erreur) --}}
                    @if (session('error'))
                        <div class="alert alert-danger border-start border-4 border-danger shadow-sm mb-4 animated--grow-in">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success border-start border-4 border-success shadow-sm mb-4 animated--grow-in">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    {{-- 2. Affichage de l'alerte d'intérim actif (Optionnel mais recommandé) --}}
                    @can('has-role', 'Directeur')
                        @if(auth()->user()->agent && auth()->user()->agent->status !== 'Directeur')
                            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4 py-2">
                                <i class="fas fa-user-shield fs-4 me-3 text-primary"></i>
                                <div class="small">
                                    <strong>Mode Intérim :</strong> Vous naviguez avec les privilèges de la <strong>Direction</strong>.
                                </div>
                            </div>
                        @endif
                    @endcan

                    {{-- 3. Injection du contenu des pages --}}
                    @yield('content')
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>


 @stack('scripts')
</body>
</html>
