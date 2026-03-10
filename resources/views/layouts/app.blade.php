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
            <!-- SECTION ADMINISTRATION -->
           <!-- SECTION ADMINISTRATION : Réservée aux Admins -->
            @hasanyrole('admin|Superviseur|utilisateur')
                <hr class="sidebar-divider">
                <div class="sidebar-heading text-warning fw-bold">Administration & Consultation</div>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true">
                        <i class="fas fa-fw fa-shield-alt text-warning"></i>
                        <span class="text-warning fw-bold">CONTRÔLE & RH</span>
                    </a>
                    <div id="collapseAdmin" class="collapse" data-parent="#accordionSidebar">
                        <!-- Contour complet (border) + Bordure gauche épaisse (border-left-4) -->
                        <div class="bg-white py-2 collapse-inner rounded border border-warning border-left-4 shadow-lg">

                            {{-- BLOC RÉSERVÉ UNIQUEMENT AUX ADMINS / SUPERVISEURS --}}
                            @hasanyrole('admin|Superviseur')
                                <h6 class="collapse-header text-orange fw-bold border-bottom pb-1 mx-2">
                                    <i class="fas fa-user-shield me-1"></i> GESTION SYSTÈME
                                </h6>
                                <a class="collapse-item fw-bold text-dark hover-warning" href="{{ route('users.index') }}">
                                    <i class="fas fa-users-cog text-warning me-1"></i> Liste Utilisateurs
                                </a>
                                <a class="collapse-item fw-bold text-dark hover-warning" href="{{ route('admin.logs') }}">
                                    <i class="fas fa-user-tag text-warning me-1"></i> Gestion des Evenements
                                </a>
                                <a class="collapse-item fw-bold text-dark hover-warning" href="{{ route('roles.index') }}">
                                    <i class="fas fa-user-tag text-warning me-1"></i> Gestion des Rôles
                                </a>
                                <a class="collapse-item fw-bold text-danger bg-danger-light" href="{{ route('admin.coffre-fort') }}">
                                    <i class="fas fa-vault me-1"></i> COFFRE FORT
                                </a>
                                <a class="collapse-item text-secondary" href="{{ route('agents.nouveau') }}">Nouveau Compte</a>
                                <a class="collapse-item text-secondary" href="{{ route('agents.index') }}">Ressources Humaines</a>
                                <a class="collapse-item text-secondary" href="{{ route('extraction.index') }}">Extraction de données</a>
                            @endhasanyrole

                            {{-- BLOC ACCESSIBLE AUSSI À L'UTILISATEUR --}}
                            <div class="dropdown-divider border-top-warning"></div>
                            <h6 class="collapse-header text-primary fw-bold border-bottom pb-1 mx-2">
                                <i class="fas fa-search me-1"></i> CONSULTATION
                            </h6>
                            <a class="collapse-item fw-bold text-primary" href="{{ route('agents.par.service') }}">
                                <i class="fas fa-building me-1"></i> Agents par Service
                            </a>

                            @hasanyrole('admin|Superviseur')
                                <a class="collapse-item text-secondary" href="{{ route('agents.par.service.recherche') }}">Recherche Agents</a>
                                <div class="dropdown-divider"></div>
                                <h6 class="collapse-header text-warning fw-bold border-bottom pb-1 mx-2">
                                    <i class="fas fa-chart-line me-1"></i> ANALYSES
                                </h6>
                                <a class="collapse-item fw-bold text-warning" href="{{ route('statistiques.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard Stats
                                </a>
                                <a class="collapse-item text-secondary" href="{{ route('typeabsences.index') }}">Paramétrage Absence</a>
                            @endhasanyrole
                        </div>
                    </div>
                </li>
            @endhasanyrole

            <hr class="sidebar-divider">

                    <!-- SECTION COURRIERS : OPÉRATIONS (BLEU INFO ÉCLATANT) -->
            <div class="sidebar-heading text-info fw-bold">OPÉRATIONS</div>

            <li class="nav-item {{ request()->routeIs('courriers.*', 'imputations.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourriers" aria-expanded="true">
                    <i class="fas fa-fw fa-envelope-open-text text-info"></i>
                    <span class="text-info fw-bold">GESTION COURRIERS</span>
                </a>
                <div id="collapseCourriers" class="collapse {{ request()->routeIs('courriers.*', 'imputations.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                    <!-- Contour complet INFO + Bordure gauche épaisse (4px) + Ombre intense -->
                    <div class="bg-white py-2 collapse-inner rounded border border-info border-left-4 shadow-lg">

                        {{-- ACTIONS DE GESTION --}}
                        @hasanyrole('admin|editeur|rh|Superviseur')
                            <h6 class="collapse-header text-info fw-bold border-bottom pb-1 mx-2 mb-2">
                                <i class="fas fa-edit me-1"></i> TRAITEMENT
                            </h6>
                            <a class="collapse-item fw-bold text-dark" href="{{ route('courriers.index') }}">
                                <i class="fas fa-list-ul text-info me-1"></i> Enregistrement
                            </a>
                            <a class="collapse-item fw-bold text-success bg-success-light" href="{{ route('courriers.create') }}">
                                <i class="fas fa-plus-circle me-1"></i> Créer un courrier
                            </a>
                            <a class="collapse-item text-secondary" href="{{ route('courriers.archives') }}">
                                <i class="fas fa-archive me-1"></i> Archives
                            </a>
                            <a class="collapse-item text-secondary" href="{{ route('imputations.index') }}">
                                <i class="fas fa-share-square me-1"></i> Toutes les Imputations
                            </a>
                        @endhasanyrole

                        {{-- ACTIONS UTILISATEUR & CONSULTATION --}}
                        <div class="dropdown-divider border-top-info"></div>
                        <h6 class="collapse-header text-primary fw-bold border-bottom pb-1 mx-2 mb-2">
                            <i class="fas fa-user-circle me-1"></i> MON ESPACE
                        </h6>
                        <a class="collapse-item fw-bold text-primary" href="{{ route('imputations.mes_imputations') }}">
                            <i class="fas fa-thumbtack text-primary me-1"></i> Mes imputations
                        </a>
                        <a class="collapse-item text-secondary" href="{{ route('courriers.RechercheAffichage') }}">
                            <i class="fas fa-search me-1"></i> Recherche avancée
                        </a>

                        {{-- STATISTIQUES --}}
                        @hasanyrole('admin|Superviseur|rh')
                            <div class="dropdown-divider border-top-info"></div>
                            <h6 class="collapse-header text-info fw-bold border-bottom pb-1 mx-2 mb-2">
                                <i class="fas fa-chart-pie me-1"></i> ANALYSES
                            </h6>
                            <a class="collapse-item fw-bold text-info" href="{{ route('statistiques.index') }}">
                                <i class="fas fa-chart-bar me-1"></i> Statistiques
                            </a>
                            <a class="collapse-item fw-bold text-info" href="{{ route('statistiques.dashboard') }}">
                                <i class="fas fa-laptop-code me-1"></i> Dashboard Imputations
                            </a>
                        @endhasanyrole
                    </div>
                </div>
            </li>

            <!-- NOUVELLE SECTION : GESTION DES PRÉSENCES (VERT SUCCESS ÉCLATANT) -->
            <li class="nav-item {{ request()->routeIs('presences.*', 'absences.*', 'typeabsences.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePresences" aria-expanded="true">
                    <i class="fas fa-fw fa-user-check text-success"></i>
                    <span class="text-success fw-bold">GESTION PRÉSENCES</span>
                </a>
                <div id="collapsePresences" class="collapse {{ request()->routeIs('presences.*', 'absences.*', 'typeabsences.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                    <!-- Contour complet SUCCESS + Bordure gauche épaisse (4px) + Ombre portée -->
                    <div class="bg-white py-2 collapse-inner rounded border border-success border-left-4 shadow-lg">

                        {{-- ACCÈS PERSONNEL --}}
                        <h6 class="collapse-header text-success fw-bold border-bottom pb-1 mx-2 mb-2">
                            <i class="fas fa-user me-1"></i> MON ESPACE
                        </h6>
                        <a class="collapse-item fw-bold text-primary bg-light" href="{{ route('presences.monPointage') }}">
                            <i class="fas fa-fingerprint text-success me-1"></i> Marquer Présence
                        </a>
                        <a class="collapse-item text-dark fw-bold" href="{{ route('presences.monHistorique') }}">
                            <i class="fas fa-history text-success me-1"></i> Mon Historique
                        </a>
                        <a class="collapse-item text-dark fw-bold" href="{{ route('absences.monautorisation') }}">
                            <i class="fas fa-calendar-check text-success me-1"></i> Congés & Permissions
                        </a>

                        {{-- ACCÈS CONTRÔLE ET RH --}}
                        @hasanyrole('admin|rh|Superviseur')
                            <div class="dropdown-divider border-top-success"></div>
                            <h6 class="collapse-header text-success fw-bold border-bottom pb-1 mx-2 mb-2">
                                <i class="fas fa-user-shield me-1"></i> CONTRÔLE & RH
                            </h6>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('absences.createListe') }}">Autorisation d'Absence Groupée</a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('holidays.index') }}">Jours fériés</a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('presences.index') }}">Enregistrement pointage</a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('presences.listeFiltree') }}">Liste de présence</a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('presences.validation-hebdo') }}">Validation hebdo.</a>

                            <a class="collapse-item fw-bold text-dark" href="{{ route('presences.etat') }}">
                                <i class="fas fa-clipboard-list text-success me-1"></i> État des Présences
                            </a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('typeabsences.index') }}">Type Autorisations d'Absence</a>
                            <a class="collapse-item text-secondary fw-bold" href="{{ route('absences.index') }}">Liste Autorisations d'Absence</a>
                            <a class="collapse-item fw-bold text-warning" href="{{ route('absences.validation_liste') }}">
                                <i class="fas fa-tasks me-1"></i> Validation Autorisation d'Absence
                            </a>

                            <div class="dropdown-divider border-top-success"></div>
                            <h6 class="collapse-header text-success fw-bold border-bottom pb-1 mx-2 mb-2">
                                <i class="fas fa-file-alt me-1"></i> RAPPORTS
                            </h6>
                            <a class="collapse-item fw-bold text-dark" href="{{ route('rapports.presences.periodique') }}">
                                <i class="fas fa-file-medical-alt text-success me-1"></i> Rapport Périodique
                            </a>
                            <a class="collapse-item fw-bold text-dark" href="{{ route('rapports.mensuel') }}">
                                <i class="fas fa-file-invoice text-success me-1"></i> Rapport Mensuel
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

                <div class="container-fluid">
                     @if (session('error'))
                            <div class="alert alert-danger border-left-danger shadow animated--grow-in">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success border-left-success shadow animated--grow-in">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif

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
