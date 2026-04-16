-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 16 avr. 2026 à 16:10
-- Version du serveur : 11.4.9-MariaDB
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestcourriers`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

DROP TABLE IF EXISTS `absences`;
CREATE TABLE IF NOT EXISTS `absences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `type_absence_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `approuvee` tinyint(1) NOT NULL DEFAULT 0,
  `document_justificatif` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut_autorisation_absence` enum('en_attente','valide_chef','rejete') NOT NULL DEFAULT 'en_attente',
  `comment_absence_chef` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `absences_agent_id_foreign` (`agent_id`),
  KEY `absences_type_absence_id_foreign` (`type_absence_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `absences`
--

INSERT INTO `absences` (`id`, `agent_id`, `type_absence_id`, `date_debut`, `date_fin`, `approuvee`, `document_justificatif`, `created_at`, `updated_at`, `statut_autorisation_absence`, `comment_absence_chef`) VALUES
(3, 15, 3, '2026-01-01', '2026-12-31', 1, '1769004536_Document_2025-11-27_121019.pdf', '2026-01-21 14:08:56', '2026-01-21 14:08:56', 'en_attente', NULL),
(2, 10, 2, '2026-01-13', '2026-01-15', 1, '1769004466_Document_2025-11-27_121019.pdf', '2026-01-21 13:50:03', '2026-01-21 14:07:46', 'en_attente', NULL),
(8, 4, 2, '2026-02-25', '2026-02-25', 1, '1770720847_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-02-10 10:54:07', '2026-02-10 20:59:46', 'en_attente', NULL),
(7, 4, 4, '2026-02-27', '2026-02-27', 1, '1770720003_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-02-10 09:44:47', '2026-02-10 20:59:49', 'en_attente', NULL),
(81, 1, 4, '2026-05-28', '2026-05-30', 1, NULL, '2026-04-02 10:21:30', '2026-04-02 10:23:33', 'valide_chef', 'Avis favorable'),
(20, 16, 3, '2026-03-11', '2026-03-16', 1, '1772895225_Note_Service_Objectifs de recettes révisés 2025 N\'GUESSAN.doc.pdf', '2026-03-07 14:53:45', '2026-03-09 08:22:22', 'en_attente', NULL),
(16, 5, 3, '2026-03-11', '2026-03-16', 1, '1772895225_Note_Service_Objectifs de recettes révisés 2025 N\'GUESSAN.doc.pdf', '2026-03-07 14:53:45', '2026-03-09 08:22:25', 'en_attente', NULL),
(17, 9, 3, '2026-03-11', '2026-03-16', 2, '1772895225_Note_Service_Objectifs de recettes révisés 2025 N\'GUESSAN.doc.pdf', '2026-03-07 14:53:45', '2026-03-09 08:22:28', 'en_attente', NULL),
(18, 18, 3, '2026-03-11', '2026-03-16', 1, '1772895225_Note_Service_Objectifs de recettes révisés 2025 N\'GUESSAN.doc.pdf', '2026-03-07 14:53:45', '2026-03-09 08:22:24', 'en_attente', NULL),
(21, 22, 3, '2026-03-11', '2026-03-16', 2, '1772895225_Note_Service_Objectifs de recettes révisés 2025 N\'GUESSAN.doc.pdf', '2026-03-07 14:53:45', '2026-03-09 08:22:29', 'en_attente', NULL),
(22, 23, 7, '2026-03-11', '2026-03-16', 1, '1773044425_Compte débiteur 02-03-2026 13.56.pdf', '2026-03-09 08:20:25', '2026-03-09 08:22:19', 'en_attente', NULL),
(23, 25, 7, '2026-03-11', '2026-03-16', 1, '1773044425_Compte débiteur 02-03-2026 13.56.pdf', '2026-03-09 08:20:25', '2026-03-09 08:22:20', 'en_attente', NULL),
(24, 5, 7, '2026-03-20', '2026-04-02', 1, '1773044970_Compte débiteur 02-03-2026 13.56.pdf', '2026-03-09 08:29:30', '2026-03-09 08:29:49', 'en_attente', NULL),
(25, 20, 7, '2026-03-20', '2026-04-02', 1, '1773044970_Compte débiteur 02-03-2026 13.56.pdf', '2026-03-09 08:29:30', '2026-03-09 08:29:50', 'en_attente', NULL),
(27, 23, 7, '2026-03-20', '2026-03-22', 2, '1773074830_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-03-09 16:47:10', '2026-03-11 10:15:31', 'en_attente', NULL),
(28, 25, 7, '2026-03-20', '2026-03-22', 1, '1773074830_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-03-09 16:47:10', '2026-03-19 07:36:10', 'en_attente', NULL),
(29, 9, 7, '2026-03-20', '2026-03-22', 1, '1773074830_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-03-09 16:47:10', '2026-03-11 10:15:35', 'en_attente', NULL),
(30, 18, 7, '2026-03-20', '2026-03-22', 1, '1773074830_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-03-09 16:47:10', '2026-03-11 10:15:34', 'en_attente', NULL),
(31, 20, 7, '2026-03-10', '2026-03-15', 1, '1773223805_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-03-11 10:10:05', '2026-03-11 10:10:33', 'en_attente', NULL),
(32, 5, 1, '2026-03-15', '2026-03-18', 1, 'Généré par intérim #1773486234', '2026-03-14 11:03:54', '2026-03-19 07:36:08', 'en_attente', NULL),
(33, 5, 1, '2026-03-22', '2026-03-25', 1, 'seminaire a dakar', '2026-03-14 11:16:33', '2026-03-19 07:36:09', 'en_attente', NULL),
(34, 25, 1, '2026-03-15', '2026-03-17', 1, 'repos maladie', '2026-03-15 14:41:44', '2026-03-19 07:36:07', 'en_attente', NULL),
(35, 16, 1, '2026-03-19', '2026-03-25', 1, 'seminaire', '2026-03-19 07:22:21', '2026-03-19 07:36:05', 'en_attente', NULL),
(36, 11, 1, '2026-03-19', '2026-03-20', 1, 'stage', '2026-03-19 07:34:19', '2026-03-19 07:34:19', 'en_attente', NULL),
(37, 4, 1, '2026-03-19', '2026-03-21', 1, 'essai verif', '2026-03-19 07:59:17', '2026-03-19 07:59:17', 'en_attente', NULL),
(38, 24, 7, '2026-04-12', '2026-04-16', 1, '1773919851_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '2026-03-19 11:30:51', '2026-03-19 11:31:05', 'en_attente', NULL),
(39, 7, 7, '2026-04-12', '2026-04-16', 1, '1773919851_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '2026-03-19 11:30:51', '2026-03-19 11:31:09', 'en_attente', NULL),
(40, 3, 7, '2026-04-12', '2026-04-16', 1, '1773919851_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '2026-03-19 11:30:51', '2026-03-19 11:31:11', 'en_attente', NULL),
(50, 18, 7, '2026-03-25', '2026-03-27', 1, '1774251853_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '2026-03-23 07:44:13', '2026-03-23 08:13:38', 'en_attente', NULL),
(51, 4, 7, '2026-03-25', '2026-03-27', 1, '1774251853_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '2026-03-23 07:44:13', '2026-03-23 08:13:40', 'en_attente', NULL),
(52, 17, 7, '2026-03-25', '2026-03-27', 1, '1774251853_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '2026-03-23 07:44:13', '2026-03-23 08:13:42', 'en_attente', NULL),
(70, 2, 2, '2026-06-03', '2026-06-07', 0, '1774547936_1770551719_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.doc.pdf', '2026-03-26 17:58:56', '2026-03-26 18:02:05', 'rejete', 'Demande rejetée par le responsable.'),
(72, 5, 1, '2026-06-11', '2026-06-13', 1, 'repos malaie', '2026-03-31 10:15:41', '2026-03-31 10:15:41', 'en_attente', NULL),
(73, 5, 1, '2026-04-05', '2026-04-08', 1, 'voyage d\'etude à istambul', '2026-04-01 17:04:38', '2026-04-01 17:17:18', 'en_attente', NULL),
(75, 23, 3, '2026-04-05', '2026-04-06', 1, '1775123691_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-04-02 09:54:51', '2026-04-02 09:55:40', 'en_attente', NULL),
(76, 25, 3, '2026-04-05', '2026-04-06', 1, '1775123691_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-04-02 09:54:51', '2026-04-02 09:55:43', 'en_attente', NULL),
(77, 9, 3, '2026-04-05', '2026-04-06', 1, '1775123691_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-04-02 09:54:51', '2026-04-02 09:55:34', 'en_attente', NULL),
(78, 18, 3, '2026-04-05', '2026-04-06', 1, '1775123691_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-04-02 09:54:51', '2026-04-02 09:55:47', 'en_attente', NULL),
(79, 20, 3, '2026-04-05', '2026-04-06', 1, '1775123691_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-04-02 09:54:51', '2026-04-02 09:55:31', 'en_attente', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `report_date` date NOT NULL,
  `content` text NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_report_date_index` (`report_date`),
  KEY `activities_service_id_index` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activities`
--

INSERT INTO `activities` (`id`, `service_id`, `start_date`, `end_date`, `is_permanent`, `report_date`, `content`, `progress`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-04-03', NULL, 1, '2026-04-03', 'coage de données avec Laravel 12, intervention sur le poste de Mme DJE et Mme Krihouan et M. Balley', 0, '2026-03-31 17:09:17', '2026-04-05 16:20:59'),
(2, 1, '2026-04-04', NULL, 1, '2026-04-04', 'Adressage IP des machines', 100, '2026-03-31 17:13:00', '2026-04-05 16:08:54'),
(3, 1, '2026-04-01', '2026-04-02', 0, '2026-04-02', 'Reunion de planification des opérations de sauvegarde des données en vue d\'une réinitialisation des comptes utilisateurs, desormais requis pour avoir accès aux machines', 100, '2026-04-01 09:03:38', '2026-04-05 16:20:33'),
(4, 1, '2026-04-02', NULL, 1, '2026-04-03', 'Presentation du progiciel de gestion de la DSESF', 70, '2026-04-02 09:29:41', '2026-04-05 16:49:34'),
(5, 1, '2026-04-05', '2026-04-05', 0, '2026-04-05', 'codage laravel 12 sur la gestion des activités', 95, '2026-04-05 16:36:42', '2026-04-05 16:36:42');

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_professionnel` varchar(191) DEFAULT NULL,
  `matricule` varchar(191) NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `status` enum('Agent','Chef de service','Sous-directeur','Directeur','Conseiller Technique','Conseiller Spécial') NOT NULL DEFAULT 'Agent',
  `sexe` enum('Male','Female') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `Place_birth` varchar(191) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `Emploi` varchar(191) DEFAULT NULL,
  `Grade` varchar(191) DEFAULT NULL,
  `Date_Prise_de_service` date DEFAULT NULL,
  `Personne_a_prevenir` varchar(191) DEFAULT NULL,
  `Contact_personne_a_prevenir` varchar(191) DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agents_matricule_unique` (`matricule`),
  UNIQUE KEY `agents_email_unique` (`email`),
  UNIQUE KEY `agents_email_professionnel_unique` (`email_professionnel`),
  KEY `agents_service_id_foreign` (`service_id`),
  KEY `agents_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id`, `email_professionnel`, `matricule`, `first_name`, `last_name`, `status`, `sexe`, `date_of_birth`, `Place_birth`, `photo`, `email`, `phone_number`, `address`, `Emploi`, `Grade`, `Date_Prise_de_service`, `Personne_a_prevenir`, `Contact_personne_a_prevenir`, `service_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'yacouba.coulibaly@dgi.gouv.ci', '287688C', 'Sié yacouba', 'COULIBALY', 'Chef de service', 'Male', '1972-12-04', 'COCODY', '1768915886_Photo identite COULIBALY Sié Yacouba 287 688C.JPG', 'yacouba.coulibaly@dgi.gouv.ci', '0707584396', '08 BP 2359', 'Ingenieur Principal Informatique', 'A5', '2025-07-08', 'COULIBALY Youssef Kiyali', '0143677424', 1, 3, '2026-01-20 13:25:02', '2026-04-08 13:47:27'),
(2, 'nkone05@dgi.gouv.ci', '410702H', 'Nafata', 'KONE', 'Agent', 'Female', '1982-07-21', NULL, '1768916792_Photo_nafi.jpg', 'nkone05@dgi.gouv.ci', '0707188674', 'Bassam Mockeyville', 'Contrôleur des Impôts', 'B3', '2014-11-03', 'KONE Dieudoné', '0747234646', 1, 4, '2026-01-20 13:46:32', '2026-03-27 09:43:54'),
(3, 'roussou@dgi.gouv.ci', '291264E', 'Rosine Générosa Epse Dje', 'OUSSOU', 'Chef de service', 'Female', '1976-01-21', NULL, '1768916939_Photo_2026-01-13_114214.jpg', 'roussou@dgi.gouv.ci', '0707728488', NULL, 'Attaché de Direction', 'A3', '2011-04-12', 'M. DJE', NULL, 3, 5, '2026-01-20 13:48:59', '2026-01-20 14:02:58'),
(4, 'andoume@dgi.gouv.ci', '410770Q', 'Arlette', 'N\'DOUME', 'Chef de service', 'Female', '1977-01-19', 'COCODY', '1768992193_Photo n\'doumbe.jpg', 'andoume@dgi.gouv.ci', '0707080437', 'COCODY Camp AKOUEDO', 'Inspecteur des Impôts', 'A3', '2014-12-29', 'M. AKA', '0707080437', 1, 6, '2026-01-21 10:43:13', '2026-01-21 10:54:15'),
(5, 'iadico@dgi.gouv.ci', '278886H', 'Innocent', 'ADICO', 'Directeur', 'Male', NULL, NULL, NULL, 'iadico@dgi.gouv.ci', NULL, NULL, 'Inspecteur Principal Statisticien Economiste', 'A7', NULL, NULL, NULL, 20, 9, '2026-01-21 11:50:04', '2026-04-01 17:19:19'),
(6, 'michelkeita@dgi.gouv.ci', '305211F', 'Moctar Michel Djépa', 'KEITA', 'Conseiller Technique', 'Male', NULL, NULL, NULL, 'michelkeita@dgi.gouv.ci', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, 10, '2026-01-21 11:56:29', '2026-01-21 11:56:29'),
(7, 'asokpekon@dgi.gouv.ci', '209438K', 'Assi Roger', 'OKPEKON', 'Chef de service', 'Male', NULL, NULL, NULL, 'asokpekon@dgi.gouv.ci', NULL, NULL, 'Attaché des Finances', 'A3', '1980-01-01', NULL, NULL, 2, 11, '2026-01-21 11:59:18', '2026-01-21 12:18:37'),
(8, 'kbrou04@dgi.gouv.ci', '332674H', 'Née Brou Amenan M.', 'KOUADIO', 'Agent', 'Female', NULL, NULL, NULL, 'kbrou04@dgi.gouv.ci', NULL, NULL, 'Attaché de Direction', 'A3', NULL, NULL, NULL, 20, 12, '2026-01-21 12:02:21', '2026-01-21 12:19:22'),
(9, 'mballo@dgi.gouv.ci', '421319X', 'Maïmouna', 'BALLO', 'Agent', 'Male', NULL, 'ADZOPE', NULL, 'mballo@dgi.gouv.ci', NULL, NULL, 'Agent de bureau', 'D1', NULL, NULL, NULL, 3, 13, '2026-01-21 12:37:32', '2026-01-21 12:44:53'),
(10, 'adjedjemel@dgi.gouv.ci', '298075B', 'Akpa Leonard', 'DJEDJEMEL', 'Agent', 'Male', NULL, 'DABOU', NULL, 'adjedjemel@dgi.gouv.ci', NULL, NULL, 'Secrétaire Comptable', 'C2', NULL, NULL, NULL, 3, 14, '2026-01-21 12:47:16', '2026-01-21 12:48:12'),
(11, 'mtraore@dgi.gouv.ci', '305722F', 'Mamadou', 'TRAORE', 'Sous-directeur', 'Male', NULL, 'TAFIRE', NULL, 'mtraore@dgi.gouv.ci', NULL, NULL, 'Ingenieur Principal Informatique', 'A5', NULL, NULL, NULL, 18, 15, '2026-01-21 12:51:08', '2026-01-21 12:52:34'),
(12, NULL, '333011M', 'Bi Douby Lazare', 'DOUBY', 'Agent', 'Male', NULL, NULL, NULL, 'doubi@dgi.gouv.ci', NULL, NULL, 'Agent de Maïtrise des Travaux Publics', 'C2', NULL, NULL, NULL, 20, NULL, '2026-01-21 13:09:01', '2026-01-21 13:12:32'),
(13, NULL, '313318H', 'Adingra William', 'KOUAKOU', 'Agent', 'Male', NULL, NULL, NULL, 'kouakouadingra@dgi.gouv.ci', NULL, NULL, 'Agent Spécialisé des Travaux Public', 'D1', NULL, NULL, NULL, 20, NULL, '2026-01-21 13:11:06', '2026-01-21 13:15:10'),
(14, NULL, '862439S', 'Mathieu', 'TERE', 'Agent', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Agent Spécialisé des Travaux Public', 'D1', NULL, NULL, NULL, 20, NULL, '2026-01-21 13:13:50', '2026-01-21 13:13:50'),
(15, NULL, '472108g', 'Josué', 'GUELAGNINHON', 'Agent', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Agent Technique de la Statistique', 'C2', NULL, NULL, NULL, 20, NULL, '2026-01-21 13:28:08', '2026-01-21 13:28:08'),
(16, 'thoro@dgi.gouv.ci', '234758K', 'Tiekoura', 'HORO', 'Chef de service', 'Male', NULL, NULL, NULL, 'thoro@dgi.gouv.ci', NULL, NULL, 'Attaché des Finances', 'A3', NULL, NULL, NULL, 10, 16, '2026-01-22 08:10:12', '2026-01-22 08:11:03'),
(17, 'bnguessan04@dgi.gouv.ci', '284953S', 'Brou tchoumou serge', 'N\'GUESSAN', 'Sous-directeur', 'Male', NULL, NULL, NULL, 'bnguessan04@dgi.gouv.ci', NULL, NULL, 'Administrateur des services Financiers', 'A4', NULL, NULL, NULL, 16, 17, '2026-01-22 08:27:00', '2026-01-22 08:27:59'),
(18, 'mbezi@dgi.gouv.ci', '278865K', 'Mathurin', 'BEZI', 'Sous-directeur', 'Male', NULL, NULL, NULL, 'mbezi@dgi.gouv.ci', NULL, NULL, 'Administrateur des services Financiers', 'A4', NULL, NULL, NULL, 17, 18, '2026-01-22 08:41:51', '2026-01-22 08:42:22'),
(19, 'rtouboui@dgi.gouv.ci', '298834Z', 'Bi suy robert', 'TOUBOUI', 'Chef de service', 'Male', NULL, NULL, NULL, 'rtouboui@dgi.gouv.ci', NULL, NULL, 'Attaché des Finances', 'A3', NULL, NULL, NULL, 11, 19, '2026-01-23 10:25:21', '2026-01-23 10:26:34'),
(20, 'mamadoulcoul@dgi.gouv.ci', '360244S', 'Mamadou lamine', 'COULIBALY', 'Agent', 'Male', NULL, NULL, NULL, 'mamadoulcoul@dgi.gouv.ci', NULL, NULL, 'Demographe', 'A4', NULL, NULL, NULL, 11, 20, '2026-01-23 10:29:57', '2026-01-23 10:30:27'),
(21, 'akeita@dgi.gouv.ci', '305436Z', 'Née keita aramata anne elise', 'KEDI', 'Agent', 'Female', NULL, NULL, NULL, 'akeita@dgi.gouv.ci', NULL, NULL, 'Inspecteur des Impôts', 'A3', NULL, NULL, NULL, 10, 21, '2026-01-27 07:57:48', '2026-01-27 08:14:44'),
(22, 'christiankonankoffi@dgi.gouv.ci', '804367G', 'Konan christian rené', 'KOFFI', 'Agent', 'Male', NULL, NULL, NULL, 'christiankonankoffi@dgi.gouv.ci', NULL, NULL, 'Secrétaire Administratif', 'B3', NULL, NULL, NULL, 11, 22, '2026-01-27 08:14:10', '2026-01-27 08:15:28'),
(23, 'erasthene16ja17@dgi.gouv.ci', '435014F', 'M\'bo erasthène', 'ALEXANDRE', 'Agent', 'Male', '1991-12-20', 'Akoupe/Yaffo-Attié', '1769527329_IMG_M\'bo alexandre.jpg', 'erasthene16ja17@dgi.gouv.ci', '0707661901', NULL, 'Analyste Statisticien', 'B3', '2025-12-15', 'M\'bo Sylvain', '0758033663', 13, 23, '2026-01-27 14:44:26', '2026-01-27 15:22:09'),
(24, 'unguessan@dgi.gouv.ci', '360340E', 'Yao ulrich', 'N\'GUESSAN', 'Chef de service', 'Male', NULL, NULL, NULL, 'unguessan@dgi.gouv.ci', NULL, NULL, 'Attaché des Finances', 'A3', NULL, NULL, NULL, 8, 24, '2026-01-29 09:39:36', '2026-01-29 09:41:05'),
(25, 'riviere@dgi.gouv.ci', '100200G', 'Riviere michel', 'ANGELS', 'Chef de service', 'Female', '1995-08-27', 'ABENGOUROU', '1772448886_riviere photo identité.jpg', 'riviere@dgi.gouv.ci', '0584365858', NULL, 'Ingenieur statiticien economiste', 'A4', '2025-01-02', 'YACINE', '0160232458', 11, 25, '2026-02-27 19:33:26', '2026-03-02 10:54:46');

-- --------------------------------------------------------

--
-- Structure de la table `agent_imputation`
--

DROP TABLE IF EXISTS `agent_imputation`;
CREATE TABLE IF NOT EXISTS `agent_imputation` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `imputation_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_imputation_imputation_id_foreign` (`imputation_id`),
  KEY `agent_imputation_agent_id_foreign` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agent_imputation`
--

INSERT INTO `agent_imputation` (`id`, `imputation_id`, `agent_id`, `created_at`, `updated_at`) VALUES
(7, 7, 1, NULL, NULL),
(9, 9, 1, NULL, NULL),
(10, 10, 1, NULL, NULL),
(6, 6, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(11, 10, 2, NULL, NULL),
(12, 11, 1, NULL, NULL),
(13, 11, 2, NULL, NULL),
(14, 11, 4, NULL, NULL),
(20, 15, 1, NULL, NULL),
(23, 18, 1, NULL, NULL),
(22, 17, 1, NULL, NULL),
(21, 16, 1, NULL, NULL),
(24, 19, 1, NULL, NULL),
(25, 19, 2, NULL, NULL),
(26, 20, 1, NULL, NULL),
(27, 21, 2, NULL, NULL),
(28, 22, 2, NULL, NULL),
(29, 23, 1, NULL, NULL),
(30, 24, 1, NULL, NULL),
(31, 25, 1, NULL, NULL),
(32, 26, 1, NULL, NULL),
(33, 27, 1, NULL, NULL),
(34, 28, 1, NULL, NULL),
(35, 28, 2, NULL, NULL),
(36, 28, 4, NULL, NULL),
(39, 31, 18, NULL, NULL),
(38, 30, 18, NULL, NULL),
(41, 33, 1, NULL, NULL),
(42, 34, 18, NULL, NULL),
(43, 35, 18, NULL, NULL),
(44, 36, 18, NULL, NULL),
(45, 37, 25, NULL, NULL),
(56, 49, 21, NULL, NULL),
(57, 50, 21, NULL, NULL),
(55, 48, 21, NULL, NULL),
(54, 47, 21, NULL, NULL),
(58, 51, 25, NULL, NULL),
(59, 51, 1, NULL, NULL),
(60, 52, 1, NULL, NULL),
(61, 53, 1, NULL, NULL),
(62, 53, 2, NULL, NULL),
(63, 54, 1, NULL, NULL),
(64, 55, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(191) NOT NULL,
  `contenu` text NOT NULL,
  `type` enum('urgent','information','evenement','avertissement','general') NOT NULL DEFAULT 'general',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `titre`, `contenu`, `type`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'SEMINAIRE ANNUEL 2025', 'Bilan annuel des activités fiscales 2025', 'information', 1, '2026-02-26 00:00:00', '2026-01-20 15:59:53', '2026-02-10 21:16:14'),
(2, 'Atelier sur la GED', 'BBN', 'information', 1, '2026-02-27 00:00:00', '2026-02-10 21:03:43', '2026-02-10 21:15:50'),
(3, 'Réunion de comité', 'comité des utilisateurs', 'evenement', 1, '2026-03-03 00:00:00', '2026-02-10 21:18:43', '2026-02-10 21:18:43'),
(4, 'Seminaire IA du 22 mars 2025', 'Seminaire IA à Grand Bassam', 'urgent', 1, '2026-03-23 00:00:00', '2026-03-09 17:41:22', '2026-03-09 17:41:22'),
(5, 'SEMINAIRE DU 1er TRIMESTRIEL 2026', 'Séminaire Trimestriel  statistiques fiscales 1er Trimestre 2026 du 02 au 04 avril 2026', 'information', 1, '2026-04-10 00:00:00', '2026-03-30 12:18:09', '2026-03-30 12:23:38');

-- --------------------------------------------------------

--
-- Structure de la table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) NOT NULL,
  `auditable_type` varchar(255) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `url` varchar(255) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=299 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `method`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(21, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 07:00:23', '2026-03-12 07:00:23'),
(19, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 06:51:04', '2026-03-12 06:51:04'),
(20, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 06:58:26', '2026-03-12 06:58:26'),
(17, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 13:44:28', '2026-03-11 13:44:28'),
(15, 9, 'Connexion réussie', 'Système', 9, NULL, '\"{\\\"email\\\":\\\"iadico@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 12:28:17', '2026-03-11 12:28:17'),
(16, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 12:32:43', '2026-03-11 12:32:43'),
(18, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 14:51:49', '2026-03-11 14:51:49'),
(22, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"sig_3_1773241249.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773302370.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 07:59:30', '2026-03-12 07:59:30'),
(23, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773302370.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773302727.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:05:27', '2026-03-12 08:05:27'),
(24, 3, 'Upload signature scannée', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773302727.png\\\"}\"', '\"{\\\"path\\\":\\\"scan_3_1773302869.JPG\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:07:49', '2026-03-12 08:07:49'),
(25, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"scan_3_1773302869.JPG\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773303055.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:10:55', '2026-03-12 08:10:55'),
(26, 3, 'Upload signature scannée', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773303055.png\\\"}\"', '\"{\\\"path\\\":\\\"scan_3_1773303520.JPG\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:18:40', '2026-03-12 08:18:40'),
(27, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"scan_3_1773303520.JPG\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773303537.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:18:57', '2026-03-12 08:18:57'),
(28, 3, 'Upload signature scannée', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773303537.png\\\"}\"', '\"{\\\"path\\\":\\\"scan_3_1773304257.JPG\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:30:57', '2026-03-12 08:30:57'),
(29, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"scan_3_1773304257.JPG\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773304269.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:31:09', '2026-03-12 08:31:09'),
(30, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773304269.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773304827.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:40:27', '2026-03-12 08:40:27'),
(31, 3, 'Upload signature scannée', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773304827.png\\\"}\"', '\"{\\\"path\\\":\\\"scan_3_1773304837.jpg\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:40:37', '2026-03-12 08:40:37'),
(32, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"scan_3_1773304837.jpg\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773304855.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 08:40:55', '2026-03-12 08:40:55'),
(33, 3, 'updated', 'App\\Models\\Courrier', 23, '\"{\\\"id\\\":23,\\\"num_enregistrement\\\":\\\"REG-2026-699EFB7E161D0\\\",\\\"affecter\\\":true,\\\"reference\\\":\\\"1112233\\\",\\\"type\\\":\\\"Incoming Externe\\\",\\\"objet\\\":\\\"essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-25T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-02-24\\\",\\\"expediteur_nom\\\":\\\"SAPH\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"archiv\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1772026750_Liste_MembreSport.pdf\\\",\\\"created_at\\\":\\\"2026-02-25T13:39:10.000000Z\\\",\\\"updated_at\\\":\\\"2026-02-25T13:50:36.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6Im1CeTRGZmM0czNuZm8rLy9iMFNRR0E9PSIsInZhbHVlIjoiZVVZSTY5dFU5OHYyK3F6YlEvakhvdz09IiwibWFjIjoiMTNmMDNhYWRkNWVkOWI0MzhlYzJiN2QxOWM2YzZjYmQxMWU0MzBlMDk4NWQ2YTI4ODU2MTdmNTAxZTc2ZDBjMSIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":23,\\\"num_enregistrement\\\":\\\"REG-2026-699EFB7E161D0\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"1112233\\\",\\\"type\\\":\\\"Incoming Externe\\\",\\\"objet\\\":\\\"essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-25\\\",\\\"date_document_original\\\":\\\"2026-02-24\\\",\\\"expediteur_nom\\\":\\\"SAPH\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1772026750_Liste_MembreSport.pdf\\\",\\\"created_at\\\":\\\"2026-02-25 13:39:10\\\",\\\"updated_at\\\":\\\"2026-03-12 09:18:11\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6Im1CeTRGZmM0czNuZm8rLy9iMFNRR0E9PSIsInZhbHVlIjoiZVVZSTY5dFU5OHYyK3F6YlEvakhvdz09IiwibWFjIjoiMTNmMDNhYWRkNWVkOWI0MzhlYzJiN2QxOWM2YzZjYmQxMWU0MzBlMDk4NWQ2YTI4ODU2MTdmNTAxZTc2ZDBjMSIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/courriers/23/sign', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 09:18:11', '2026-03-12 09:18:11'),
(34, 3, 'updated', 'App\\Models\\Courrier', 15, '\"{\\\"id\\\":15,\\\"num_enregistrement\\\":\\\"REG-2026-698882381615A\\\",\\\"affecter\\\":true,\\\"reference\\\":\\\"23333\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort3\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770553912_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\\\",\\\"created_at\\\":\\\"2026-02-08T12:31:52.000000Z\\\",\\\"updated_at\\\":\\\"2026-02-08T12:32:44.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IldRcGw0blZUckRxUE10RXR6MnloVVE9PSIsInZhbHVlIjoieUdrMEc2bkxtWUs4Tm83MkRWTDBBdz09IiwibWFjIjoiYzYxYTM5MWI4NzVlYjEwNjY4MDg0YWZlNjIzZmY2NzE4ODNhNTU1Y2JkZWZmNGVhZDgzZjdjZTRiNzVlODNhMiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":15,\\\"num_enregistrement\\\":\\\"REG-2026-698882381615A\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"23333\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort3\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770553912_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\\\",\\\"created_at\\\":\\\"2026-02-08 12:31:52\\\",\\\"updated_at\\\":\\\"2026-03-12 09:38:23\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IldRcGw0blZUckRxUE10RXR6MnloVVE9PSIsInZhbHVlIjoieUdrMEc2bkxtWUs4Tm83MkRWTDBBdz09IiwibWFjIjoiYzYxYTM5MWI4NzVlYjEwNjY4MDg0YWZlNjIzZmY2NzE4ODNhNTU1Y2JkZWZmNGVhZDgzZjdjZTRiNzVlODNhMiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/courriers/15/sign', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 09:38:23', '2026-03-12 09:38:23'),
(35, 3, 'updated', 'App\\Models\\Courrier', 15, '\"{\\\"id\\\":15,\\\"num_enregistrement\\\":\\\"REG-2026-698882381615A\\\",\\\"affecter\\\":true,\\\"reference\\\":\\\"23333\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort3\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770553912_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\\\",\\\"created_at\\\":\\\"2026-02-08T12:31:52.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-12T09:38:23.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IldRcGw0blZUckRxUE10RXR6MnloVVE9PSIsInZhbHVlIjoieUdrMEc2bkxtWUs4Tm83MkRWTDBBdz09IiwibWFjIjoiYzYxYTM5MWI4NzVlYjEwNjY4MDg0YWZlNjIzZmY2NzE4ODNhNTU1Y2JkZWZmNGVhZDgzZjdjZTRiNzVlODNhMiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":15,\\\"num_enregistrement\\\":\\\"REG-2026-698882381615A\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"23333\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort3\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770553912_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\\\",\\\"created_at\\\":\\\"2026-02-08 12:31:52\\\",\\\"updated_at\\\":\\\"2026-03-12 10:02:18\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IldRcGw0blZUckRxUE10RXR6MnloVVE9PSIsInZhbHVlIjoieUdrMEc2bkxtWUs4Tm83MkRWTDBBdz09IiwibWFjIjoiYzYxYTM5MWI4NzVlYjEwNjY4MDg0YWZlNjIzZmY2NzE4ODNhNTU1Y2JkZWZmNGVhZDgzZjdjZTRiNzVlODNhMiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":3,\\\"signed_at\\\":\\\"2026-03-12T10:02:18.935420Z\\\"}\"', 'http://127.0.0.1:8000/courriers/15/sign', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 10:02:18', '2026-03-12 10:02:18'),
(36, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773304855.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773309881.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 10:04:41', '2026-03-12 10:04:41'),
(37, 3, 'Upload signature scannée', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773309881.png\\\"}\"', '\"{\\\"path\\\":\\\"scan_3_1773309928.JPG\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 10:05:28', '2026-03-12 10:05:28'),
(38, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"scan_3_1773309928.JPG\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1773309946.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 10:05:46', '2026-03-12 10:05:46'),
(39, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 17:01:38', '2026-03-12 17:01:38'),
(40, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 01:05:58', '2026-03-13 01:05:58'),
(41, 3, 'updated', 'App\\Models\\Courrier', 11, '\"{\\\"id\\\":11,\\\"num_enregistrement\\\":\\\"REG-2026-697B3140CAE6F\\\",\\\"affecter\\\":true,\\\"reference\\\":\\\"444444\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste un essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-01-29T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"archiv\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1769681216_COMMISSION_PARITAIRE_DE_SUIVI_DU_PROFIL_DE_CARRIERE.pdf\\\",\\\"created_at\\\":\\\"2026-01-29T10:06:56.000000Z\\\",\\\"updated_at\\\":\\\"2026-01-29T10:21:46.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":11,\\\"num_enregistrement\\\":\\\"REG-2026-697B3140CAE6F\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"444444\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste un essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-01-29\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1769681216_COMMISSION_PARITAIRE_DE_SUIVI_DU_PROFIL_DE_CARRIERE.pdf\\\",\\\"created_at\\\":\\\"2026-01-29 10:06:56\\\",\\\"updated_at\\\":\\\"2026-03-13 01:06:51\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":3,\\\"signed_at\\\":\\\"2026-03-13T01:06:51.535412Z\\\"}\"', 'http://127.0.0.1:8000/courriers/11/sign', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 01:06:51', '2026-03-13 01:06:51'),
(42, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 10:30:27', '2026-03-13 10:30:27'),
(43, 9, 'Connexion réussie', 'Système', 9, NULL, '\"{\\\"email\\\":\\\"iadico@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 13:22:04', '2026-03-13 13:22:04'),
(44, 9, 'Mise à jour signature pad', 'User', 9, '\"{\\\"path\\\":null}\"', '\"{\\\"path\\\":\\\"pad_9_1773408453.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 13:27:33', '2026-03-13 13:27:33'),
(45, 9, 'updated', 'App\\Models\\Courrier', 10, '\"{\\\"id\\\":10,\\\"num_enregistrement\\\":\\\"REG-2026-6979ED4466FDE\\\",\\\"affecter\\\":true,\\\"reference\\\":\\\"01210\\\",\\\"type\\\":\\\"Outgoing Externe\\\",\\\"objet\\\":\\\"Visite de MTN C\\\\u00f4te d\'Ivoire\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-01-28T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1769598276_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"created_at\\\":\\\"2026-01-28T11:04:36.000000Z\\\",\\\"updated_at\\\":\\\"2026-02-09T14:49:51.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":10,\\\"num_enregistrement\\\":\\\"REG-2026-6979ED4466FDE\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"01210\\\",\\\"type\\\":\\\"Outgoing Externe\\\",\\\"objet\\\":\\\"Visite de MTN C\\\\u00f4te d\'Ivoire\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-01-28\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1769598276_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"created_at\\\":\\\"2026-01-28 11:04:36\\\",\\\"updated_at\\\":\\\"2026-03-13 13:28:47\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":9,\\\"signed_at\\\":\\\"2026-03-13T13:28:47.876177Z\\\"}\"', 'http://127.0.0.1:8000/courriers/10/sign', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 13:28:47', '2026-03-13 13:28:47'),
(46, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 15:16:21', '2026-03-13 15:16:21'),
(47, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 22:38:52', '2026-03-13 22:38:52'),
(48, 9, 'Connexion réussie', 'Système', 9, NULL, '\"{\\\"email\\\":\\\"iadico@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 22:42:38', '2026-03-13 22:42:38'),
(49, 9, 'updated', 'App\\Models\\Courrier', 12, '\"{\\\"id\\\":12,\\\"num_enregistrement\\\":\\\"REG-2026-698879A786900\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"000222\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770551719_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.doc.pdf\\\",\\\"created_at\\\":\\\"2026-02-08T11:55:19.000000Z\\\",\\\"updated_at\\\":\\\"2026-02-08T11:55:19.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":12,\\\"num_enregistrement\\\":\\\"REG-2026-698879A786900\\\",\\\"affecter\\\":0,\\\"reference\\\":\\\"000222\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770551719_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.doc.pdf\\\",\\\"created_at\\\":\\\"2026-02-08 11:55:19\\\",\\\"updated_at\\\":\\\"2026-03-13 22:43:31\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":9,\\\"signed_at\\\":\\\"2026-03-13T22:43:31.897186Z\\\"}\"', 'http://127.0.0.1:8000/courriers/12/sign', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 22:43:31', '2026-03-13 22:43:31'),
(50, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-14 09:16:15', '2026-03-14 09:16:15'),
(51, 3, 'updated', 'App\\Models\\Courrier', 11, '\"{\\\"id\\\":11,\\\"num_enregistrement\\\":\\\"REG-2026-697B3140CAE6F\\\",\\\"affecter\\\":true,\\\"reference\\\":\\\"444444\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste un essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-01-29T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1769681216_COMMISSION_PARITAIRE_DE_SUIVI_DU_PROFIL_DE_CARRIERE.pdf\\\",\\\"created_at\\\":\\\"2026-01-29T10:06:56.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-13T01:06:51.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":3,\\\"signed_at\\\":\\\"2026-03-13 01:06:51\\\"}\"', '\"{\\\"id\\\":11,\\\"num_enregistrement\\\":\\\"REG-2026-697B3140CAE6F\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"444444\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste un essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-01-29\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1769681216_COMMISSION_PARITAIRE_DE_SUIVI_DU_PROFIL_DE_CARRIERE.pdf\\\",\\\"created_at\\\":\\\"2026-01-29 10:06:56\\\",\\\"updated_at\\\":\\\"2026-03-14 10:24:26\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":3,\\\"signed_at\\\":\\\"2026-03-13 01:06:51\\\"}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-14 10:24:26', '2026-03-14 10:24:26'),
(52, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-15 12:16:03', '2026-03-15 12:16:03'),
(53, 3, 'updated', 'App\\Models\\Courrier', 12, '\"{\\\"id\\\":12,\\\"num_enregistrement\\\":\\\"REG-2026-698879A786900\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"000222\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08T00:00:00.000000Z\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"sign\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770551719_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.doc.pdf\\\",\\\"created_at\\\":\\\"2026-02-08T11:55:19.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-13T22:43:31.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":9,\\\"signed_at\\\":\\\"2026-03-13 22:43:31\\\"}\"', '\"{\\\"id\\\":12,\\\"num_enregistrement\\\":\\\"REG-2026-698879A786900\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"000222\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai coffre fort\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08\\\",\\\"date_document_original\\\":null,\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770551719_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.doc.pdf\\\",\\\"created_at\\\":\\\"2026-02-08 11:55:19\\\",\\\"updated_at\\\":\\\"2026-03-15 14:05:31\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":9,\\\"signed_at\\\":\\\"2026-03-13 22:43:31\\\"}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-15 14:05:31', '2026-03-15 14:05:31'),
(54, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 00:26:57', '2026-03-16 00:26:57'),
(55, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 07:57:56', '2026-03-16 07:57:56'),
(56, 3, 'updated', 'App\\Models\\Courrier', 24, '\"{\\\"id\\\":24,\\\"num_enregistrement\\\":\\\"REG-2026-699EFF520BF38\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"00112233\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-25T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-02-24\\\",\\\"expediteur_nom\\\":\\\"SAPH\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"S\\\\\\/D GUDEF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1772027730_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\\\",\\\"created_at\\\":\\\"2026-02-25T13:55:30.000000Z\\\",\\\"updated_at\\\":\\\"2026-02-25T13:55:30.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6Im41OU9UUmdxdWZrcUVTbVB5blpLaGc9PSIsInZhbHVlIjoiTzM0S3ZSNmprU1pzbWdFakVtdUQ0QT09IiwibWFjIjoiMTU0ZDJiYTQ2ODEwZWEyMGJjODU4MDA4YjEyMjI0MDRkNWYxY2IwZDNhZWEzOTNiOGU4OGIwODY1NDY3ZmUyMiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":24,\\\"num_enregistrement\\\":\\\"REG-2026-699EFF520BF38\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"00112233\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-25\\\",\\\"date_document_original\\\":\\\"2026-02-24\\\",\\\"expediteur_nom\\\":\\\"SAPH\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"S\\\\\\/D GUDEF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1772027730_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\\\",\\\"created_at\\\":\\\"2026-02-25 13:55:30\\\",\\\"updated_at\\\":\\\"2026-03-16 08:10:40\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6Im41OU9UUmdxdWZrcUVTbVB5blpLaGc9PSIsInZhbHVlIjoiTzM0S3ZSNmprU1pzbWdFakVtdUQ0QT09IiwibWFjIjoiMTU0ZDJiYTQ2ODEwZWEyMGJjODU4MDA4YjEyMjI0MDRkNWYxY2IwZDNhZWEzOTNiOGU4OGIwODY1NDY3ZmUyMiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 08:10:40', '2026-03-16 08:10:40'),
(57, 3, 'updated', 'App\\Models\\Courrier', 16, '\"{\\\"id\\\":16,\\\"num_enregistrement\\\":\\\"REG-2026-6988FAE56E213\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"01102323\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai courrier\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2025-12-01\\\",\\\"expediteur_nom\\\":\\\"non sp\\\\u00e9cifi\\\\u00e9\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"Direction G\\\\u00e9n\\\\u00e9rale\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770584805_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.doc\\\",\\\"created_at\\\":\\\"2026-02-08T21:06:45.000000Z\\\",\\\"updated_at\\\":\\\"2026-02-08T21:06:45.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":16,\\\"num_enregistrement\\\":\\\"REG-2026-6988FAE56E213\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"01102323\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"essai courrier\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-02-08\\\",\\\"date_document_original\\\":\\\"2025-12-01\\\",\\\"expediteur_nom\\\":\\\"non sp\\\\u00e9cifi\\\\u00e9\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"Direction G\\\\u00e9n\\\\u00e9rale\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1770584805_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.doc\\\",\\\"created_at\\\":\\\"2026-02-08 21:06:45\\\",\\\"updated_at\\\":\\\"2026-03-16 08:42:53\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 08:42:53', '2026-03-16 08:42:53'),
(58, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 07:16:48', '2026-03-17 07:16:48'),
(59, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 10:29:46', '2026-03-17 10:29:46'),
(60, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nafie410@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 10:41:51', '2026-03-17 10:41:51'),
(61, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nafie410@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 10:44:21', '2026-03-17 10:44:21'),
(62, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 10:47:55', '2026-03-17 10:47:55'),
(63, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:29:24', '2026-03-17 13:29:24'),
(64, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:45:28', '2026-03-17 13:45:28'),
(65, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:46:25', '2026-03-17 13:46:25'),
(66, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/password/reset', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:52:19', '2026-03-17 13:52:19'),
(67, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:52:58', '2026-03-17 13:52:58'),
(68, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/password/reset', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:55:06', '2026-03-17 13:55:06'),
(69, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:56:01', '2026-03-17 13:56:01'),
(70, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 13:58:21', '2026-03-17 13:58:21'),
(71, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 14:14:32', '2026-03-17 14:14:32'),
(72, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 14:15:50', '2026-03-17 14:15:50'),
(73, 9, 'Connexion réussie', 'Système', 9, NULL, '\"{\\\"email\\\":\\\"iadico@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 06:32:24', '2026-03-19 06:32:24'),
(74, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 06:34:13', '2026-03-19 06:34:13'),
(75, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 06:55:00', '2026-03-19 06:55:00'),
(76, 9, 'Connexion réussie', 'Système', 9, NULL, '\"{\\\"email\\\":\\\"iadico@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 07:06:36', '2026-03-19 07:06:36'),
(77, 9, 'Connexion réussie', 'Système', 9, NULL, '\"{\\\"email\\\":\\\"iadico@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 07:07:43', '2026-03-19 07:07:43'),
(78, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 07:07:57', '2026-03-19 07:07:57'),
(79, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 09:14:06', '2026-03-19 09:14:06'),
(80, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 09:14:06', '2026-03-19 09:14:06'),
(81, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 09:55:42', '2026-03-19 09:55:42'),
(82, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 09:55:42', '2026-03-19 09:55:42'),
(83, 3, 'created', 'App\\Models\\Courrier', 25, NULL, '\"{\\\"reference\\\":\\\"X01\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste verifier\\\",\\\"date_courrier\\\":\\\"2026-03-19 00:00:00\\\",\\\"expediteur_nom\\\":\\\"france telecom\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"chemin_fichier\\\":\\\"1773918646_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"is_confidentiel\\\":true,\\\"code_acces\\\":\\\"eyJpdiI6IjJIU05Jci8yRHNpNkFzVTE5dXBVQ0E9PSIsInZhbHVlIjoiWmMvQko1ZVByUG13UG9SK2M5NDhRZz09IiwibWFjIjoiYjBlOTFkZjYyNGMyNTVkYjQxYjlkNzdjMjkyYTdiMDQwMGExNTJjYjU2M2JjZDFlYmNiNjA1MGJiNzY3M2I3MyIsInRhZyI6IiJ9\\\",\\\"date_document_original\\\":\\\"2026-03-11\\\",\\\"num_enregistrement\\\":\\\"REG-2026-69BBD9B60F33A\\\",\\\"affecter\\\":0,\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"updated_at\\\":\\\"2026-03-19 11:10:46\\\",\\\"created_at\\\":\\\"2026-03-19 11:10:46\\\",\\\"id\\\":25}\"', 'http://127.0.0.1:8000/courriers', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 11:10:46', '2026-03-19 11:10:46'),
(84, 3, 'updated', 'App\\Models\\Courrier', 25, '\"{\\\"id\\\":25,\\\"num_enregistrement\\\":\\\"REG-2026-69BBD9B60F33A\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"X01\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste verifier\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-19T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-03-11\\\",\\\"expediteur_nom\\\":\\\"france telecom\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1773918646_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"created_at\\\":\\\"2026-03-19T11:10:46.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-19T11:10:46.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IjJIU05Jci8yRHNpNkFzVTE5dXBVQ0E9PSIsInZhbHVlIjoiWmMvQko1ZVByUG13UG9SK2M5NDhRZz09IiwibWFjIjoiYjBlOTFkZjYyNGMyNTVkYjQxYjlkNzdjMjkyYTdiMDQwMGExNTJjYjU2M2JjZDFlYmNiNjA1MGJiNzY3M2I3MyIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":25,\\\"num_enregistrement\\\":\\\"REG-2026-69BBD9B60F33A\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"X01\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"juste verifier\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-19\\\",\\\"date_document_original\\\":\\\"2026-03-11\\\",\\\"expediteur_nom\\\":\\\"france telecom\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1773918646_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"created_at\\\":\\\"2026-03-19 11:10:46\\\",\\\"updated_at\\\":\\\"2026-03-19 11:11:54\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IjJIU05Jci8yRHNpNkFzVTE5dXBVQ0E9PSIsInZhbHVlIjoiWmMvQko1ZVByUG13UG9SK2M5NDhRZz09IiwibWFjIjoiYjBlOTFkZjYyNGMyNTVkYjQxYjlkNzdjMjkyYTdiMDQwMGExNTJjYjU2M2JjZDFlYmNiNjA1MGJiNzY3M2I3MyIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 11:11:54', '2026-03-19 11:11:54'),
(85, 3, 'created', 'App\\Models\\Courrier', 26, NULL, '\"{\\\"reference\\\":\\\"X02\\\",\\\"type\\\":\\\"Incoming Externe\\\",\\\"objet\\\":\\\"cvfdghg\\\",\\\"date_courrier\\\":\\\"2026-03-19 00:00:00\\\",\\\"expediteur_nom\\\":\\\"DIRECTION BUDGET\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"chemin_fichier\\\":\\\"1773919082_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.pdf\\\",\\\"is_confidentiel\\\":true,\\\"code_acces\\\":\\\"eyJpdiI6IlEzY0phdHFteFlXMTduRE16dU1uSEE9PSIsInZhbHVlIjoic0JCWldDQ2tseHE2Ynd6UEZOVGVhUT09IiwibWFjIjoiZTg1ZDEyZWQzNTQzZmU2MmM0NWRhOGM3ZWIwYWY4MTEyZjY4ZmM5YzFlY2Q0NDhiNTE4ZTQ2NDZiMjYwM2Q0ZiIsInRhZyI6IiJ9\\\",\\\"date_document_original\\\":\\\"2026-03-12\\\",\\\"num_enregistrement\\\":\\\"REG-2026-69BBDB6AAB80B\\\",\\\"affecter\\\":0,\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"updated_at\\\":\\\"2026-03-19 11:18:02\\\",\\\"created_at\\\":\\\"2026-03-19 11:18:02\\\",\\\"id\\\":26}\"', 'http://127.0.0.1:8000/courriers', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 11:18:02', '2026-03-19 11:18:02'),
(86, 3, 'created', 'App\\Models\\Courrier', 27, NULL, '\"{\\\"reference\\\":\\\"X02022\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"BHJKKL\\\",\\\"date_courrier\\\":\\\"2026-03-19 00:00:00\\\",\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"chemin_fichier\\\":\\\"1773931720_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"code_acces\\\":null,\\\"date_document_original\\\":\\\"2026-03-10\\\",\\\"num_enregistrement\\\":\\\"REG-2026-69BC0CC8607A3\\\",\\\"affecter\\\":0,\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"is_confidentiel\\\":false,\\\"updated_at\\\":\\\"2026-03-19 14:48:40\\\",\\\"created_at\\\":\\\"2026-03-19 14:48:40\\\",\\\"id\\\":27}\"', 'http://127.0.0.1:8000/courriers', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 14:48:40', '2026-03-19 14:48:40'),
(87, 3, 'updated', 'App\\Models\\Courrier', 27, '\"{\\\"id\\\":27,\\\"num_enregistrement\\\":\\\"REG-2026-69BC0CC8607A3\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"X02022\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"BHJKKL\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-19T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-03-10\\\",\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1773931720_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"created_at\\\":\\\"2026-03-19T14:48:40.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-19T14:48:40.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":27,\\\"num_enregistrement\\\":\\\"REG-2026-69BC0CC8607A3\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"X02022\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"BHJKKL\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-19\\\",\\\"date_document_original\\\":\\\"2026-03-10\\\",\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1773931720_Projet_de_Note_du_DSESF_au_DG_S\\\\u00e9minaire_Loi_de_r\\\\u00e8glement_18_20_d\\\\u00e9c_2024.pdf\\\",\\\"created_at\\\":\\\"2026-03-19 14:48:40\\\",\\\"updated_at\\\":\\\"2026-03-19 14:51:56\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 14:51:57', '2026-03-19 14:51:57');
INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `method`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(88, 3, 'updated', 'App\\Models\\Courrier', 26, '\"{\\\"id\\\":26,\\\"num_enregistrement\\\":\\\"REG-2026-69BBDB6AAB80B\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"X02\\\",\\\"type\\\":\\\"Incoming Externe\\\",\\\"objet\\\":\\\"cvfdghg\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-19T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-03-12\\\",\\\"expediteur_nom\\\":\\\"DIRECTION BUDGET\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1773919082_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.pdf\\\",\\\"created_at\\\":\\\"2026-03-19T11:18:02.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-19T11:18:02.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IlEzY0phdHFteFlXMTduRE16dU1uSEE9PSIsInZhbHVlIjoic0JCWldDQ2tseHE2Ynd6UEZOVGVhUT09IiwibWFjIjoiZTg1ZDEyZWQzNTQzZmU2MmM0NWRhOGM3ZWIwYWY4MTEyZjY4ZmM5YzFlY2Q0NDhiNTE4ZTQ2NDZiMjYwM2Q0ZiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":26,\\\"num_enregistrement\\\":\\\"REG-2026-69BBDB6AAB80B\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"X02\\\",\\\"type\\\":\\\"Incoming Externe\\\",\\\"objet\\\":\\\"cvfdghg\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-19\\\",\\\"date_document_original\\\":\\\"2026-03-12\\\",\\\"expediteur_nom\\\":\\\"DIRECTION BUDGET\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1773919082_Note_Service_Objectifs_de_recettes_r\\\\u00e9vis\\\\u00e9s_2025_N\'GUESSAN.pdf\\\",\\\"created_at\\\":\\\"2026-03-19 11:18:02\\\",\\\"updated_at\\\":\\\"2026-03-19 14:59:47\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IlEzY0phdHFteFlXMTduRE16dU1uSEE9PSIsInZhbHVlIjoic0JCWldDQ2tseHE2Ynd6UEZOVGVhUT09IiwibWFjIjoiZTg1ZDEyZWQzNTQzZmU2MmM0NWRhOGM3ZWIwYWY4MTEyZjY4ZmM5YzFlY2Q0NDhiNTE4ZTQ2NDZiMjYwM2Q0ZiIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 14:59:47', '2026-03-19 14:59:47'),
(89, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 06:47:03', '2026-03-23 06:47:03'),
(90, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 06:47:03', '2026-03-23 06:47:03'),
(91, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 12:30:14', '2026-03-23 12:30:14'),
(92, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 12:30:14', '2026-03-23 12:30:14'),
(93, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 09:27:42', '2026-03-24 09:27:42'),
(94, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 09:27:42', '2026-03-24 09:27:42'),
(95, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 15:10:04', '2026-03-24 15:10:04'),
(96, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 15:10:04', '2026-03-24 15:10:04'),
(97, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 22:33:36', '2026-03-24 22:33:36'),
(98, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 22:33:36', '2026-03-24 22:33:36'),
(99, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 11:39:57', '2026-03-25 11:39:57'),
(100, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 11:39:57', '2026-03-25 11:39:57'),
(101, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 12:48:20', '2026-03-25 12:48:20'),
(102, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 12:48:20', '2026-03-25 12:48:20'),
(103, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 12:49:05', '2026-03-25 12:49:05'),
(104, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 12:49:05', '2026-03-25 12:49:05'),
(105, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 12:57:51', '2026-03-25 12:57:51'),
(106, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 12:57:51', '2026-03-25 12:57:51'),
(107, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:30:58', '2026-03-25 13:30:58'),
(108, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:30:58', '2026-03-25 13:30:58'),
(109, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:35:18', '2026-03-25 13:35:18'),
(110, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:35:18', '2026-03-25 13:35:18'),
(111, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:36:24', '2026-03-25 13:36:24'),
(112, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:36:24', '2026-03-25 13:36:24'),
(113, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:41:05', '2026-03-25 13:41:05'),
(114, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:41:05', '2026-03-25 13:41:05'),
(115, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:41:57', '2026-03-25 13:41:57'),
(116, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:41:57', '2026-03-25 13:41:57'),
(117, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:55:53', '2026-03-25 13:55:53'),
(118, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:55:53', '2026-03-25 13:55:53'),
(119, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:56:27', '2026-03-25 13:56:27'),
(120, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 13:56:27', '2026-03-25 13:56:27'),
(121, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:02:45', '2026-03-25 14:02:45'),
(122, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:02:45', '2026-03-25 14:02:45'),
(123, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:03:34', '2026-03-25 14:03:34'),
(124, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:03:34', '2026-03-25 14:03:34'),
(125, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:33:45', '2026-03-25 14:33:45'),
(126, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:33:45', '2026-03-25 14:33:45'),
(127, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:41:05', '2026-03-25 14:41:05'),
(128, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:41:05', '2026-03-25 14:41:05'),
(129, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 16:38:52', '2026-03-25 16:38:52'),
(130, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 16:38:52', '2026-03-25 16:38:52'),
(131, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 16:39:54', '2026-03-25 16:39:54'),
(132, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 16:39:54', '2026-03-25 16:39:54'),
(133, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 22:39:15', '2026-03-25 22:39:15'),
(134, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 22:39:15', '2026-03-25 22:39:15'),
(135, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 08:22:43', '2026-03-26 08:22:43'),
(136, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 08:22:43', '2026-03-26 08:22:43'),
(137, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:12:44', '2026-03-26 09:12:44'),
(138, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:12:44', '2026-03-26 09:12:44'),
(139, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:18:30', '2026-03-26 09:18:30'),
(140, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:18:30', '2026-03-26 09:18:30'),
(141, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 15:28:31', '2026-03-26 15:28:31'),
(142, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 15:28:31', '2026-03-26 15:28:31'),
(143, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 15:29:33', '2026-03-26 15:29:33'),
(144, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 15:29:33', '2026-03-26 15:29:33'),
(145, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 15:30:35', '2026-03-26 15:30:35'),
(146, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 15:30:35', '2026-03-26 15:30:35'),
(147, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 18:00:55', '2026-03-26 18:00:55'),
(148, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 18:00:55', '2026-03-26 18:00:55'),
(149, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 18:03:03', '2026-03-26 18:03:03'),
(150, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 18:03:03', '2026-03-26 18:03:03'),
(151, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 18:04:24', '2026-03-26 18:04:24'),
(152, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 18:04:24', '2026-03-26 18:04:24'),
(153, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 09:07:55', '2026-03-27 09:07:55'),
(154, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 09:07:55', '2026-03-27 09:07:55'),
(155, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 13:07:18', '2026-03-27 13:07:18'),
(156, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 13:07:18', '2026-03-27 13:07:18'),
(157, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 08:04:27', '2026-03-28 08:04:27'),
(158, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 08:04:27', '2026-03-28 08:04:27'),
(159, 3, 'created', 'App\\Models\\Courrier', 28, NULL, '\"{\\\"reference\\\":\\\"252525\\\",\\\"type\\\":\\\"Incoming Mail\\\",\\\"objet\\\":\\\"Mail du DG concernant une formation\\\",\\\"date_courrier\\\":\\\"2026-03-28 00:00:00\\\",\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"chemin_fichier\\\":\\\"1774685143_Compte_d\\\\u00e9biteur_02-03-2026_13.56.pdf\\\",\\\"code_acces\\\":null,\\\"date_document_original\\\":\\\"2026-03-27\\\",\\\"num_enregistrement\\\":\\\"REG-2026-69C78BD78C7B1\\\",\\\"affecter\\\":0,\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"is_confidentiel\\\":false,\\\"updated_at\\\":\\\"2026-03-28 08:05:43\\\",\\\"created_at\\\":\\\"2026-03-28 08:05:43\\\",\\\"id\\\":28}\"', 'http://127.0.0.1:8000/courriers', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 08:05:43', '2026-03-28 08:05:43'),
(160, 3, 'updated', 'App\\Models\\Courrier', 28, '\"{\\\"id\\\":28,\\\"num_enregistrement\\\":\\\"REG-2026-69C78BD78C7B1\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"252525\\\",\\\"type\\\":\\\"Incoming Mail\\\",\\\"objet\\\":\\\"Mail du DG concernant une formation\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-28T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-03-27\\\",\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1774685143_Compte_d\\\\u00e9biteur_02-03-2026_13.56.pdf\\\",\\\"created_at\\\":\\\"2026-03-28T08:05:43.000000Z\\\",\\\"updated_at\\\":\\\"2026-03-28T08:05:43.000000Z\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":28,\\\"num_enregistrement\\\":\\\"REG-2026-69C78BD78C7B1\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"252525\\\",\\\"type\\\":\\\"Incoming Mail\\\",\\\"objet\\\":\\\"Mail du DG concernant une formation\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-03-28\\\",\\\"date_document_original\\\":\\\"2026-03-27\\\",\\\"expediteur_nom\\\":\\\"Cabinet DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1774685143_Compte_d\\\\u00e9biteur_02-03-2026_13.56.pdf\\\",\\\"created_at\\\":\\\"2026-03-28 08:05:43\\\",\\\"updated_at\\\":\\\"2026-03-28 08:07:18\\\",\\\"is_confidentiel\\\":0,\\\"code_acces\\\":null,\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 08:07:18', '2026-03-28 08:07:18'),
(161, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 10:23:27', '2026-03-28 10:23:27'),
(162, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 10:23:27', '2026-03-28 10:23:27'),
(163, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 11:54:23', '2026-03-29 11:54:23'),
(164, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 11:54:23', '2026-03-29 11:54:23'),
(165, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 16:13:50', '2026-03-29 16:13:50'),
(166, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 16:13:50', '2026-03-29 16:13:50'),
(167, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:16:38', '2026-03-30 09:16:38'),
(168, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:16:38', '2026-03-30 09:16:38'),
(169, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 07:13:43', '2026-03-31 07:13:43'),
(170, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 07:13:43', '2026-03-31 07:13:43'),
(171, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 07:36:36', '2026-04-01 07:36:36'),
(172, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 07:36:36', '2026-04-01 07:36:36'),
(173, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:15:47', '2026-04-01 09:15:47'),
(174, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:15:47', '2026-04-01 09:15:47'),
(175, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:23:01', '2026-04-01 09:23:01'),
(176, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:23:01', '2026-04-01 09:23:01'),
(177, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:26:07', '2026-04-01 09:26:07'),
(178, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:26:07', '2026-04-01 09:26:07'),
(179, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:44:42', '2026-04-01 09:44:42'),
(180, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:44:42', '2026-04-01 09:44:42'),
(181, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:47:16', '2026-04-01 09:47:16'),
(182, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:47:16', '2026-04-01 09:47:16'),
(183, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:48:43', '2026-04-01 09:48:43'),
(184, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:48:43', '2026-04-01 09:48:43'),
(185, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:49:39', '2026-04-01 09:49:39'),
(186, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 09:49:39', '2026-04-01 09:49:39'),
(187, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:00:41', '2026-04-01 10:00:41'),
(188, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:00:41', '2026-04-01 10:00:41'),
(189, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:01:42', '2026-04-01 10:01:42'),
(190, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:01:42', '2026-04-01 10:01:42'),
(191, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:06:41', '2026-04-01 10:06:41'),
(192, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:06:41', '2026-04-01 10:06:41'),
(193, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:20:17', '2026-04-01 10:20:17'),
(194, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:20:17', '2026-04-01 10:20:17'),
(195, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:20:59', '2026-04-01 10:20:59'),
(196, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:20:59', '2026-04-01 10:20:59'),
(197, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:26:38', '2026-04-01 10:26:38'),
(198, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:26:38', '2026-04-01 10:26:38'),
(199, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:40:19', '2026-04-01 10:40:19'),
(200, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 10:40:19', '2026-04-01 10:40:19'),
(201, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:06:59', '2026-04-01 13:06:59'),
(202, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:06:59', '2026-04-01 13:06:59'),
(203, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:07:23', '2026-04-01 13:07:23'),
(204, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:07:23', '2026-04-01 13:07:23'),
(205, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:54:37', '2026-04-01 14:54:37'),
(206, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:54:37', '2026-04-01 14:54:37'),
(207, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:54:52', '2026-04-01 14:54:52'),
(208, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:54:52', '2026-04-01 14:54:52'),
(209, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:58:50', '2026-04-01 14:58:50'),
(210, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:58:50', '2026-04-01 14:58:50'),
(211, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:59:08', '2026-04-01 14:59:08'),
(212, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 14:59:08', '2026-04-01 14:59:08'),
(213, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 15:13:50', '2026-04-01 15:13:50'),
(214, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 15:13:50', '2026-04-01 15:13:50'),
(215, 3, 'created', 'App\\Models\\Courrier', 29, NULL, '\"{\\\"reference\\\":\\\"2026-04-01_152252\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"Programmation hebdomadaire\\\",\\\"date_courrier\\\":\\\"2026-04-01 00:00:00\\\",\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"chemin_fichier\\\":\\\"1775057137_2026-04-01_152252.pdf\\\",\\\"is_confidentiel\\\":true,\\\"code_acces\\\":\\\"eyJpdiI6ImZoODN6NEZQRjE2VG4yakNwbFFlS3c9PSIsInZhbHVlIjoiSnpwWnk1R29wT01zL2N1MmJWZkg4UT09IiwibWFjIjoiYzNhNGNlNWNiYThhYTIzNDg5MGM5MmU1NDI0YWI4MTRmMWU0OTU2OTk0YTA4NzMzNjZkZTlhYzcxODFkZWZjYSIsInRhZyI6IiJ9\\\",\\\"date_document_original\\\":\\\"2026-03-31\\\",\\\"num_enregistrement\\\":\\\"REG-2026-69CD38F125415\\\",\\\"affecter\\\":0,\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"updated_at\\\":\\\"2026-04-01 15:25:37\\\",\\\"created_at\\\":\\\"2026-04-01 15:25:37\\\",\\\"id\\\":29}\"', 'http://127.0.0.1:8000/courriers', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 15:25:37', '2026-04-01 15:25:37'),
(216, 3, 'updated', 'App\\Models\\Courrier', 29, '\"{\\\"id\\\":29,\\\"num_enregistrement\\\":\\\"REG-2026-69CD38F125415\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"2026-04-01_152252\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"Programmation hebdomadaire\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-04-01T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-03-31\\\",\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1775057137_2026-04-01_152252.pdf\\\",\\\"created_at\\\":\\\"2026-04-01T15:25:37.000000Z\\\",\\\"updated_at\\\":\\\"2026-04-01T15:25:37.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6ImZoODN6NEZQRjE2VG4yakNwbFFlS3c9PSIsInZhbHVlIjoiSnpwWnk1R29wT01zL2N1MmJWZkg4UT09IiwibWFjIjoiYzNhNGNlNWNiYThhYTIzNDg5MGM5MmU1NDI0YWI4MTRmMWU0OTU2OTk0YTA4NzMzNjZkZTlhYzcxODFkZWZjYSIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":29,\\\"num_enregistrement\\\":\\\"REG-2026-69CD38F125415\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"2026-04-01_152252\\\",\\\"type\\\":\\\"Incoming\\\",\\\"objet\\\":\\\"Programmation hebdomadaire\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-04-01\\\",\\\"date_document_original\\\":\\\"2026-03-31\\\",\\\"expediteur_nom\\\":\\\"CABINET DGI\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"DSESF\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1775057137_2026-04-01_152252.pdf\\\",\\\"created_at\\\":\\\"2026-04-01 15:25:37\\\",\\\"updated_at\\\":\\\"2026-04-01 15:27:21\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6ImZoODN6NEZQRjE2VG4yakNwbFFlS3c9PSIsInZhbHVlIjoiSnpwWnk1R29wT01zL2N1MmJWZkg4UT09IiwibWFjIjoiYzNhNGNlNWNiYThhYTIzNDg5MGM5MmU1NDI0YWI4MTRmMWU0OTU2OTk0YTA4NzMzNjZkZTlhYzcxODFkZWZjYSIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 15:27:21', '2026-04-01 15:27:21'),
(217, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:46:34', '2026-04-01 16:46:34'),
(218, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:46:34', '2026-04-01 16:46:34'),
(219, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:55:07', '2026-04-01 16:55:07');
INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `method`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(220, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:55:07', '2026-04-01 16:55:07'),
(221, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1773309946.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1775062542.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature/update', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:55:42', '2026-04-01 16:55:42'),
(222, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1775062542.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1775062609.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature/update', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:56:49', '2026-04-01 16:56:49'),
(223, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1775062609.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1775062620.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature/update', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 16:57:00', '2026-04-01 16:57:00'),
(224, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1775062620.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1775062902.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature/update', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 17:01:42', '2026-04-01 17:01:42'),
(225, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1775062902.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1775063016.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature/update', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 17:03:36', '2026-04-01 17:03:36'),
(226, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 08:03:24', '2026-04-02 08:03:24'),
(227, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 08:03:24', '2026-04-02 08:03:24'),
(228, 3, 'Mise à jour signature pad', 'User', 3, '\"{\\\"path\\\":\\\"pad_3_1775063016.png\\\"}\"', '\"{\\\"path\\\":\\\"pad_3_1775121779.png\\\"}\"', 'http://127.0.0.1:8000/profile/signature/update', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:22:59', '2026-04-02 09:22:59'),
(229, 3, 'created', 'App\\Models\\Courrier', 30, NULL, '\"{\\\"reference\\\":\\\"111444\\\",\\\"type\\\":\\\"Outgoing\\\",\\\"objet\\\":\\\"Projet de note du DG\\\",\\\"date_courrier\\\":\\\"2026-04-02 00:00:00\\\",\\\"expediteur_nom\\\":\\\"DSESF\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"Cabinet DG\\\",\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"chemin_fichier\\\":\\\"1775122794_2026-04-01_152252.pdf\\\",\\\"is_confidentiel\\\":true,\\\"code_acces\\\":\\\"eyJpdiI6IkxGRnowb3FEdFYrb3lZNFJzanp0dmc9PSIsInZhbHVlIjoidlF4djY5UzVKekMrUFB6cklYOTJmQT09IiwibWFjIjoiOTk0ODNjNzVjMzgzN2U5NTdhZWJhZGY3OTBjMmY4ZTg0MTdhNDFhNzc5MDk5ODc0NmQwYzkyNWExNDdkMDJiNCIsInRhZyI6IiJ9\\\",\\\"date_document_original\\\":\\\"2026-04-02\\\",\\\"num_enregistrement\\\":\\\"REG-2026-69CE396A3419F\\\",\\\"affecter\\\":0,\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"updated_at\\\":\\\"2026-04-02 09:39:54\\\",\\\"created_at\\\":\\\"2026-04-02 09:39:54\\\",\\\"id\\\":30}\"', 'http://127.0.0.1:8000/courriers', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:39:54', '2026-04-02 09:39:54'),
(230, 3, 'updated', 'App\\Models\\Courrier', 30, '\"{\\\"id\\\":30,\\\"num_enregistrement\\\":\\\"REG-2026-69CE396A3419F\\\",\\\"affecter\\\":false,\\\"reference\\\":\\\"111444\\\",\\\"type\\\":\\\"Outgoing\\\",\\\"objet\\\":\\\"Projet de note du DG\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-04-02T00:00:00.000000Z\\\",\\\"date_document_original\\\":\\\"2026-04-02\\\",\\\"expediteur_nom\\\":\\\"DSESF\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"Cabinet DG\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"re\\\\u00e7u\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1775122794_2026-04-01_152252.pdf\\\",\\\"created_at\\\":\\\"2026-04-02T09:39:54.000000Z\\\",\\\"updated_at\\\":\\\"2026-04-02T09:39:54.000000Z\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IkxGRnowb3FEdFYrb3lZNFJzanp0dmc9PSIsInZhbHVlIjoidlF4djY5UzVKekMrUFB6cklYOTJmQT09IiwibWFjIjoiOTk0ODNjNzVjMzgzN2U5NTdhZWJhZGY3OTBjMmY4ZTg0MTdhNDFhNzc5MDk5ODc0NmQwYzkyNWExNDdkMDJiNCIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', '\"{\\\"id\\\":30,\\\"num_enregistrement\\\":\\\"REG-2026-69CE396A3419F\\\",\\\"affecter\\\":1,\\\"reference\\\":\\\"111444\\\",\\\"type\\\":\\\"Outgoing\\\",\\\"objet\\\":\\\"Projet de note du DG\\\",\\\"description\\\":null,\\\"date_courrier\\\":\\\"2026-04-02\\\",\\\"date_document_original\\\":\\\"2026-04-02\\\",\\\"expediteur_nom\\\":\\\"DSESF\\\",\\\"expediteur_contact\\\":null,\\\"destinataire_nom\\\":\\\"Cabinet DG\\\",\\\"destinataire_contact\\\":null,\\\"statut\\\":\\\"affect\\\\u00e9\\\",\\\"assigne_a\\\":\\\"Non assign\\\\u00e9\\\",\\\"chemin_fichier\\\":\\\"1775122794_2026-04-01_152252.pdf\\\",\\\"created_at\\\":\\\"2026-04-02 09:39:54\\\",\\\"updated_at\\\":\\\"2026-04-02 09:41:40\\\",\\\"is_confidentiel\\\":1,\\\"code_acces\\\":\\\"eyJpdiI6IkxGRnowb3FEdFYrb3lZNFJzanp0dmc9PSIsInZhbHVlIjoidlF4djY5UzVKekMrUFB6cklYOTJmQT09IiwibWFjIjoiOTk0ODNjNzVjMzgzN2U5NTdhZWJhZGY3OTBjMmY4ZTg0MTdhNDFhNzc5MDk5ODc0NmQwYzkyNWExNDdkMDJiNCIsInRhZyI6IiJ9\\\",\\\"signed_by\\\":null,\\\"signed_at\\\":null}\"', 'http://127.0.0.1:8000/imputations', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:41:40', '2026-04-02 09:41:40'),
(231, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:44:58', '2026-04-02 09:44:58'),
(232, 4, 'Connexion réussie', 'Système', 4, NULL, '\"{\\\"email\\\":\\\"nkone05@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:44:58', '2026-04-02 09:44:58'),
(233, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:46:05', '2026-04-02 09:46:05'),
(234, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:46:05', '2026-04-02 09:46:05'),
(235, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:49:54', '2026-04-02 09:49:54'),
(236, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:49:54', '2026-04-02 09:49:54'),
(237, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:50:50', '2026-04-02 09:50:50'),
(238, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:50:50', '2026-04-02 09:50:50'),
(239, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:06:10', '2026-04-02 10:06:10'),
(240, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:06:10', '2026-04-02 10:06:10'),
(241, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:14:13', '2026-04-02 10:14:13'),
(242, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:14:13', '2026-04-02 10:14:13'),
(243, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:18:13', '2026-04-02 10:18:13'),
(244, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:18:13', '2026-04-02 10:18:13'),
(245, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:20:26', '2026-04-02 10:20:26'),
(246, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:20:26', '2026-04-02 10:20:26'),
(247, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:22:06', '2026-04-02 10:22:06'),
(248, 6, 'Connexion réussie', 'Système', 6, NULL, '\"{\\\"email\\\":\\\"andoume@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:22:06', '2026-04-02 10:22:06'),
(249, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:24:12', '2026-04-02 10:24:12'),
(250, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 10:24:12', '2026-04-02 10:24:12'),
(251, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 11:16:36', '2026-04-02 11:16:36'),
(252, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 11:16:36', '2026-04-02 11:16:36'),
(253, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-03 07:34:27', '2026-04-03 07:34:27'),
(254, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-03 07:34:27', '2026-04-03 07:34:27'),
(255, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-03 12:15:31', '2026-04-03 12:15:31'),
(256, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-03 12:15:31', '2026-04-03 12:15:31'),
(257, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-03 14:55:58', '2026-04-03 14:55:58'),
(258, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-03 14:55:58', '2026-04-03 14:55:58'),
(259, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-04 09:04:51', '2026-04-04 09:04:51'),
(260, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-04 09:04:51', '2026-04-04 09:04:51'),
(261, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-04 21:44:17', '2026-04-04 21:44:17'),
(262, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-04 21:44:17', '2026-04-04 21:44:17'),
(263, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-05 13:15:36', '2026-04-05 13:15:36'),
(264, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-05 13:15:36', '2026-04-05 13:15:36'),
(265, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-05 22:29:40', '2026-04-05 22:29:40'),
(266, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-05 22:29:40', '2026-04-05 22:29:40'),
(267, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 10:12:09', '2026-04-06 10:12:09'),
(268, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 10:12:09', '2026-04-06 10:12:09'),
(269, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 16:59:44', '2026-04-06 16:59:44'),
(270, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 16:59:44', '2026-04-06 16:59:44'),
(271, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:35:58', '2026-04-07 09:35:58'),
(272, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:35:58', '2026-04-07 09:35:58'),
(273, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 13:47:26', '2026-04-07 13:47:26'),
(274, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 13:47:26', '2026-04-07 13:47:26'),
(275, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-08 07:33:02', '2026-04-08 07:33:02'),
(276, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-08 07:33:02', '2026-04-08 07:33:02'),
(277, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-08 13:34:57', '2026-04-08 13:34:57'),
(278, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-08 13:34:57', '2026-04-08 13:34:57'),
(279, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-09 07:24:05', '2026-04-09 07:24:05'),
(280, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-09 07:24:05', '2026-04-09 07:24:05'),
(281, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 08:35:10', '2026-04-13 08:35:10'),
(282, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 08:35:10', '2026-04-13 08:35:10'),
(283, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 11:55:41', '2026-04-13 11:55:41'),
(284, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 11:55:41', '2026-04-13 11:55:41'),
(285, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 14:51:28', '2026-04-13 14:51:28'),
(286, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 14:51:28', '2026-04-13 14:51:28'),
(287, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 09:49:16', '2026-04-14 09:49:16'),
(288, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 09:49:16', '2026-04-14 09:49:16'),
(289, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 15:06:06', '2026-04-14 15:06:06'),
(290, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 15:06:06', '2026-04-14 15:06:06'),
(291, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 08:19:05', '2026-04-15 08:19:05'),
(292, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 08:19:05', '2026-04-15 08:19:05'),
(293, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 11:09:41', '2026-04-15 11:09:41'),
(294, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 11:09:41', '2026-04-15 11:09:41'),
(295, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 07:39:51', '2026-04-16 07:39:51'),
(296, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 07:39:51', '2026-04-16 07:39:51'),
(297, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 10:50:21', '2026-04-16 10:50:21'),
(298, 3, 'Connexion réussie', 'Système', 3, NULL, '\"{\\\"email\\\":\\\"yacouba.coulibaly@dgi.gouv.ci\\\"}\"', 'http://127.0.0.1:8000/login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 10:50:21', '2026-04-16 10:50:21');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:8:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"creer-articles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"supprimer-articles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:17:\"voir-utilisateurs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:4;i:3;i:5;i:4;i:6;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"manage-users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:17:\"modifier articles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:18:\"supprimer articles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"gerer-roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:17:\"acceder-dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:5;i:4;i:6;}}}s:5:\"roles\";a:6:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"utilisateur\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"Superviseur\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:2:\"rh\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:7:\"Accueil\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"editeur\";s:1:\"c\";s:3:\"web\";}}}', 1776425955),
('laravel-cache-directions_list', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:20:\"App\\Models\\Direction\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:10:\"directions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:20:\"Cabinet du Directeur\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:20:\"Cabinet du Directeur\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:20:\"App\\Models\\Direction\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:10:\"directions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:54:\"Sous-Direction de la Planification et de la Stratégie\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:54:\"Sous-Direction de la Planification et de la Stratégie\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:20:\"App\\Models\\Direction\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:10:\"directions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:50:\"Sous-Direction de la Prévision et des Statitiques\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:50:\"Sous-Direction de la Prévision et des Statitiques\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:20:\"App\\Models\\Direction\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:10:\"directions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:49:\"Sous-Direction des Etudes et Evaluations Fiscales\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:49:\"Sous-Direction des Etudes et Evaluations Fiscales\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:20:\"App\\Models\\Direction\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:10:\"directions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:64:\"Sous-Direction du Guichet Unique de Dépôt des Etats Financiers\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:64:\"Sous-Direction du Guichet Unique de Dépôt des Etats Financiers\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1775474005),
('laravel-cache-services_list', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:20:{i:0;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:18:\"Appui Informatique\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:18:\"Appui Informatique\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:20;s:4:\"name\";s:17:\"Cabinet Directeur\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:20;s:4:\"name\";s:17:\"Cabinet Directeur\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:17;s:4:\"name\";s:41:\"Cabinet S/D Etude et Evaluations Fiscales\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:17;s:4:\"name\";s:41:\"Cabinet S/D Etude et Evaluations Fiscales\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:19;s:4:\"name\";s:17:\"Cabinet S/D GUDEF\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:19;s:4:\"name\";s:17:\"Cabinet S/D GUDEF\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:18;s:4:\"name\";s:39:\"Cabinet S/D Planification et Stratégie\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:18;s:4:\"name\";s:39:\"Cabinet S/D Planification et Stratégie\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:16;s:4:\"name\";s:38:\"Cabinet S/D Prévision et Statistiques\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:16;s:4:\"name\";s:38:\"Cabinet S/D Prévision et Statistiques\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:46:\"Servcide de la Documentation et des Activités\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:46:\"Servcide de la Documentation et des Activités\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:7;s:4:\"name\";s:27:\"Servcie des Etudes Fiscales\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:7;s:4:\"name\";s:27:\"Servcie des Etudes Fiscales\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:6;s:4:\"name\";s:54:\"Service d\'Analyse des Statitiques de Recettes Fiscales\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:6;s:4:\"name\";s:54:\"Service d\'Analyse des Statitiques de Recettes Fiscales\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:13;s:4:\"name\";s:48:\"Service d\'Analyse et d\'Exploitation des Données\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:13;s:4:\"name\";s:48:\"Service d\'Analyse et d\'Exploitation des Données\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:14;s:4:\"name\";s:56:\"Service d\'Appui au Dépôt en Ligne des Etats Financiers\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:14;s:4:\"name\";s:56:\"Service d\'Appui au Dépôt en Ligne des Etats Financiers\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:11;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:12;s:4:\"name\";s:54:\"Service de Gestion et d\'Archivage des Etats Financiers\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:12;s:4:\"name\";s:54:\"Service de Gestion et d\'Archivage des Etats Financiers\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:12;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:10;s:4:\"name\";s:57:\"Service de la Planification et de Suivi de la Performance\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:10;s:4:\"name\";s:57:\"Service de la Planification et de Suivi de la Performance\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:13;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:11;s:4:\"name\";s:33:\"Service de la Veille Stratégique\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:11;s:4:\"name\";s:33:\"Service de la Veille Stratégique\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:14;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:54:\"Service de Production et de Diffusion des Statistiques\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:54:\"Service de Production et de Diffusion des Statistiques\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:15;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:8;s:4:\"name\";s:51:\"Service des Etudes Sectorielles et des Monographies\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:8;s:4:\"name\";s:51:\"Service des Etudes Sectorielles et des Monographies\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:16;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:66:\"Service des Prévisions de Recettes et des Indicateurs Economiques\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:66:\"Service des Prévisions de Recettes et des Indicateurs Economiques\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:17;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:9;s:4:\"name\";s:42:\"Service des Simulations et des Evaluations\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:9;s:4:\"name\";s:42:\"Service des Simulations et des Evaluations\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:18;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:56:\"Service des Statitiques d\'Assiette et du Controle Fiscal\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:56:\"Service des Statitiques d\'Assiette et du Controle Fiscal\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:19;O:18:\"App\\Models\\Service\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:8:\"services\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:15;s:4:\"name\";s:61:\"Service Statistiques des Directions Centrales et Régionnales\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:15;s:4:\"name\";s:61:\"Service Statistiques des Directions Centrales et Régionnales\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:12:\"direction_id\";i:4;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1775474005),
('laravel-cache-directions_list_1', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:20:\"App\\Models\\Direction\":33:{s:13:\"\0*\0connection\";s:7:\"mariadb\";s:8:\"\0*\0table\";s:10:\"directions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:20:\"Cabinet du Directeur\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:20:\"Cabinet du Directeur\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:4:\"code\";i:2;s:11:\"description\";i:3;s:7:\"head_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1775656111),
('laravel-cache-boost.roster.scan', 'a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:7:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.56.0\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"v0.3.16\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:6:\"0.3.16\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.5.9\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.5.9\";s:6:\"\0*\0dev\";b:1;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.29.0\";s:6:\"\0*\0dev\";b:1;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.56.0\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:7:\"^11.5.3\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"11.5.55\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:6:\"4.1.17\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1775631199;}', 1775717599);

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contacts_email_unique` (`email`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `courriers`
--

DROP TABLE IF EXISTS `courriers`;
CREATE TABLE IF NOT EXISTS `courriers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `num_enregistrement` varchar(255) DEFAULT NULL,
  `affecter` tinyint(1) NOT NULL DEFAULT 0,
  `reference` varchar(191) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `objet` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_courrier` date NOT NULL,
  `date_document_original` date DEFAULT NULL,
  `expediteur_nom` varchar(191) NOT NULL,
  `expediteur_contact` varchar(191) DEFAULT NULL,
  `destinataire_nom` varchar(191) NOT NULL,
  `destinataire_contact` varchar(191) DEFAULT NULL,
  `statut` varchar(191) NOT NULL DEFAULT 'pending',
  `assigne_a` varchar(255) DEFAULT NULL,
  `chemin_fichier` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_confidentiel` tinyint(1) NOT NULL DEFAULT 0,
  `code_acces` varchar(255) DEFAULT NULL,
  `signed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `signed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courriers_num_enregistrement_unique` (`num_enregistrement`) USING HASH,
  KEY `courriers_signed_by_foreign` (`signed_by`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `courriers`
--

INSERT INTO `courriers` (`id`, `num_enregistrement`, `affecter`, `reference`, `type`, `objet`, `description`, `date_courrier`, `date_document_original`, `expediteur_nom`, `expediteur_contact`, `destinataire_nom`, `destinataire_contact`, `statut`, `assigne_a`, `chemin_fichier`, `created_at`, `updated_at`, `is_confidentiel`, `code_acces`, `signed_by`, `signed_at`) VALUES
(2, 'REG-2026-6971FEFAADDCF', 1, '000021', 'Outgoing', 'réponses de ls DSESF relative à une demande de stage et une demande de collecte de données sollicitées respectivement par Mlle DJAN Loukou Julienne et DOU Sopie Joëlle Priscae', NULL, '2026-01-21', NULL, 'DSESF', NULL, 'DFRC Direction de la Formation et du Renforcement de Capacité', NULL, 'affecté', 'Non assigné', '1769081946_000021__du_21_01_2026.pdf', '2026-01-22 10:42:02', '2026-01-28 09:42:44', 0, NULL, NULL, NULL),
(3, 'REG-2026-697203E79FCA1', 1, '0040', 'Incoming', 'Résultat de l\'examen de demande de rectification des Etats Financiers Compagnie ASKI Airline', NULL, '2026-01-21', NULL, 'DERAR', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1769081929__0040_du_2026-01-21.pdf', '2026-01-22 11:03:03', '2026-01-28 11:12:17', 0, NULL, NULL, NULL),
(4, 'REG-2026-697209DAABA90', 1, '06391', 'Incoming', 'Demane de mise à disposition de M. BROU Konan Amani', NULL, '2026-01-21', NULL, 'CABINET DGI', NULL, 'Direction DSESFGénérale', NULL, 'affecté', 'Non assigné', '1769081306_06391_2026-01-22_112741.pdf', '2026-01-22 11:28:26', '2026-01-28 09:42:31', 0, NULL, NULL, NULL),
(5, 'REG-2026-697210C0D9ED1', 1, '06410', 'Outgoing Externe', 'Demande de rectification des états financiers par téléliasse', NULL, '2026-01-21', NULL, 'CABINET DGI', NULL, 'DSESF', NULL, 'Archivé', 'Non assigné', '1769083072_06410_2026-01-22_115627.pdf', '2026-01-22 11:57:52', '2026-02-09 14:49:29', 0, NULL, NULL, NULL),
(6, 'REG-2026-69721207AC2B6', 1, '0759232466', 'Incoming', 'Demande données statistiques pour mémoire de fin de cycle', NULL, '2026-01-21', NULL, 'KOSSONOU Affoué Ella Mireille Stagiaire de l\'ENA', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1769083399_0759232466_2026-01-22_120224.pdf', '2026-01-22 12:03:19', '2026-01-28 09:42:08', 0, NULL, NULL, NULL),
(10, 'REG-2026-6979ED4466FDE', 1, '01210', 'Outgoing Externe', 'Visite de MTN Côte d\'Ivoire', NULL, '2026-01-28', NULL, 'CABINET DGI', NULL, 'DSESF', NULL, 'signé', 'Non assigné', '1769598276_Projet_de_Note_du_DSESF_au_DG_Séminaire_Loi_de_règlement_18_20_déc_2024.pdf', '2026-01-28 11:04:36', '2026-03-13 13:28:47', 0, NULL, 9, '2026-03-13 13:28:47'),
(7, 'REG-2026-69774D5D847F5', 1, '03220', 'Incoming', 'Formation des Agents Non Fiscalistes', NULL, '2026-01-26', NULL, 'CABINET DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1769426269_Document_2026-01-26_formation.pdf', '2026-01-26 11:17:49', '2026-01-28 09:41:20', 0, NULL, NULL, NULL),
(8, 'REG-2026-697752B52AA6B', 1, '0784', 'Incoming', 'Proposition pour utilisation du nouveau serveur', NULL, '2026-01-26', NULL, 'DSESF', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1769427637_Document_2026-01-26_Proposition_serveur.pdf', '2026-01-26 11:40:37', '2026-01-28 11:47:59', 0, NULL, NULL, NULL),
(9, 'REG-2026-69775E4353DEF', 1, '02218', 'Incoming', 'Mission d\'explication des statistiques mensuelles des recettes', NULL, '2026-01-26', NULL, 'CABINET DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1769430595_Statistiques_Mensuelles_Recette_2026-01-26_122728.pdf', '2026-01-26 12:29:55', '2026-01-26 12:30:52', 0, NULL, NULL, NULL),
(11, 'REG-2026-697B3140CAE6F', 1, '444444', 'Incoming', 'juste un essai', NULL, '2026-01-29', NULL, 'Cabinet DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1769681216_COMMISSION_PARITAIRE_DE_SUIVI_DU_PROFIL_DE_CARRIERE.pdf', '2026-01-29 10:06:56', '2026-03-14 10:24:26', 0, NULL, 3, '2026-03-13 01:06:51'),
(12, 'REG-2026-698879A786900', 1, '000222', 'Incoming', 'essai coffre fort', NULL, '2026-02-08', NULL, 'Cabinet DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1770551719_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.doc.pdf', '2026-02-08 11:55:19', '2026-03-15 14:05:31', 0, NULL, 9, '2026-03-13 22:43:31'),
(13, 'REG-2026-69887B3F86D8A', 0, '002221', 'Incoming', 'essai coffre fort1', NULL, '2026-02-08', NULL, 'Cabinet DGI', NULL, 'DSESF', NULL, 'reçu', 'Non assigné', '1770552127_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf', '2026-02-08 12:02:07', '2026-02-08 12:02:07', 0, NULL, NULL, NULL),
(14, 'REG-2026-69887CB125567', 1, '0022222', 'Outgoing', 'essai coffre fort2', NULL, '2026-02-08', NULL, 'Cabinet DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1770552497_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.doc.pdf', '2026-02-08 12:08:17', '2026-02-09 14:50:03', 1, 'eyJpdiI6InNSK0RFSE1IZ2pELzFVb1d0aitUZGc9PSIsInZhbHVlIjoid1djN2xzRVJtVUJGYjgwbWFpUWY5UT09IiwibWFjIjoiNzY4NzJjZWZlYTZiYjE0NWU5MmQ2NjU2MWJiOWY1MzdlZWMzNDFhNDNhZWIwNmYyYzQ1NWI3MzJhYjU3YjE2MyIsInRhZyI6IiJ9', NULL, NULL),
(15, 'REG-2026-698882381615A', 1, '23333', 'Incoming', 'essai coffre fort3', NULL, '2026-02-08', NULL, 'Cabinet DGI', NULL, 'DSESF', NULL, 'signé', 'Non assigné', '1770553912_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf', '2026-02-08 12:31:52', '2026-03-12 10:02:18', 1, 'eyJpdiI6IldRcGw0blZUckRxUE10RXR6MnloVVE9PSIsInZhbHVlIjoieUdrMEc2bkxtWUs4Tm83MkRWTDBBdz09IiwibWFjIjoiYzYxYTM5MWI4NzVlYjEwNjY4MDg0YWZlNjIzZmY2NzE4ODNhNTU1Y2JkZWZmNGVhZDgzZjdjZTRiNzVlODNhMiIsInRhZyI6IiJ9', 3, '2026-03-12 10:02:18'),
(16, 'REG-2026-6988FAE56E213', 1, '01102323', 'Incoming', 'essai courrier', NULL, '2026-02-08', '2025-12-01', 'non spécifié', NULL, 'Direction Générale', NULL, 'affecté', 'Non assigné', '1770584805_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.doc', '2026-02-08 21:06:45', '2026-03-16 08:42:53', 0, NULL, NULL, NULL),
(17, 'REG-2026-6989D00F21E31', 1, '100', 'Incoming Externe', 'Ordre de mission', NULL, '2026-02-09', '2026-02-06', 'CABINET DGI', NULL, 'DSESF', NULL, 'reçu', 'Non assigné', '1770639375_1769688440_Présentation.docx', '2026-02-09 12:16:15', '2026-02-09 14:44:02', 1, 'eyJpdiI6IkNUcGZKU2N1UDJKL2g4bW1uamFDNmc9PSIsInZhbHVlIjoiNmVHZXZSMDMzbEN2ZS81Y1RGeU5yQT09IiwibWFjIjoiZTE1ZGVlMzVmN2RkNmI3ZDY0ZWFmOGU5ZGUxYjI4YWUxODI2MmM1MzFlODc1NjRhZDE3ZGQyY2M3ZWE5OGZjMCIsInRhZyI6IiJ9', NULL, NULL),
(18, 'REG-2026-6989D3054FF88', 1, '101020', 'Incoming Mail', 'Seminaire bilan 2025', NULL, '2026-02-09', '2026-02-06', 'SAPH', '0707584396', 'S/D GUDEF', NULL, 'reçu', 'Non assigné', '1770640133_1769702353_FINAL_243_ADJAME_DALLAS_25_juin_2025_VERSION_1.docx', '2026-02-09 12:28:53', '2026-02-09 14:44:19', 1, 'eyJpdiI6Ik9neUk2Q3dTUkZuUFRzMzZ2U2l4R2c9PSIsInZhbHVlIjoiZHdyVmtTWEdOS0t1bm14U1llN2ZRdz09IiwibWFjIjoiN2Y1ZjBmMjIxMTU2YzdlN2ZkMjMzODdiNGM0MDQ2Y2U2NWE5YzYyMjMwOGMwYTRlNWEzZWRmNjhhYmFjYjYxZCIsInRhZyI6IiJ9', NULL, NULL),
(19, 'REG-2026-6989ED1CA7C6B', 1, '000021A', 'Outgoing Mail', 'essai de type courrier', NULL, '2026-02-09', '2026-02-05', 'SAPH', NULL, 'S/D GUDEF', NULL, 'reçu', 'Non assigné', '1770646812_1769688440_Code_LARAVEL.docx', '2026-02-09 14:20:12', '2026-02-09 14:44:29', 0, NULL, NULL, NULL),
(20, 'REG-2026-6989F1B28F517', 0, '000021D', 'Incoming Externe', 'essai courrier', NULL, '2026-02-09', '2026-02-02', 'DERAR', NULL, 'DSESF', NULL, 'reçu', 'Non assigné', '1770647986_1769688440_Code_LARAVEL.docx', '2026-02-09 14:39:46', '2026-02-09 14:39:46', 1, 'eyJpdiI6ImVvNVJiR1A1WUdweUZKTWFIa2JqWWc9PSIsInZhbHVlIjoiSDZtL3hPR0VLVUVQaHZVZzUzSXZyUT09IiwibWFjIjoiNjdiYzczNDc2MWIwNThhM2UyNTQ3NWRkNDZlNjVjMTVjM2VhZTU2OWFlNGFmODc5YThjYTU2OGRkNjhhMzlmYSIsInRhZyI6IiJ9', NULL, NULL),
(21, 'REG-2026-698C6BD67BE5B', 1, '223344', 'Outgoing', 'essai imputation', NULL, '2026-02-10', '2026-02-10', 'dsesf', NULL, 'cabinet dgi', NULL, 'affecté', 'Non assigné', '1770810326_1769688440_Code_LARAVEL.docx', '2026-02-11 11:45:26', '2026-02-11 11:46:58', 0, NULL, NULL, NULL),
(22, 'REG-2026-699C1EC65AEEF', 0, '112233', 'Incoming', 'ESSAI CODE', NULL, '2026-02-23', '2026-02-20', 'CABINET DGI', NULL, 'S/D GUDEF', NULL, 'reçu', 'Non assigné', '1771839174_1769688440_Code_LARAVEL.docx', '2026-02-23 09:32:54', '2026-02-23 09:32:54', 1, 'eyJpdiI6IjJiTDBxYTlCM1dycmErVkZndFZvT1E9PSIsInZhbHVlIjoiS1AvUjQySlBBU1A5TjRyWkM1WXZIQT09IiwibWFjIjoiOGZhOGU0NzFiZjhjZDQ5MjNkMTBhODY4YzcwZWM5YTAwMmE3YTcyYTVlNTVmNDViMzUwMGFiYzc1ZWJlNjY1NSIsInRhZyI6IiJ9', NULL, NULL),
(23, 'REG-2026-699EFB7E161D0', 1, '1112233', 'Incoming Externe', 'essai', NULL, '2026-02-25', '2026-02-24', 'SAPH', NULL, 'DSESF', NULL, 'signé', 'Non assigné', '1772026750_Liste_MembreSport.pdf', '2026-02-25 13:39:10', '2026-03-12 09:18:11', 1, 'eyJpdiI6Im1CeTRGZmM0czNuZm8rLy9iMFNRR0E9PSIsInZhbHVlIjoiZVVZSTY5dFU5OHYyK3F6YlEvakhvdz09IiwibWFjIjoiMTNmMDNhYWRkNWVkOWI0MzhlYzJiN2QxOWM2YzZjYmQxMWU0MzBlMDk4NWQ2YTI4ODU2MTdmNTAxZTc2ZDBjMSIsInRhZyI6IiJ9', NULL, NULL),
(24, 'REG-2026-699EFF520BF38', 1, '00112233', 'Incoming', 'essai', NULL, '2026-02-25', '2026-02-24', 'SAPH', NULL, 'S/D GUDEF', NULL, 'affecté', 'Non assigné', '1772027730_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf', '2026-02-25 13:55:30', '2026-03-16 08:10:40', 1, 'eyJpdiI6Im41OU9UUmdxdWZrcUVTbVB5blpLaGc9PSIsInZhbHVlIjoiTzM0S3ZSNmprU1pzbWdFakVtdUQ0QT09IiwibWFjIjoiMTU0ZDJiYTQ2ODEwZWEyMGJjODU4MDA4YjEyMjI0MDRkNWYxY2IwZDNhZWEzOTNiOGU4OGIwODY1NDY3ZmUyMiIsInRhZyI6IiJ9', NULL, NULL),
(25, 'REG-2026-69BBD9B60F33A', 1, 'X01', 'Incoming', 'juste verifier', NULL, '2026-03-19', '2026-03-11', 'france telecom', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1773918646_Projet_de_Note_du_DSESF_au_DG_Séminaire_Loi_de_règlement_18_20_déc_2024.pdf', '2026-03-19 11:10:46', '2026-03-19 11:11:54', 1, 'eyJpdiI6IjJIU05Jci8yRHNpNkFzVTE5dXBVQ0E9PSIsInZhbHVlIjoiWmMvQko1ZVByUG13UG9SK2M5NDhRZz09IiwibWFjIjoiYjBlOTFkZjYyNGMyNTVkYjQxYjlkNzdjMjkyYTdiMDQwMGExNTJjYjU2M2JjZDFlYmNiNjA1MGJiNzY3M2I3MyIsInRhZyI6IiJ9', NULL, NULL),
(26, 'REG-2026-69BBDB6AAB80B', 1, 'X02', 'Incoming Externe', 'cvfdghg', NULL, '2026-03-19', '2026-03-12', 'DIRECTION BUDGET', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1773919082_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.pdf', '2026-03-19 11:18:02', '2026-03-19 14:59:47', 1, 'eyJpdiI6IlEzY0phdHFteFlXMTduRE16dU1uSEE9PSIsInZhbHVlIjoic0JCWldDQ2tseHE2Ynd6UEZOVGVhUT09IiwibWFjIjoiZTg1ZDEyZWQzNTQzZmU2MmM0NWRhOGM3ZWIwYWY4MTEyZjY4ZmM5YzFlY2Q0NDhiNTE4ZTQ2NDZiMjYwM2Q0ZiIsInRhZyI6IiJ9', NULL, NULL),
(27, 'REG-2026-69BC0CC8607A3', 1, 'X02022', 'Incoming', 'BHJKKL', NULL, '2026-03-19', '2026-03-10', 'CABINET DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1773931720_Projet_de_Note_du_DSESF_au_DG_Séminaire_Loi_de_règlement_18_20_déc_2024.pdf', '2026-03-19 14:48:40', '2026-03-19 14:51:56', 0, NULL, NULL, NULL),
(28, 'REG-2026-69C78BD78C7B1', 1, '252525', 'Incoming Mail', 'Mail du DG concernant une formation', NULL, '2026-03-28', '2026-03-27', 'Cabinet DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1774685143_Compte_débiteur_02-03-2026_13.56.pdf', '2026-03-28 08:05:43', '2026-03-28 08:07:18', 0, NULL, NULL, NULL),
(29, 'REG-2026-69CD38F125415', 1, '2026-04-01_152252', 'Incoming', 'Programmation hebdomadaire', NULL, '2026-04-01', '2026-03-31', 'CABINET DGI', NULL, 'DSESF', NULL, 'affecté', 'Non assigné', '1775057137_2026-04-01_152252.pdf', '2026-04-01 15:25:37', '2026-04-01 15:27:21', 1, 'eyJpdiI6ImZoODN6NEZQRjE2VG4yakNwbFFlS3c9PSIsInZhbHVlIjoiSnpwWnk1R29wT01zL2N1MmJWZkg4UT09IiwibWFjIjoiYzNhNGNlNWNiYThhYTIzNDg5MGM5MmU1NDI0YWI4MTRmMWU0OTU2OTk0YTA4NzMzNjZkZTlhYzcxODFkZWZjYSIsInRhZyI6IiJ9', NULL, NULL),
(30, 'REG-2026-69CE396A3419F', 1, '111444', 'Outgoing', 'Projet de note du DG', NULL, '2026-04-02', '2026-04-02', 'DSESF', NULL, 'Cabinet DG', NULL, 'affecté', 'Non assigné', '1775122794_2026-04-01_152252.pdf', '2026-04-02 09:39:54', '2026-04-02 09:41:40', 1, 'eyJpdiI6IkxGRnowb3FEdFYrb3lZNFJzanp0dmc9PSIsInZhbHVlIjoidlF4djY5UzVKekMrUFB6cklYOTJmQT09IiwibWFjIjoiOTk0ODNjNzVjMzgzN2U5NTdhZWJhZGY3OTBjMmY4ZTg0MTdhNDFhNzc5MDk5ODc0NmQwYzkyNWExNDdkMDJiNCIsInRhZyI6IiJ9', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `directions`
--

DROP TABLE IF EXISTS `directions`;
CREATE TABLE IF NOT EXISTS `directions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `head_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `directions_code_unique` (`code`),
  KEY `directions_head_id_foreign` (`head_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `directions`
--

INSERT INTO `directions` (`id`, `name`, `code`, `description`, `head_id`, `created_at`, `updated_at`) VALUES
(1, 'Cabinet du Directeur', 'CAB-DIR', NULL, NULL, '2026-01-20 12:48:33', '2026-01-20 12:48:33'),
(2, 'Sous-Direction de la Prévision et des Statitiques', 'SDPS', NULL, NULL, '2026-01-20 12:49:29', '2026-01-20 12:49:29'),
(3, 'Sous-Direction des Etudes et Evaluations Fiscales', 'SDEEF', NULL, NULL, '2026-01-20 12:50:03', '2026-01-20 12:50:03'),
(4, 'Sous-Direction de la Planification et de la Stratégie', 'SDPlan&S', NULL, NULL, '2026-01-20 12:51:40', '2026-01-20 13:01:54'),
(5, 'Sous-Direction du Guichet Unique de Dépôt des Etats Financiers', 'GUDEF', NULL, NULL, '2026-01-20 12:52:43', '2026-01-20 12:52:43');

-- --------------------------------------------------------

--
-- Structure de la table `expediteurs`
--

DROP TABLE IF EXISTS `expediteurs`;
CREATE TABLE IF NOT EXISTS `expediteurs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `holiday_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `holidays_holiday_date_unique` (`holiday_date`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `holiday_date`, `description`, `is_recurring`, `created_at`, `updated_at`) VALUES
(1, 'Jour de l’An', '2026-01-01', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(2, 'MAHOULID', '2026-08-26', NULL, 1, '2026-03-07 08:53:31', '2026-03-17 14:40:59'),
(3, 'Fête du Travail', '2026-05-01', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(4, 'Ascension', '2026-05-14', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(5, 'Lundi de Pentecôte', '2026-05-25', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(6, 'Fête Nationale', '2026-08-07', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(7, 'Assomption', '2026-08-15', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(8, 'Toussaint', '2026-11-01', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(9, 'Journée de la paix', '2026-11-15', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(10, 'Noël', '2026-12-25', NULL, 1, '2026-03-07 08:53:31', '2026-03-07 08:53:31'),
(11, 'Tabaski', '2026-05-30', NULL, 0, '2026-03-07 09:45:12', '2026-03-07 09:45:12'),
(12, 'Ramadan', '2026-03-20', NULL, 0, '2026-03-07 09:45:41', '2026-03-07 09:45:41'),
(13, 'Nuit du Destin', '2026-03-16', NULL, 0, '2026-03-11 10:11:40', '2026-03-16 00:24:05'),
(14, 'LUNDI DE PÂQUES', '2026-04-06', NULL, 0, '2026-03-17 14:41:17', '2026-03-17 14:41:17');

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

DROP TABLE IF EXISTS `horaires`;
CREATE TABLE IF NOT EXISTS `horaires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `jour` varchar(191) NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `tolerance_retard` int(11) NOT NULL DEFAULT 15,
  `est_ouvre` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`id`, `jour`, `heure_debut`, `heure_fin`, `tolerance_retard`, `est_ouvre`, `created_at`, `updated_at`) VALUES
(1, 'Lundi', '07:30:00', '16:30:00', 15, 1, '2026-01-21 15:29:05', '2026-01-21 15:29:05'),
(2, 'Mardi', '07:30:00', '16:30:00', 15, 1, '2026-01-21 15:29:05', '2026-01-21 15:29:05'),
(3, 'Mercredi', '07:30:00', '16:30:00', 15, 1, '2026-01-21 15:29:05', '2026-01-21 15:29:05'),
(4, 'Jeudi', '07:30:00', '16:30:00', 15, 1, '2026-01-21 15:29:05', '2026-01-21 15:29:05'),
(5, 'Vendredi', '07:30:00', '16:30:00', 15, 1, '2026-01-21 15:29:05', '2026-01-21 15:29:05'),
(6, 'Samedi', '00:00:00', '00:00:00', 15, 0, '2026-01-21 15:29:05', '2026-01-21 15:29:05'),
(7, 'Dimanche', '00:00:00', '00:00:00', 15, 0, '2026-01-21 15:29:05', '2026-01-21 15:29:05');

-- --------------------------------------------------------

--
-- Structure de la table `imputations`
--

DROP TABLE IF EXISTS `imputations`;
CREATE TABLE IF NOT EXISTS `imputations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `courrier_id` bigint(20) UNSIGNED NOT NULL,
  `chemin_fichier` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `suivi_par` bigint(20) UNSIGNED DEFAULT NULL,
  `niveau` enum('primaire','secondaire','tertiaire','autre') DEFAULT 'autre',
  `instructions` text DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `documents_annexes` text DEFAULT NULL,
  `date_imputation` date NOT NULL DEFAULT '2026-01-20',
  `date_traitement` date DEFAULT NULL,
  `echeancier` date DEFAULT NULL,
  `statut` enum('en_attente','en_cours','termine') NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imputations_courrier_id_foreign` (`courrier_id`),
  KEY `imputations_user_id_foreign` (`user_id`),
  KEY `imputations_suivi_par_foreign` (`suivi_par`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `imputations`
--

INSERT INTO `imputations` (`id`, `courrier_id`, `chemin_fichier`, `user_id`, `suivi_par`, `niveau`, `instructions`, `observations`, `documents_annexes`, `date_imputation`, `date_traitement`, `echeancier`, `statut`, `created_at`, `updated_at`) VALUES
(7, 4, '1769081306_06391_2026-01-22_112741.pdf', 3, NULL, 'tertiaire', 'Bilan trimestrielle 4T 2025', NULL, '\"[\\\"1769103437_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\\\"]\"', '2026-01-22', NULL, '2026-01-26', 'en_attente', '2026-01-22 17:37:17', '2026-01-22 17:37:17'),
(6, 5, '1769083072_06410_2026-01-22_115627.pdf', 9, NULL, 'primaire', 'rapidement', NULL, '\"[\\\"1769094964_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\\\"]\"', '2026-01-22', NULL, '2026-01-23', 'termine', '2026-01-22 15:16:04', '2026-01-22 17:25:44'),
(5, 2, '1769081946_000021__du_21_01_2026.pdf', 3, NULL, 'tertiaire', 'urgent', NULL, '\"[\\\"1769091173_0759232466_2026-01-22_120224.pdf\\\"]\"', '2026-01-22', NULL, '2026-01-23', 'termine', '2026-01-22 14:12:53', '2026-01-22 14:54:35'),
(9, 6, '1769083399_0759232466_2026-01-22_120224.pdf', 17, NULL, 'secondaire', 'Extraction de données Déclaration TEE & MICRO 2025', NULL, '\"[\\\"1769157764_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\\\"]\"', '2026-01-23', NULL, '2026-01-27', 'en_attente', '2026-01-23 08:42:44', '2026-01-23 08:42:44'),
(10, 7, '1769426269_Document_2026-01-26_formation.pdf', 3, NULL, 'tertiaire', 'Informer les agents et tenir une liste d\'agents à former', NULL, '\"[]\"', '2026-01-26', NULL, '2026-01-28', 'en_attente', '2026-01-26 11:25:47', '2026-01-26 11:25:47'),
(11, 8, '1769427637_Document_2026-01-26_Proposition_serveur.pdf', 3, NULL, 'tertiaire', 'Travail urgent pour rendre le serveur operationnel', NULL, '\"[]\"', '2026-01-26', NULL, '2026-01-28', 'termine', '2026-01-26 11:48:55', '2026-01-26 11:50:41'),
(15, 3, NULL, 9, NULL, 'autre', 'info1', NULL, '\"documents\\/imputations\\/annexes\\/1769599564_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:26:04', '2026-01-28 11:26:04'),
(16, 10, NULL, 9, NULL, 'autre', 'info2', NULL, '\"documents\\/imputations\\/annexes\\/1769600467_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:41:07', '2026-01-28 11:41:07'),
(17, 9, NULL, 17, NULL, 'autre', 'INFO3', NULL, '\"documents\\/imputations\\/annexes\\/1769600597_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:43:17', '2026-01-28 11:43:17'),
(18, 8, NULL, 17, NULL, 'secondaire', 'info4', NULL, '\"documents\\/imputations\\/annexes\\/1769600879_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:47:59', '2026-01-28 11:47:59'),
(19, 10, NULL, 6, NULL, 'tertiaire', 'info5', NULL, '\"documents\\/imputations\\/annexes\\/1769601018_Note_Service_Objectifs_de_recettes_r\\u00e9vis\\u00e9s_2025_N\'GUESSAN.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:50:18', '2026-01-28 11:50:18'),
(20, 10, NULL, 9, NULL, 'primaire', 'info6', NULL, '\"documents\\/imputations\\/annexes\\/1769601085_Note_Service_Objectifs_de_recettes_r\\u00e9vis\\u00e9s_2025_N\'GUESSAN.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:51:25', '2026-01-28 11:51:25'),
(21, 10, NULL, 3, NULL, 'autre', 'info7', NULL, '\"documents\\/imputations\\/annexes\\/1769601385_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-01-26', NULL, '2026-01-29', 'en_attente', '2026-01-28 11:56:25', '2026-01-28 11:56:25'),
(22, 9, NULL, 3, NULL, 'autre', 'iiokjj', NULL, '\"documents\\/imputations\\/annexes\\/1769601446_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-01-26', NULL, '2026-01-30', 'en_attente', '2026-01-28 11:57:26', '2026-01-28 11:57:26'),
(23, 10, NULL, 10, NULL, 'secondaire', 'GH', NULL, '\"documents\\/imputations\\/annexes\\/1769601632_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-01-26', NULL, '2026-01-29', 'termine', '2026-01-28 12:00:32', '2026-01-29 10:18:33'),
(24, 11, NULL, 24, NULL, 'tertiaire', 'intructions', NULL, '\"documents\\/imputations\\/annexes\\/1769681389_Tuto_PHP.pdf\"', '2026-01-26', NULL, '2026-02-02', 'termine', '2026-01-29 10:09:49', '2026-01-29 10:20:35'),
(25, 14, NULL, 3, NULL, 'autre', 'taf', NULL, NULL, '2026-02-08', NULL, '2026-02-14', 'en_attente', '2026-02-08 12:29:47', '2026-02-08 12:29:47'),
(26, 15, NULL, 3, NULL, 'autre', 'verif', NULL, NULL, '2026-02-08', NULL, '2026-02-15', 'en_attente', '2026-02-08 12:32:44', '2026-02-08 12:32:44'),
(27, 21, NULL, 3, NULL, 'autre', 'travail à rendre au plus tard le 15 fevrier2026', NULL, '\"documents\\/imputations\\/annexes\\/1770810418_1769688440_Code_LARAVEL.docx\"', '2026-02-11', NULL, '2026-02-15', 'en_attente', '2026-02-11 11:46:58', '2026-02-11 11:46:58'),
(28, 23, NULL, 9, NULL, 'primaire', 'travail à excuter pour vendredi 10h', NULL, '\"documents\\/imputations\\/annexes\\/1772026843_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-02-25', NULL, '2026-02-27', 'termine', '2026-02-25 13:40:43', '2026-02-25 13:50:36'),
(31, 12, NULL, 3, NULL, 'autre', 'ras', '\n[LOG] ADICO Innocent absent (approuvé), redirigé vers l\'intérimaire BEZI Mathurin.', '\"documents\\/imputations\\/annexes\\/1773583531_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-03-15', NULL, '2026-03-16', 'en_attente', '2026-03-15 14:05:31', '2026-03-15 14:05:31'),
(30, 14, NULL, 3, NULL, 'autre', 'essai pour voir si l\'imputation tient compte des interims', '\n[LOG] ADICO Innocent absent (approuvé), redirigé vers l\'intérimaire BEZI Mathurin.', '\"documents\\/imputations\\/annexes\\/1773577305_Note_Service_Objectifs_de_recettes_r\\u00e9vis\\u00e9s_2025_N\'GUESSAN.doc.pdf\"', '2026-03-15', NULL, '2026-03-17', 'en_attente', '2026-03-15 12:21:45', '2026-03-15 12:21:45'),
(33, 11, NULL, 3, NULL, 'autre', 'verif', '\n[LOG] ANGELS Riviere michel absent (approuvé), redirigé vers l\'intérimaire COULIBALY Sié Yacouba.', '\"documents\\/imputations\\/annexes\\/1773585780_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-03-15', NULL, '2026-03-17', 'en_attente', '2026-03-15 14:43:00', '2026-03-15 14:43:00'),
(34, 24, NULL, 3, NULL, 'autre', 'verif2', '\n[LOG] ADICO Innocent absent (approuvé), redirigé vers l\'intérimaire BEZI Mathurin.', '\"documents\\/imputations\\/annexes\\/1773648640_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-03-16', NULL, '2026-03-18', 'en_attente', '2026-03-16 08:10:40', '2026-03-16 08:10:40'),
(35, 24, NULL, 3, NULL, 'autre', 'verif2', '\n[LOG] ADICO Innocent absent (approuvé), redirigé vers l\'intérimaire BEZI Mathurin.', '\"documents\\/imputations\\/annexes\\/1773648640_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-03-16', NULL, '2026-03-18', 'en_attente', '2026-03-16 08:10:40', '2026-03-16 08:10:40'),
(36, 16, NULL, 3, NULL, 'autre', 'Verif3', '\n[LOG] ADICO Innocent absent (approuvé), redirigé vers l\'intérimaire BEZI Mathurin.', '\"documents\\/imputations\\/annexes\\/1773650573_Note_au_MFB__Objectif_de_recettes_TOFE_Aout_2025.pdf\"', '2026-03-16', NULL, '2026-03-20', 'en_attente', '2026-03-16 08:42:53', '2026-03-16 08:42:53'),
(37, 25, NULL, 3, NULL, 'autre', 'fghhjjh', NULL, '\"documents\\/imputations\\/annexes\\/1773918714_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-03-19', NULL, '2026-03-20', 'en_attente', '2026-03-19 11:11:54', '2026-03-19 11:11:54'),
(49, 25, NULL, 3, NULL, 'autre', 'nb,j;kklmlkm', NULL, '\"documents\\/imputations\\/annexes\\/1773933838_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-03-19', NULL, '2026-03-21', 'en_attente', '2026-03-19 15:23:58', '2026-03-19 15:23:58'),
(50, 27, NULL, 3, NULL, 'autre', 'hjkjklkl', NULL, '\"documents\\/imputations\\/annexes\\/1773934120_Note_de_service_DEMANDE_D\'INFORMATIONS_COMITE_COUT_SDEEF.pdf\"', '2026-03-19', NULL, '2026-03-21', 'en_attente', '2026-03-19 15:28:40', '2026-03-19 15:28:40'),
(48, 27, NULL, 3, NULL, 'autre', 'h,hjjikik', NULL, '\"documents\\/imputations\\/annexes\\/1773933699_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-03-19', NULL, '2026-03-21', 'en_attente', '2026-03-19 15:21:39', '2026-03-19 15:21:39'),
(47, 26, NULL, 3, NULL, 'autre', 'hb,j,kj;klklmlkm', '\n[LOG] HORO Tiekoura absent (approuvé), redirigé vers l\'intérimaire KEDI Née keita aramata anne elise.', '\"documents\\/imputations\\/annexes\\/1773933627_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-03-19', NULL, '2026-03-21', 'en_attente', '2026-03-19 15:20:27', '2026-03-19 15:20:27'),
(51, 28, NULL, 3, NULL, 'autre', 'travail à rendre au plus tard le 02 avril 2026', NULL, '\"documents\\/imputations\\/annexes\\/1774685237_Courrier_444444.pdf\"', '2026-03-28', NULL, '2026-04-02', 'en_attente', '2026-03-28 08:07:17', '2026-03-28 08:07:17'),
(52, 27, NULL, 3, NULL, 'autre', 'dffgg', NULL, '\"documents\\/imputations\\/annexes\\/1774873388_1770551719_Note_Service_Objectifs_de_recettes_r\\u00e9vis\\u00e9s_2025_N\'GUESSAN.doc.pdf\"', '2026-03-30', NULL, '2026-03-05', 'en_attente', '2026-03-30 12:23:08', '2026-03-30 12:23:08'),
(53, 29, NULL, 3, NULL, 'autre', 'Pour Information et programmation', NULL, '\"documents\\/imputations\\/annexes\\/1775057241_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-04-01', NULL, '2026-04-03', 'en_attente', '2026-04-01 15:27:21', '2026-04-01 15:27:21'),
(54, 30, NULL, 3, NULL, 'autre', 'Traiter avec diligence', NULL, '\"documents\\/imputations\\/annexes\\/1775122900_Projet_de_Note_du_DSESF_au_DG_S\\u00e9minaire_Loi_de_r\\u00e8glement_18_20_d\\u00e9c_2024.pdf\"', '2026-04-02', NULL, '2026-04-07', 'en_attente', '2026-04-02 09:41:40', '2026-04-02 09:41:40'),
(55, 30, NULL, 3, NULL, 'autre', 'diligence', NULL, NULL, '2026-04-02', NULL, '2026-04-07', 'en_cours', '2026-04-02 09:44:26', '2026-04-02 09:44:26');

-- --------------------------------------------------------

--
-- Structure de la table `interims`
--

DROP TABLE IF EXISTS `interims`;
CREATE TABLE IF NOT EXISTS `interims` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `interimaire_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `motif` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interims_agent_id_foreign` (`agent_id`),
  KEY `interims_interimaire_id_foreign` (`interimaire_id`),
  KEY `interims_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `interims`
--

INSERT INTO `interims` (`id`, `agent_id`, `interimaire_id`, `user_id`, `date_debut`, `date_fin`, `motif`, `is_active`, `created_at`, `updated_at`) VALUES
(7, 5, 18, 18, '2026-03-15', '2026-03-18', NULL, 1, '2026-03-14 11:03:54', '2026-03-14 11:03:54'),
(9, 25, 1, 3, '2026-03-15', '2026-03-17', 'repos maladie', 1, '2026-03-15 14:41:44', '2026-03-15 14:41:44'),
(8, 5, 25, 25, '2026-03-22', '2026-03-25', 'seminaire a dakar', 1, '2026-03-14 11:16:33', '2026-03-14 11:16:33'),
(10, 16, 21, 21, '2026-03-19', '2026-03-25', 'seminaire', 1, '2026-03-19 07:22:21', '2026-03-19 07:22:21'),
(11, 11, 16, 16, '2026-03-19', '2026-03-20', 'stage', 1, '2026-03-19 07:34:19', '2026-03-19 07:34:19'),
(12, 4, 21, 21, '2026-03-19', '2026-03-21', 'essai verif', 1, '2026-03-19 07:59:17', '2026-03-19 07:59:17'),
(13, 5, 25, 25, '2026-06-11', '2026-06-13', 'repos malaie', 1, '2026-03-31 10:15:41', '2026-04-02 09:03:20'),
(14, 5, 4, 6, '2026-04-05', '2026-04-08', 'voyage d\'etude à istambul', 1, '2026-04-01 17:04:38', '2026-04-01 17:17:18');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `objet` varchar(255) NOT NULL,
  `date_heure` datetime NOT NULL,
  `duree_minutes` int(11) NOT NULL DEFAULT 60,
  `lieu` varchar(255) NOT NULL DEFAULT 'Abidjan',
  `animateur_id` bigint(20) UNSIGNED NOT NULL,
  `redacteur_id` bigint(20) UNSIGNED NOT NULL,
  `ordre_du_jour` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `externes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'programmee',
  `presence_file` varchar(255) DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetings_animateur_id_foreign` (`animateur_id`),
  KEY `meetings_redacteur_id_foreign` (`redacteur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `meetings`
--

INSERT INTO `meetings` (`id`, `objet`, `date_heure`, `duree_minutes`, `lieu`, `animateur_id`, `redacteur_id`, `ordre_du_jour`, `created_at`, `updated_at`, `externes`, `status`, `presence_file`, `report_file`) VALUES
(1, 'Comité de direction', '2026-04-07 09:00:00', 60, 'Abidjan', 5, 5, 'Reunion hebdomadaire', '2026-03-30 13:00:07', '2026-03-30 13:00:07', NULL, 'programmee', NULL, NULL),
(2, 'Comité de direction', '2026-04-07 09:00:00', 60, 'Abidjan', 5, 1, 'fgghghh', '2026-03-30 13:06:11', '2026-03-30 13:06:11', NULL, 'programmee', NULL, NULL),
(3, 'Comité de direction', '2026-04-07 09:00:00', 60, 'Abidjan', 5, 25, 'vgggh', '2026-03-30 13:11:27', '2026-03-30 13:11:27', NULL, 'programmee', NULL, NULL),
(4, 'Reunion information', '2026-04-10 13:20:00', 60, 'Abidjan', 5, 1, 'analyses des données', '2026-03-30 13:21:01', '2026-04-06 17:03:50', '[\"Yao akissi Rolande DGT\",\"Koffi amoa GAG\"]', 'programmee', '1775495030_presence_Note au MFB_ Objectif de recettes TOFE Aout 2025.pdf', '1775495030_rapport_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf'),
(5, 'info', '2026-03-30 13:23:00', 60, 'Bouake', 5, 1, 'information', '2026-03-30 13:24:19', '2026-03-31 09:04:11', NULL, 'terminee', '1774947851_presence_1770551719_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.doc.pdf', '1774947851_rapport_Courrier_444444.pdf'),
(6, 'Information TVA', '2026-04-03 13:00:00', 60, 'Abidjan', 23, 1, 'Reun ion d\'information sur la TVA', '2026-03-30 13:39:51', '2026-03-30 13:39:51', NULL, 'programmee', NULL, NULL),
(7, 'TAF', '2026-04-02 14:00:00', 60, 'Abidjan', 16, 1, 'taf', '2026-03-30 13:45:12', '2026-04-05 22:39:30', '[\"Yao akissi Rolande DGT\",\"Koffi amoa GAG\"]', 'terminee', NULL, NULL),
(8, 'info', '2026-03-31 15:00:00', 60, 'sinfra', 4, 2, 'reunion technique', '2026-03-31 11:04:50', '2026-04-02 08:34:34', '[\"Beni\\u00e9 Michel\",\"Ouattara Ismael\"]', 'terminee', '1775118874_presence_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '1775118874_rapport_2026-04-01_152252.pdf'),
(9, 'réponses de ls DSESF relative à une demande de stage et une demande de collecte de données sollicitées respectivement par Mlle DJAN Loukou Julienne et DOU Sopie Joëlle Priscae', '2026-04-01 14:00:00', 60, 'Jacqueville', 1, 8, 'reunion information', '2026-03-31 11:06:47', '2026-03-31 11:06:47', '[\"Beni\\u00e9 Michel\",\"Ouattara Ismael\",\"kore moise\"]', 'programmee', NULL, NULL),
(10, 'Comité de direction', '2026-04-13 10:00:00', 60, 'Abidjan -plateau', 5, 13, 'Reunion hebdomadaire de mise au point', '2026-04-13 09:27:53', '2026-04-13 11:55:47', '[\"Beni\\u00e9 Michel\",\"Ouattara Ismael\"]', 'terminee', NULL, NULL),
(11, 'Information', '2026-04-17 09:32:00', 60, 'sinfra', 8, 20, 'ghyjjki', '2026-04-16 14:19:16', '2026-04-16 14:19:42', '[\"Yao akissi Rolande DGT\",\"Koffi amoa GAG\"]', 'programmee', NULL, NULL),
(12, 'info', '2026-04-20 14:30:00', 60, 'Salle de conférence de la DSESF', 16, 21, 'gjkikll', '2026-04-16 14:23:20', '2026-04-16 14:23:20', '\"Beni\\u00e9 Michel, Ouattara Ismael, kore moise\"', 'programmee', NULL, NULL),
(13, 'Information', '2026-04-17 10:00:00', 60, 'Abidjan', 25, 1, NULL, '2026-04-16 14:53:51', '2026-04-16 14:53:51', NULL, 'programmee', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `meeting_externes`
--

DROP TABLE IF EXISTS `meeting_externes`;
CREATE TABLE IF NOT EXISTS `meeting_externes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) UNSIGNED NOT NULL,
  `nom_complet` varchar(255) NOT NULL,
  `origine` varchar(255) NOT NULL,
  `fonction` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_externes_meeting_id_foreign` (`meeting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `meeting_participants`
--

DROP TABLE IF EXISTS `meeting_participants`;
CREATE TABLE IF NOT EXISTS `meeting_participants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_participants_meeting_id_foreign` (`meeting_id`),
  KEY `meeting_participants_agent_id_foreign` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `meeting_participants`
--

INSERT INTO `meeting_participants` (`id`, `meeting_id`, `agent_id`) VALUES
(1, 1, 25),
(2, 2, 5),
(3, 3, 5),
(4, 4, 25),
(5, 4, 9),
(6, 5, 23),
(7, 5, 9),
(8, 5, 18),
(9, 6, 23),
(10, 6, 20),
(11, 6, 10),
(12, 7, 9),
(13, 8, 23),
(14, 8, 1),
(15, 8, 20),
(16, 9, 25),
(17, 9, 9),
(18, 9, 18),
(19, 9, 1),
(20, 9, 20),
(21, 9, 10),
(22, 9, 12),
(23, 9, 15),
(24, 9, 16),
(25, 10, 5),
(26, 10, 23),
(27, 10, 25),
(28, 10, 18),
(29, 10, 20),
(30, 10, 6),
(31, 10, 22),
(38, 12, 23),
(39, 12, 25),
(40, 12, 1),
(41, 12, 20),
(42, 12, 16),
(43, 12, 21);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_30_232419_create_courriers_table', 1),
(5, '2025_12_01_000531_create_affectations_table', 1),
(6, '2025_12_01_094543_update_type_column_in_courriers_table', 1),
(7, '2025_12_01_100411_update_type_column_in_courriers_table', 1),
(8, '2025_12_01_100734_increase_type_column_length_in_courriers_table', 1),
(9, '2025_12_03_075419_create_directions_table', 1),
(10, '2025_12_03_075434_create_services_table', 1),
(11, '2025_12_03_075449_create_agents_table', 1),
(12, '2025_12_03_144514_add_profile_fields_to_users_table', 1),
(13, '2025_12_04_121917_make_lieu_de_naissance_nullable_in_agents_table', 1),
(14, '2025_12_04_132311_update_photo_column_in_agents_table', 1),
(15, '2025_12_04_132817_update_email_column_in_agents_table', 1),
(16, '2025_12_04_133355_update__date__prise_de__service_column_in_agents_table', 1),
(17, '2025_12_04_143140_create_presences_table', 1),
(18, '2025_12_04_143949_create_absences_table', 1),
(19, '2025_12_04_145524_create_type_absences_table', 1),
(20, '2025_12_05_123929_rename_user_id_to_agent_id_in_affectations_table', 1),
(21, '2025_12_09_150923_add_email_professionnel_to_agents_table', 1),
(22, '2025_12_10_144650_create_notifications_taches_table', 1),
(23, '2025_12_11_123518_modify_courriers_assigne_a_to_string', 1),
(24, '2025_12_15_124007_add_document_to_notifications_taches_table', 1),
(25, '2025_12_15_145617_rename_id_agent_to_agent_id_in_notifications_taches_table', 1),
(26, '2025_12_15_155804_add_timestamps_to_notifications_taches_table', 1),
(27, '2025_12_23_132434_add_is_archived_to_notifications_taches_table', 1),
(28, '2025_12_23_142311_create_reponse_notifications_table', 1),
(29, '2025_12_23_153002_add_soft_deletes_to_notifications_taches_table', 1),
(30, '2025_12_29_102325_add_approuvee_to_reponse_notifications_table', 1),
(31, '2025_12_29_103202_add_appeciation_du_superieur_to_reponse_notifications_table', 1),
(32, '2026_01_02_105921_add_must_change_password_to_users_table', 1),
(33, '2026_01_04_120452_create_annonces_table', 1),
(34, '2026_01_05_151012_create_horaires_table', 1),
(35, '2026_01_06_151247_add_affecter_to_courriers_table', 1),
(36, '2026_01_09_222247_add_document_justificatif_to_absences_table', 1),
(37, '2026_01_13_151143_create_imputations_table', 1),
(38, '2026_01_13_175520_create_reponses_table', 1),
(39, '2026_01_16_083954_add_validation_fields_to_reponses_table', 1),
(40, '2026_01_20_081732_create_permission_tables', 1),
(41, '2026_01_20_085414_create_posts_table', 1),
(42, '2026_01_20_170506_add_password_changed_at_to_users_table', 2),
(43, '2026_01_22_083540_update_statut_enum_in_presences_table', 3),
(44, '2026_01_22_101554_add_type_to_courriers_table', 4),
(45, '2026_01_22_101853_make_assigne_a_nullable_in_courriers_table', 5),
(46, '2026_01_22_102531_add_numero_enregistrement_to_courriers_table', 6),
(47, '2026_01_22_140612_add_chemin_fichier_to_imputations_table', 7),
(48, '2026_01_26_172154_create_role_user_table', 8),
(49, '2026_02_08_105025_add_is_confidentiel_to_courriers_table', 9),
(50, '2026_02_08_204555_add_date_document_original_to_courriers_table', 10),
(51, '2026_02_11_104137_add_suivi_par_to_imputations_table', 11),
(52, '2026_02_15_114903_create_scripts_extraction_table', 12),
(53, '2026_02_16_091115_remove_fields_from_scripts_table', 13),
(54, '2026_02_16_101450_add_code_to_scripts_table', 14),
(55, '2026_03_07_083937_create_holidays_table', 15),
(56, '2026_03_10_071800_create_audit_logs_table', 16),
(57, '2026_03_11_140457_add_signature_to_users_table', 17),
(58, '2026_03_12_072529_add_navigation_details_to_audit_logs_table', 18),
(59, '2026_03_12_085518_add_signature_to_courriers', 19),
(60, '2026_03_13_104756_create_interims_table', 20),
(61, '2026_03_25_115957_add_statut_autorisation_absence_and_comment_absence_chef_to_absences_table', 21),
(62, '2026_03_30_122828_create_meetings_table', 22),
(63, '2026_03_30_131421_add_externes_to_meetings_table', 23),
(64, '2026_03_31_080803_add_status_and_files_to_meetings_table', 24),
(65, '2026_03_31_151157_create_activities_table', 25),
(66, '2026_03_31_162354_create_activities_table', 26),
(67, '2026_04_01_085915_add_indexes_to_activities_table', 27),
(68, '2026_04_04_094840_create_seminaire_emargements_table', 28),
(69, '2026_04_05_153432_add_date_fields_to_activities_table', 29),
(70, '2026_04_07_125927_add_telephone_to_seminaire_participants_table', 30),
(71, '2026_04_07_133742_add_uuid_to_seminaires', 31),
(72, '2026_04_16_135643_add_contact_to_meeting_participants', 32),
(73, '2026_04_16_142931_create_meeting_externes_table', 33);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(2, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('nafie410@dgi.gouv.ci', '$2y$12$Xsi8FOxrFAlnzRIKv1uOqeYTTGHu7aX9jgolCTNUp6xOk16.KXwGe', '2026-03-17 10:42:16'),
('nkone05@dgi.gouv.ci', '$2y$12$XRfCrL0wjLPMUBFCRQLYIuFR4hw5VnGyFBStRlG5uKjmMHHRcPZqW', '2026-03-17 10:48:20'),
('yacouba.coulibaly@dgi.gouv.ci', '$2y$12$QDc24Pey9xQ1XXyWrpDUIeWAlYTcYeQhAYc6MjupD.B3NcEJr6qMa', '2026-03-17 14:16:39');

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'creer-articles', 'web', '2026-01-20 09:37:00', '2026-01-20 09:37:00'),
(2, 'supprimer-articles', 'web', '2026-01-20 09:37:00', '2026-01-20 09:37:00'),
(3, 'voir-utilisateurs', 'web', '2026-01-20 10:15:15', '2026-01-20 10:15:15'),
(4, 'manage-users', 'web', '2026-01-20 10:37:56', '2026-01-20 10:37:56'),
(5, 'modifier articles', 'web', '2026-01-27 08:48:28', '2026-01-27 08:48:28'),
(6, 'supprimer articles', 'web', '2026-01-27 08:48:28', '2026-01-27 08:48:28'),
(7, 'gerer-roles', 'web', '2026-01-27 08:48:28', '2026-01-27 08:48:28'),
(8, 'acceder-dashboard', 'web', '2026-01-27 08:48:28', '2026-01-27 08:48:28');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `presences`
--

DROP TABLE IF EXISTS `presences`;
CREATE TABLE IF NOT EXISTS `presences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `heure_arrivee` timestamp NOT NULL,
  `heure_depart` timestamp NULL DEFAULT NULL,
  `statut` enum('Absent','Présent','En Retard','Absence Justifiée','Férié') NOT NULL DEFAULT 'Présent',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presences_agent_id_foreign` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1768 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `presences`
--

INSERT INTO `presences` (`id`, `agent_id`, `heure_arrivee`, `heure_depart`, `statut`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-12 07:25:00', '2026-01-12 17:21:00', 'Présent', NULL, '2026-01-21 14:21:39', '2026-01-21 14:21:39'),
(2, 1, '2026-01-13 07:49:00', NULL, 'Présent', NULL, '2026-01-21 14:22:27', '2026-01-21 14:23:05'),
(3, 1, '2026-01-14 08:23:00', '2026-01-21 18:23:00', 'Présent', NULL, '2026-01-21 14:23:38', '2026-01-21 14:23:38'),
(4, 1, '2026-01-15 06:23:00', '2026-01-15 17:23:00', 'Présent', NULL, '2026-01-21 14:24:13', '2026-01-21 14:24:13'),
(5, 1, '2026-01-16 11:24:00', '2026-01-16 17:24:00', 'Présent', NULL, '2026-01-21 14:24:54', '2026-01-21 14:24:54'),
(6, 1, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(7, 2, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(8, 3, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(9, 4, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(10, 5, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(11, 6, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(12, 7, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(13, 8, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(14, 9, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(15, 10, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(16, 11, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(17, 12, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(18, 13, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(19, 14, '2026-01-12 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-12 00:00:00', '2026-01-21 14:26:39'),
(20, 1, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(21, 2, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(22, 3, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(23, 4, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(24, 5, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(25, 6, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(26, 7, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(27, 8, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(28, 9, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(29, 11, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(30, 12, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(31, 13, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(32, 14, '2026-01-13 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-13 00:00:00', '2026-01-21 14:26:39'),
(33, 1, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(34, 2, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(35, 3, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(36, 4, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(37, 5, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(38, 6, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(39, 7, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(40, 8, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(41, 9, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(42, 11, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(43, 12, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(44, 13, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(45, 14, '2026-01-14 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-14 00:00:00', '2026-01-21 14:26:39'),
(46, 1, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(47, 2, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(48, 3, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(49, 4, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(50, 5, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(51, 6, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(52, 7, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(53, 8, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(54, 9, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(55, 11, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(56, 12, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(57, 13, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(58, 14, '2026-01-15 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-15 00:00:00', '2026-01-21 14:26:39'),
(59, 1, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(60, 2, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(61, 3, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(62, 4, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(63, 5, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(64, 6, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(65, 7, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(66, 8, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(67, 9, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(68, 10, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(69, 11, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(70, 12, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(71, 13, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(72, 14, '2026-01-16 08:00:00', NULL, 'Absent', 'Absent (hebdomadaire).', '2026-01-16 00:00:00', '2026-01-21 14:26:39'),
(73, 2, '2026-01-21 07:52:00', NULL, 'Présent', ' (Attention : Aucun horaire trouvé pour Wednesday)', '2026-01-21 14:36:07', '2026-01-21 14:36:07'),
(74, 2, '2026-01-12 07:59:00', '2026-01-12 09:38:00', 'Présent', ' (Attention : Aucun horaire trouvé pour Monday)', '2026-01-21 14:39:16', '2026-01-21 14:39:16'),
(75, 2, '2026-01-13 08:47:00', '2026-01-13 18:47:00', 'Présent', 'Erreur : Aucun horaire trouvé pour le jour [Mardi] dans la table horaires.', '2026-01-21 14:47:22', '2026-01-21 14:47:22'),
(76, 2, '2026-01-14 08:49:00', NULL, 'Présent', 'ERREUR : Aucun horaire trouvé en base pour [Mercredi]. ', '2026-01-21 14:50:10', '2026-01-21 14:50:10'),
(77, 2, '2026-01-15 07:58:00', '2026-01-15 17:58:00', 'Présent', 'ERREUR : Aucun horaire trouvé en base pour [Jeudi]. ', '2026-01-21 14:58:40', '2026-01-21 14:58:40'),
(78, 2, '2026-01-16 07:50:00', NULL, 'Présent', 'ERREUR : Aucun horaire trouvé pour [Vendredi]. ', '2026-01-21 15:02:27', '2026-01-21 15:02:27'),
(79, 4, '2026-01-16 08:12:00', NULL, 'Présent', 'ERREUR : Aucun horaire trouvé pour Vendredi. ', '2026-01-21 15:12:46', '2026-01-21 15:12:46'),
(80, 4, '2026-01-12 07:50:00', NULL, 'Présent', 'ERREUR : Aucun horaire trouvé pour Lundi/Monday. ', '2026-01-21 15:18:01', '2026-01-21 15:18:01'),
(81, 4, '2026-01-13 07:46:00', '2026-01-13 18:31:00', 'En Retard', 'Calculé pour Mardi (Limite: 465m, Arrivée: 466m). ', '2026-01-21 15:31:29', '2026-01-21 15:31:29'),
(82, 16, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:12:09', '2026-01-22 08:18:50'),
(83, 16, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:12:09', '2026-01-22 08:18:50'),
(84, 16, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:12:09', '2026-01-22 08:18:50'),
(85, 16, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:12:09', '2026-01-22 08:18:50'),
(86, 16, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:12:09', '2026-01-22 08:18:50'),
(87, 17, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:30:04', '2026-01-22 08:30:04'),
(88, 17, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:30:04', '2026-01-22 08:30:04'),
(89, 17, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:30:04', '2026-01-22 08:30:04'),
(90, 17, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:30:04', '2026-01-22 08:30:04'),
(91, 17, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire non justifiée.', '2026-01-22 08:30:04', '2026-01-22 08:30:04'),
(92, 18, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-22 08:42:51', '2026-01-22 08:42:51'),
(93, 18, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-22 08:42:51', '2026-01-22 08:42:51'),
(94, 18, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-22 08:42:51', '2026-01-22 08:42:51'),
(95, 18, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-22 08:42:51', '2026-01-22 08:42:51'),
(96, 18, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-22 08:42:51', '2026-01-22 08:42:51'),
(97, 10, '2026-01-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(98, 10, '2026-01-14 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(99, 10, '2026-01-15 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(100, 15, '2026-01-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(101, 15, '2026-01-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(102, 15, '2026-01-14 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(103, 15, '2026-01-15 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(104, 15, '2026-01-16 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-22 09:23:51', '2026-01-22 09:23:51'),
(105, 17, '2026-01-23 09:27:27', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-23 09:27:27', '2026-01-23 09:27:27'),
(106, 4, '2026-01-23 09:39:02', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-23 09:39:02', '2026-01-23 09:39:02'),
(107, 1, '2026-01-23 09:48:08', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-23 09:48:08', '2026-01-23 09:48:08'),
(108, 2, '2026-01-23 10:21:08', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-23 10:21:08', '2026-01-23 10:21:08'),
(109, 1, '2026-01-26 09:22:51', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-26 09:22:51', '2026-01-26 09:22:51'),
(110, 1, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(111, 1, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(112, 1, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(113, 1, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(114, 2, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(115, 2, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(116, 2, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(117, 3, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(118, 3, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(119, 3, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(120, 3, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(121, 3, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(122, 4, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(123, 4, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(124, 4, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(125, 4, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(126, 5, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(127, 5, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(128, 5, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(129, 5, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(130, 5, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(131, 6, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(132, 6, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(133, 6, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(134, 6, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(135, 6, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(136, 7, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(137, 7, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(138, 7, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(139, 7, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(140, 7, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(141, 8, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(142, 8, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(143, 8, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(144, 8, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(145, 8, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(146, 9, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(147, 9, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(148, 9, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(149, 9, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(150, 9, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(151, 10, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(152, 10, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(153, 10, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(154, 10, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(155, 10, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(156, 11, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(157, 11, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(158, 11, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(159, 11, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(160, 11, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(161, 12, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(162, 12, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(163, 12, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(164, 12, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(165, 12, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(166, 13, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(167, 13, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(168, 13, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(169, 13, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(170, 13, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(171, 14, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(172, 14, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(173, 14, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(174, 14, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(175, 14, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(176, 16, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(177, 16, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(178, 16, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(179, 16, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(180, 16, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(181, 17, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(182, 17, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(183, 17, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(184, 17, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(185, 18, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(186, 18, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(187, 18, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(188, 18, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(189, 18, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(190, 19, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(191, 19, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(192, 19, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(193, 19, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(194, 19, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(195, 20, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(196, 20, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(197, 20, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(198, 20, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(199, 20, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-26 10:00:54', '2026-01-26 10:00:54'),
(200, 15, '2026-01-19 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-26 10:01:14', '2026-01-26 10:01:14'),
(201, 15, '2026-01-20 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-26 10:01:14', '2026-01-26 10:01:14'),
(202, 15, '2026-01-21 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-26 10:01:14', '2026-01-26 10:01:14'),
(203, 15, '2026-01-22 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-26 10:01:14', '2026-01-26 10:01:14'),
(204, 15, '2026-01-23 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-01-26 10:01:14', '2026-01-26 10:01:14'),
(205, 1, '2026-01-27 07:25:00', '2026-01-27 17:05:00', 'Présent', 'Calculé pour Mardi (Limite: 465m, Arrivée: 445m). ', '2026-01-27 14:59:12', '2026-01-27 14:59:12'),
(206, 1, '2026-01-28 08:21:12', '2026-01-28 16:44:09', 'En Retard', 'Pointage automatique (Self-service)', '2026-01-28 08:21:12', '2026-01-28 16:44:09'),
(207, 1, '2026-01-29 09:44:09', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-29 09:44:09', '2026-01-29 09:44:09'),
(208, 24, '2026-01-29 09:50:54', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-29 09:50:54', '2026-01-29 09:50:54'),
(209, 21, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(210, 21, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(211, 21, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(212, 21, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(213, 21, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(214, 22, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(215, 22, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(216, 22, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(217, 22, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(218, 22, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(219, 23, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(220, 23, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(221, 23, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(222, 23, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(223, 23, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(224, 24, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(225, 24, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(226, 24, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(227, 24, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(228, 24, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-01-29 09:55:00', '2026-01-29 09:55:00'),
(229, 7, '2026-01-29 11:09:02', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-01-29 11:09:02', '2026-01-29 11:09:02'),
(230, 1, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(231, 1, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(232, 1, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(233, 1, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(234, 1, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(235, 2, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(236, 2, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(237, 2, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(238, 2, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(239, 2, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(240, 3, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(241, 3, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(242, 3, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(243, 3, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(244, 3, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(245, 4, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(246, 4, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(247, 4, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(248, 4, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(249, 4, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(250, 5, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(251, 5, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(252, 5, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(253, 5, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(254, 5, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(255, 6, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(256, 6, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(257, 6, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(258, 6, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(259, 6, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(260, 7, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(261, 7, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(262, 7, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(263, 7, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(264, 7, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(265, 8, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(266, 8, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(267, 8, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(268, 8, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(269, 8, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(270, 9, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(271, 9, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(272, 9, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(273, 9, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(274, 9, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(275, 10, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(276, 10, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(277, 10, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(278, 10, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(279, 10, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(280, 11, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(281, 11, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(282, 11, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(283, 11, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(284, 11, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(285, 12, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(286, 12, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(287, 12, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(288, 12, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(289, 12, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(290, 13, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(291, 13, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(292, 13, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(293, 13, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(294, 13, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(295, 14, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(296, 14, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(297, 14, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(298, 14, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(299, 14, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(300, 16, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(301, 16, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(302, 16, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(303, 16, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(304, 16, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(305, 17, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(306, 17, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(307, 17, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(308, 17, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(309, 17, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(310, 18, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(311, 18, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(312, 18, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(313, 18, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(314, 18, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(315, 19, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(316, 19, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(317, 19, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(318, 19, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(319, 19, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(320, 20, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(321, 20, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(322, 20, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(323, 20, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(324, 20, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(325, 21, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(326, 21, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(327, 21, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(328, 21, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(329, 21, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(330, 22, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(331, 22, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(332, 22, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(333, 22, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(334, 22, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(335, 23, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(336, 23, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(337, 23, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(338, 23, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(339, 23, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(340, 24, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(341, 24, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(342, 24, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(343, 24, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(344, 24, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-09 12:32:25', '2026-02-09 12:32:25'),
(345, 15, '2026-02-02 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-09 12:32:43', '2026-02-09 12:32:43'),
(346, 15, '2026-02-03 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-09 12:32:43', '2026-02-09 12:32:43'),
(347, 15, '2026-02-04 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-09 12:32:43', '2026-02-09 12:32:43'),
(348, 15, '2026-02-05 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-09 12:32:43', '2026-02-09 12:32:43'),
(349, 15, '2026-02-06 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-09 12:32:43', '2026-02-09 12:32:43'),
(350, 1, '2026-02-09 16:09:04', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-02-09 16:09:04', '2026-02-09 16:09:04'),
(351, 1, '2026-02-10 21:30:39', '2026-02-10 21:30:45', 'En Retard', 'Pointage automatique (Self-service)', '2026-02-10 21:30:39', '2026-02-10 21:30:45'),
(352, 1, '2026-02-23 09:37:03', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-02-23 09:37:03', '2026-02-23 09:37:03'),
(353, 1, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(354, 2, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(355, 2, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(356, 2, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(357, 2, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(358, 2, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(359, 3, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(360, 3, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(361, 3, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(362, 3, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(363, 3, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(364, 4, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(365, 4, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(366, 4, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(367, 4, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(368, 4, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(369, 5, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(370, 5, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(371, 5, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(372, 5, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(373, 5, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(374, 6, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(375, 6, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(376, 6, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(377, 6, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(378, 6, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(379, 7, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(380, 7, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(381, 7, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(382, 7, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(383, 7, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(384, 8, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(385, 8, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(386, 8, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(387, 8, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(388, 8, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(389, 9, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(390, 9, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(391, 9, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(392, 9, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(393, 9, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(394, 10, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(395, 10, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(396, 10, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(397, 10, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(398, 10, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(399, 11, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(400, 11, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(401, 11, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(402, 11, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(403, 11, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(404, 12, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(405, 12, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(406, 12, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(407, 12, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(408, 12, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(409, 13, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(410, 13, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(411, 13, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(412, 13, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(413, 13, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(414, 14, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26');
INSERT INTO `presences` (`id`, `agent_id`, `heure_arrivee`, `heure_depart`, `statut`, `notes`, `created_at`, `updated_at`) VALUES
(415, 14, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(416, 14, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(417, 14, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(418, 14, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(419, 16, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(420, 16, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(421, 16, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(422, 16, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(423, 16, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(424, 17, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(425, 17, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(426, 17, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(427, 17, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(428, 17, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(429, 18, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(430, 18, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(431, 18, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(432, 18, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(433, 18, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(434, 19, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(435, 19, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(436, 19, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(437, 19, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(438, 19, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(439, 20, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(440, 20, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(441, 20, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(442, 20, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(443, 20, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(444, 21, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(445, 21, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(446, 21, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(447, 21, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(448, 21, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(449, 22, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(450, 22, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(451, 22, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(452, 22, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(453, 22, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(454, 23, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(455, 23, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(456, 23, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(457, 23, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(458, 23, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(459, 24, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(460, 24, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(461, 24, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(462, 24, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(463, 24, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-02-23 09:40:26', '2026-02-23 09:40:26'),
(464, 1, '2026-02-17 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(465, 1, '2026-02-18 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(466, 1, '2026-02-19 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(467, 1, '2026-02-20 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(468, 15, '2026-02-16 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(469, 15, '2026-02-17 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(470, 15, '2026-02-18 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(471, 15, '2026-02-19 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(472, 15, '2026-02-20 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-02-23 09:41:15', '2026-02-23 09:41:15'),
(473, 1, '2026-02-24 07:10:29', '2026-02-24 15:03:58', 'Présent', 'Pointage automatique (Self-service)', '2026-02-24 07:10:29', '2026-02-24 15:03:58'),
(474, 1, '2026-03-02 13:45:51', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-03-02 13:45:51', '2026-03-02 13:45:51'),
(475, 1, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(476, 1, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(477, 1, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(478, 2, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(479, 2, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(480, 2, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(481, 2, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(482, 2, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(483, 3, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(484, 3, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(485, 3, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(486, 3, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(487, 3, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(488, 4, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(489, 4, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(490, 4, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(491, 5, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(492, 5, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(493, 5, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(494, 5, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(495, 5, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(496, 6, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(497, 6, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(498, 6, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(499, 6, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(500, 6, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(501, 7, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(502, 7, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(503, 7, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(504, 7, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(505, 7, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(506, 8, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(507, 8, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(508, 8, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(509, 8, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(510, 8, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(511, 9, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(512, 9, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(513, 9, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(514, 9, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(515, 9, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(516, 10, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(517, 10, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(518, 10, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(519, 10, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(520, 10, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(521, 11, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(522, 11, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(523, 11, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(524, 11, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(525, 11, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(526, 12, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(527, 12, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(528, 12, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(529, 12, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(530, 12, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(531, 13, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(532, 13, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(533, 13, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(534, 13, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(535, 13, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(536, 14, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(537, 14, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(538, 14, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(539, 14, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(540, 14, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(541, 16, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(542, 16, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(543, 16, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(544, 16, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(545, 16, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(546, 17, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(547, 17, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(548, 17, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(549, 17, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(550, 17, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(551, 18, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(552, 18, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(553, 18, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(554, 18, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(555, 18, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(556, 19, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(557, 19, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(558, 19, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(559, 19, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(560, 19, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(561, 20, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(562, 20, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(563, 20, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(564, 20, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(565, 20, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(566, 21, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(567, 21, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(568, 21, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(569, 21, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(570, 21, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(571, 22, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(572, 22, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(573, 22, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(574, 22, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(575, 22, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(576, 23, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(577, 23, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(578, 23, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(579, 23, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(580, 23, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(581, 24, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(582, 24, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(583, 24, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(584, 24, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(585, 24, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(586, 25, '2026-02-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(587, 25, '2026-02-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(588, 25, '2026-02-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(589, 25, '2026-02-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(590, 25, '2026-02-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-02 13:46:09', '2026-03-02 13:46:09'),
(591, 4, '2026-02-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(592, 4, '2026-02-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(593, 15, '2026-02-23 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(594, 15, '2026-02-24 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(595, 15, '2026-02-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(596, 15, '2026-02-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(597, 15, '2026-02-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-02 13:46:42', '2026-03-02 13:46:42'),
(598, 1, '2026-03-03 10:53:58', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-03-03 10:53:58', '2026-03-03 10:53:58'),
(600, 1, '2026-03-09 08:28:25', '2026-03-09 17:05:21', 'En Retard', 'Pointage automatique (Self-service)', '2026-03-09 08:28:25', '2026-03-09 17:05:21'),
(601, 1, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(602, 1, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(603, 1, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(604, 2, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(605, 2, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(606, 2, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(607, 2, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(608, 2, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(609, 3, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(610, 3, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(611, 3, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(612, 3, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(613, 3, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(614, 4, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(615, 4, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(616, 4, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(617, 4, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(618, 4, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(619, 5, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(620, 5, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(621, 5, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(622, 5, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(623, 5, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(624, 6, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(625, 6, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(626, 6, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(627, 6, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(628, 6, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(629, 7, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(630, 7, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(631, 7, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(632, 7, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(633, 7, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(634, 8, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(635, 8, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(636, 8, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(637, 8, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(638, 8, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(639, 9, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(640, 9, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(641, 9, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(642, 9, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(643, 9, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(644, 10, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(645, 10, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(646, 10, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(647, 10, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(648, 10, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(649, 11, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(650, 11, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(651, 11, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(652, 11, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(653, 11, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(654, 12, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(655, 12, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(656, 12, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(657, 12, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(658, 12, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:54', '2026-03-09 10:53:54'),
(659, 13, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(660, 13, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(661, 13, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(662, 13, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(663, 13, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(664, 14, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(665, 14, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(666, 14, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(667, 14, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(668, 14, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(669, 16, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(670, 16, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(671, 16, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(672, 16, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(673, 16, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(674, 17, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(675, 17, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(676, 17, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(677, 17, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(678, 17, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(679, 18, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(680, 18, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(681, 18, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(682, 18, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(683, 18, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(684, 19, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(685, 19, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(686, 19, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(687, 19, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(688, 19, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(689, 20, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(690, 20, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(691, 20, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(692, 20, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(693, 20, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(694, 21, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(695, 21, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(696, 21, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(697, 21, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(698, 21, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(699, 22, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(700, 22, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(701, 22, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(702, 22, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(703, 22, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(704, 23, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(705, 23, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(706, 23, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(707, 23, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(708, 23, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(709, 24, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(710, 24, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(711, 24, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(712, 24, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(713, 24, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(714, 25, '2026-03-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(715, 25, '2026-03-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(716, 25, '2026-03-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(717, 25, '2026-03-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(718, 25, '2026-03-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-09 10:53:55', '2026-03-09 10:53:55'),
(719, 15, '2026-03-02 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-09 10:54:09', '2026-03-09 10:54:09'),
(720, 15, '2026-03-03 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-09 10:54:09', '2026-03-09 10:54:09'),
(721, 15, '2026-03-04 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-09 10:54:09', '2026-03-09 10:54:09'),
(722, 15, '2026-03-05 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-09 10:54:09', '2026-03-09 10:54:09'),
(723, 15, '2026-03-06 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-09 10:54:09', '2026-03-09 10:54:09'),
(724, 2, '2026-03-11 09:26:54', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-03-11 09:26:54', '2026-03-11 09:26:54'),
(725, 1, '2026-03-11 07:33:00', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-03-11 09:33:51', '2026-03-19 11:56:51'),
(726, 1, '2026-03-12 06:54:58', NULL, 'Présent', 'Pointage automatique (Self-service)', '2026-03-12 06:54:58', '2026-03-12 06:54:58'),
(728, 1, '2026-03-19 06:55:00', '2026-03-19 14:31:50', 'Présent', 'Pointage automatique (Self-service)', '2026-03-19 11:49:27', '2026-03-19 14:31:50'),
(729, 1, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(730, 2, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(731, 2, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(732, 2, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(733, 2, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(734, 3, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(735, 3, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(736, 3, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(737, 3, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(738, 3, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(739, 4, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(740, 4, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(741, 4, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(742, 4, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(743, 4, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(744, 5, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(745, 5, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(746, 6, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(747, 6, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(748, 6, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(749, 6, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(750, 6, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(751, 7, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(752, 7, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(753, 7, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(754, 7, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(755, 7, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(756, 8, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(757, 8, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(758, 8, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(759, 8, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(760, 8, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(761, 9, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(762, 9, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(763, 10, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(764, 10, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(765, 10, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(766, 10, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(767, 10, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(768, 11, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(769, 11, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(770, 11, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(771, 11, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(772, 11, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(773, 12, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(774, 12, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(775, 12, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(776, 12, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(777, 12, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(778, 13, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(779, 13, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(780, 13, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(781, 13, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(782, 13, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(783, 14, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(784, 14, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(785, 14, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(786, 14, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(787, 14, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(788, 16, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(789, 16, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(790, 17, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(791, 17, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(792, 17, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(793, 17, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(794, 17, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(795, 18, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(796, 18, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(797, 19, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(798, 19, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(799, 19, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(800, 19, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(801, 19, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(802, 20, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(803, 21, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(804, 21, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(805, 21, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(806, 21, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(807, 21, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(808, 22, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(809, 22, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(810, 23, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(811, 23, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(812, 24, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(813, 24, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(814, 24, '2026-03-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(815, 24, '2026-03-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(816, 24, '2026-03-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(817, 25, '2026-03-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(818, 25, '2026-03-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-19 11:57:26', '2026-03-19 11:57:26'),
(819, 1, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(820, 5, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(821, 5, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(822, 5, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(823, 9, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(824, 9, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(825, 9, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(826, 15, '2026-03-09 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(827, 15, '2026-03-10 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(828, 15, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(829, 15, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(830, 15, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(831, 16, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(832, 16, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(833, 16, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(834, 18, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39');
INSERT INTO `presences` (`id`, `agent_id`, `heure_arrivee`, `heure_depart`, `statut`, `notes`, `created_at`, `updated_at`) VALUES
(835, 18, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(836, 18, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(837, 20, '2026-03-10 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(838, 20, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(839, 20, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(840, 20, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(841, 22, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(842, 22, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(843, 22, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(844, 23, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(845, 23, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(846, 23, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(847, 25, '2026-03-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(848, 25, '2026-03-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(849, 25, '2026-03-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-19 11:57:39', '2026-03-19 11:57:39'),
(850, 2, '2026-03-19 08:01:00', NULL, 'En Retard', 'Calculé pour Jeudi (Limite: 465m, Arrivée: 481m). ', '2026-03-19 12:01:38', '2026-03-19 12:01:38'),
(851, 4, '2026-03-19 07:45:00', NULL, 'Présent', 'Calculé pour Jeudi (Limite: 465m, Arrivée: 465m). ', '2026-03-19 12:02:45', '2026-03-19 12:02:45'),
(852, 1, '2026-03-23 06:47:34', NULL, 'Présent', 'Pointage automatique (Self-service)', '2026-03-23 06:47:34', '2026-03-23 06:47:34'),
(853, 1, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(854, 1, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(855, 2, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(856, 2, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(857, 3, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(858, 3, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(859, 3, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(860, 4, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(861, 4, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(862, 5, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:48', '2026-03-23 06:48:48'),
(863, 6, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(864, 6, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(865, 6, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(866, 7, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(867, 7, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(868, 7, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(869, 8, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(870, 8, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(871, 8, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(872, 9, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(873, 9, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(874, 9, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(875, 10, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(876, 10, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(877, 10, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(878, 11, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(879, 11, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(880, 12, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(881, 12, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(882, 12, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(883, 13, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(884, 13, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(885, 13, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(886, 14, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(887, 14, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(888, 14, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(889, 16, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(890, 16, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(891, 17, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(892, 17, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(893, 17, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(894, 18, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(895, 18, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(896, 18, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(897, 19, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(898, 19, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(899, 19, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(900, 20, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(901, 20, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(902, 20, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(903, 21, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(904, 21, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(905, 21, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(906, 22, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(907, 22, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(908, 22, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(909, 23, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(910, 23, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(911, 23, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(912, 24, '2026-03-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(913, 24, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(914, 24, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(915, 25, '2026-03-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(916, 25, '2026-03-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-23 06:48:49', '2026-03-23 06:48:49'),
(917, 5, '2026-03-17 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(918, 5, '2026-03-18 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(919, 11, '2026-03-19 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(920, 15, '2026-03-17 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(921, 15, '2026-03-18 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(922, 15, '2026-03-19 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(923, 16, '2026-03-19 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(924, 25, '2026-03-17 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-23 06:49:20', '2026-03-23 06:49:20'),
(925, 1, '2026-03-30 09:58:21', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-03-30 09:58:21', '2026-03-30 09:58:21'),
(926, 1, '2026-03-24 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(927, 1, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(928, 1, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(929, 1, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(930, 2, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(931, 2, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(932, 2, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(933, 2, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(934, 2, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(935, 3, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(936, 3, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:51', '2026-03-30 09:58:51'),
(937, 3, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(938, 3, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(939, 3, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(940, 4, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(941, 4, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(942, 6, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(943, 6, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(944, 6, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(945, 6, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(946, 6, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(947, 7, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(948, 7, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(949, 7, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(950, 7, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(951, 7, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(952, 8, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(953, 8, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(954, 8, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(955, 8, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(956, 8, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(957, 9, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(958, 9, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(959, 9, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(960, 9, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(961, 9, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(962, 10, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(963, 10, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(964, 10, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(965, 10, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(966, 10, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(967, 11, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(968, 11, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(969, 11, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(970, 11, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(971, 11, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(972, 12, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(973, 12, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(974, 12, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(975, 12, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(976, 12, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(977, 13, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(978, 13, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(979, 13, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(980, 13, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(981, 13, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(982, 14, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(983, 14, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(984, 14, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(985, 14, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(986, 14, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(987, 16, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(988, 16, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(989, 17, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(990, 17, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(991, 18, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(992, 18, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(993, 19, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(994, 19, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(995, 19, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(996, 19, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(997, 19, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(998, 21, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(999, 21, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1000, 21, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1001, 21, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1002, 21, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1003, 22, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1004, 22, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1005, 22, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1006, 22, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1007, 22, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1008, 23, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1009, 23, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1010, 23, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1011, 23, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1012, 23, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1013, 24, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1014, 24, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1015, 24, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1016, 24, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1017, 24, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1018, 25, '2026-03-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1019, 25, '2026-03-24 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1020, 25, '2026-03-25 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1021, 25, '2026-03-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1022, 25, '2026-03-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-03-30 09:58:52', '2026-03-30 09:58:52'),
(1023, 4, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1024, 4, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1025, 4, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1026, 5, '2026-03-23 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1027, 5, '2026-03-24 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1028, 5, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1029, 5, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1030, 5, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1031, 15, '2026-03-23 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1032, 15, '2026-03-24 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1033, 15, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1034, 15, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1035, 15, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1036, 16, '2026-03-23 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1037, 16, '2026-03-24 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1038, 16, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1039, 17, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1040, 17, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1041, 17, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1042, 18, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1043, 18, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1044, 18, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1045, 20, '2026-03-23 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1046, 20, '2026-03-24 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1047, 20, '2026-03-25 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1048, 20, '2026-03-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1049, 20, '2026-03-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-03-30 09:59:07', '2026-03-30 09:59:07'),
(1050, 1, '2026-04-02 08:15:52', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-04-02 08:15:52', '2026-04-02 08:15:52'),
(1051, 1, '2026-04-01 07:22:00', NULL, 'Présent', 'Calculé pour Mercredi (Limite: 465m, Arrivée: 442m). ', '2026-04-02 08:22:38', '2026-04-02 08:22:38'),
(1052, 2, '2026-04-01 07:45:00', NULL, 'Présent', 'Calculé pour Mercredi (Limite: 465m, Arrivée: 465m). ', '2026-04-02 08:23:56', '2026-04-02 08:23:56'),
(1053, 2, '2026-04-02 08:10:00', NULL, 'En Retard', 'Calculé pour Jeudi (Limite: 465m, Arrivée: 490m). ', '2026-04-02 08:24:27', '2026-04-02 08:24:27'),
(1054, 1, '2026-04-03 08:47:59', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-04-03 08:47:59', '2026-04-03 08:47:59'),
(1055, 1, '2026-04-13 07:10:00', NULL, 'Présent', 'Calculé pour Lundi (Limite: 465m, Arrivée: 430m). ', '2026-04-13 15:50:42', '2026-04-13 15:50:42'),
(1056, 1, '2026-04-10 07:02:00', NULL, 'Présent', 'Calculé pour Vendredi (Limite: 465m, Arrivée: 422m). ', '2026-04-13 15:51:17', '2026-04-13 15:51:17'),
(1057, 1, '2026-04-09 06:51:00', NULL, 'Présent', 'Calculé pour Jeudi (Limite: 465m, Arrivée: 411m). ', '2026-04-13 15:51:41', '2026-04-13 15:51:41'),
(1058, 1, '2026-04-08 06:52:00', NULL, 'Présent', 'Calculé pour Mercredi (Limite: 465m, Arrivée: 412m). ', '2026-04-13 15:52:35', '2026-04-13 15:52:35'),
(1059, 1, '2026-04-07 07:46:00', NULL, 'En Retard', 'Calculé pour Mardi (Limite: 465m, Arrivée: 466m). ', '2026-04-13 15:53:16', '2026-04-13 15:53:16'),
(1060, 2, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1061, 2, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1062, 2, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1063, 2, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1064, 3, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1065, 3, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1066, 3, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1067, 3, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1068, 4, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1069, 4, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1070, 4, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1071, 4, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1072, 5, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1073, 5, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1074, 6, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1075, 6, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1076, 6, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1077, 6, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1078, 7, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1079, 7, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1080, 7, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1081, 7, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1082, 8, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1083, 8, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1084, 8, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1085, 8, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1086, 9, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1087, 9, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1088, 9, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1089, 9, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1090, 10, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1091, 10, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1092, 10, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1093, 10, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1094, 11, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1095, 11, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1096, 11, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1097, 11, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1098, 12, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1099, 12, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1100, 12, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1101, 12, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1102, 13, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1103, 13, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1104, 13, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1105, 13, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1106, 14, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1107, 14, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1108, 14, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1109, 14, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1110, 16, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1111, 16, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1112, 16, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1113, 16, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1114, 17, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1115, 17, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1116, 17, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1117, 17, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1118, 18, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1119, 18, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1120, 18, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1121, 18, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1122, 19, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1123, 19, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1124, 19, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1125, 19, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1126, 20, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1127, 20, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1128, 20, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1129, 20, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1130, 21, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1131, 21, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1132, 21, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1133, 21, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1134, 22, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1135, 22, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1136, 22, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1137, 22, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1138, 23, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1139, 23, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1140, 23, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1141, 23, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1142, 24, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1143, 24, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1144, 24, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1145, 24, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1146, 25, '2026-04-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1147, 25, '2026-04-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1148, 25, '2026-04-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1149, 25, '2026-04-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 15:53:49', '2026-04-13 15:53:49'),
(1150, 5, '2026-04-07 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 15:54:01', '2026-04-13 15:54:01'),
(1151, 5, '2026-04-08 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 15:54:01', '2026-04-13 15:54:01'),
(1152, 15, '2026-04-07 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 15:54:01', '2026-04-13 15:54:01'),
(1153, 15, '2026-04-08 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 15:54:01', '2026-04-13 15:54:01'),
(1154, 15, '2026-04-09 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 15:54:01', '2026-04-13 15:54:01'),
(1155, 15, '2026-04-10 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 15:54:01', '2026-04-13 15:54:01'),
(1156, 2, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1157, 3, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1158, 4, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1159, 5, '2026-03-30 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1160, 6, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1161, 7, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1162, 8, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1163, 9, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1164, 10, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1165, 11, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1166, 12, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1167, 13, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1168, 14, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1169, 15, '2026-03-30 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1170, 16, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1171, 17, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1172, 18, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1173, 19, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1174, 20, '2026-03-30 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1175, 21, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1176, 22, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1177, 23, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1178, 24, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1179, 25, '2026-03-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1180, 1, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1181, 2, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1182, 3, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1183, 4, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1184, 5, '2026-03-31 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1185, 6, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1186, 7, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1187, 8, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1188, 9, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1189, 10, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1190, 11, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1191, 12, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1192, 13, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1193, 14, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1194, 15, '2026-03-31 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1195, 16, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1196, 17, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1197, 18, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1198, 19, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1199, 20, '2026-03-31 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1200, 21, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1201, 22, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1202, 23, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1203, 24, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1204, 25, '2026-03-31 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1205, 3, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1206, 4, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1207, 5, '2026-04-01 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1208, 6, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1209, 7, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1210, 8, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1211, 9, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1212, 10, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1213, 11, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1214, 12, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1215, 13, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1216, 14, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1217, 15, '2026-04-01 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1218, 16, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1219, 17, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1220, 18, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1221, 19, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1222, 20, '2026-04-01 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1223, 21, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1224, 22, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1225, 23, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1226, 24, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1227, 25, '2026-04-01 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1228, 3, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1229, 4, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1230, 5, '2026-04-02 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1231, 6, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1232, 7, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1233, 8, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1234, 9, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1235, 10, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1236, 11, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1237, 12, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1238, 13, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1239, 14, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1240, 15, '2026-04-02 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1241, 16, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1242, 17, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1243, 18, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1244, 19, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1245, 20, '2026-04-02 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1246, 21, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1247, 22, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1248, 23, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59');
INSERT INTO `presences` (`id`, `agent_id`, `heure_arrivee`, `heure_depart`, `statut`, `notes`, `created_at`, `updated_at`) VALUES
(1249, 24, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1250, 25, '2026-04-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1251, 2, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1252, 3, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1253, 4, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1254, 5, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1255, 6, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1256, 7, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1257, 8, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1258, 9, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1259, 10, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1260, 11, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1261, 12, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1262, 13, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1263, 14, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1264, 15, '2026-04-03 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1265, 16, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1266, 17, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1267, 18, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1268, 19, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1269, 20, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1270, 21, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1271, 22, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1272, 23, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1273, 24, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1274, 25, '2026-04-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-13 16:46:59', '2026-04-13 16:46:59'),
(1275, 25, '2026-02-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1276, 25, '2026-02-03 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1277, 25, '2026-02-04 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1278, 25, '2026-02-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1279, 25, '2026-02-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1280, 2, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1281, 3, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1282, 4, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1283, 5, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1284, 6, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1285, 7, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1286, 8, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1287, 9, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1288, 10, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1289, 11, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1290, 12, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1291, 13, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1292, 14, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1293, 16, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1294, 17, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1295, 18, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1296, 19, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1297, 20, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1298, 21, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1299, 22, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1300, 23, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1301, 24, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1302, 25, '2026-02-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1303, 2, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1304, 3, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1305, 4, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1306, 5, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1307, 6, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1308, 7, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1309, 8, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:26', '2026-04-14 10:08:26'),
(1310, 9, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1311, 10, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1312, 11, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1313, 12, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1314, 13, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1315, 14, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1316, 16, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1317, 17, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1318, 18, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1319, 19, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1320, 20, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1321, 21, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1322, 22, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1323, 23, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1324, 24, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1325, 25, '2026-02-10 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1326, 1, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1327, 2, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1328, 3, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1329, 4, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1330, 5, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1331, 6, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1332, 7, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1333, 8, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1334, 9, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1335, 10, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1336, 11, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1337, 12, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1338, 13, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1339, 14, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1340, 16, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1341, 17, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1342, 18, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1343, 19, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1344, 20, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1345, 21, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1346, 22, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1347, 23, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1348, 24, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1349, 25, '2026-02-11 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1350, 1, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1351, 2, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1352, 3, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1353, 4, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1354, 5, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1355, 6, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1356, 7, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1357, 8, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1358, 9, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1359, 10, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1360, 11, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1361, 12, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1362, 13, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1363, 14, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1364, 16, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1365, 17, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1366, 18, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1367, 19, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1368, 20, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1369, 21, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1370, 22, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1371, 23, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1372, 24, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1373, 25, '2026-02-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1374, 1, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1375, 2, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1376, 3, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1377, 4, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1378, 5, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1379, 6, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1380, 7, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1381, 8, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1382, 9, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1383, 10, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1384, 11, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1385, 12, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1386, 13, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1387, 14, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1388, 16, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1389, 17, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1390, 18, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1391, 19, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1392, 20, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1393, 21, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1394, 22, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1395, 23, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1396, 24, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1397, 25, '2026-02-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1398, 25, '2026-02-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1399, 25, '2026-02-17 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1400, 25, '2026-02-18 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1401, 25, '2026-02-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1402, 25, '2026-02-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:08:27', '2026-04-14 10:08:27'),
(1403, 15, '2026-02-09 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:11:02', '2026-04-14 10:11:02'),
(1404, 15, '2026-02-10 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:11:02', '2026-04-14 10:11:02'),
(1405, 15, '2026-02-11 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:11:02', '2026-04-14 10:11:02'),
(1406, 15, '2026-02-12 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:11:02', '2026-04-14 10:11:02'),
(1407, 15, '2026-02-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:11:02', '2026-04-14 10:11:02'),
(1408, 1, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1409, 2, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1410, 3, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1411, 4, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1412, 5, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1413, 6, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1414, 7, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1415, 8, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1416, 9, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1417, 10, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1418, 11, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1419, 12, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1420, 13, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1421, 14, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1422, 16, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1423, 17, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1424, 18, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1425, 19, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1426, 20, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1427, 21, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1428, 22, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1429, 23, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1430, 24, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1431, 25, '2026-01-02 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1432, 1, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1433, 2, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1434, 3, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1435, 4, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1436, 5, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1437, 6, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1438, 7, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1439, 8, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1440, 9, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1441, 10, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1442, 11, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1443, 12, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1444, 13, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1445, 14, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1446, 16, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1447, 17, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1448, 18, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1449, 19, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1450, 20, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1451, 21, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1452, 22, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1453, 23, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1454, 24, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1455, 25, '2026-01-05 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1456, 1, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1457, 2, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1458, 3, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1459, 4, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1460, 5, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1461, 6, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1462, 7, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1463, 8, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1464, 9, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1465, 10, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1466, 11, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1467, 12, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1468, 13, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1469, 14, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1470, 16, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1471, 17, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1472, 18, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1473, 19, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1474, 20, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1475, 21, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1476, 22, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1477, 23, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1478, 24, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1479, 25, '2026-01-06 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1480, 1, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1481, 2, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1482, 3, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1483, 4, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1484, 5, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1485, 6, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1486, 7, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1487, 8, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1488, 9, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1489, 10, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1490, 11, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1491, 12, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1492, 13, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1493, 14, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1494, 16, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1495, 17, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1496, 18, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1497, 19, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1498, 20, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1499, 21, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1500, 22, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1501, 23, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1502, 24, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1503, 25, '2026-01-07 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1504, 1, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1505, 2, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1506, 3, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1507, 4, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1508, 5, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1509, 6, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1510, 7, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:20', '2026-04-14 10:51:20'),
(1511, 8, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1512, 9, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1513, 10, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1514, 11, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1515, 12, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1516, 13, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1517, 14, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1518, 16, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1519, 17, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1520, 18, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1521, 19, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1522, 20, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1523, 21, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1524, 22, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1525, 23, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1526, 24, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1527, 25, '2026-01-08 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1528, 1, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1529, 2, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1530, 3, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1531, 4, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1532, 5, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1533, 6, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1534, 7, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1535, 8, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1536, 9, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1537, 10, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1538, 11, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1539, 12, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1540, 13, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1541, 14, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1542, 16, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1543, 17, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1544, 18, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1545, 19, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1546, 20, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1547, 21, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1548, 22, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1549, 23, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1550, 24, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1551, 25, '2026-01-09 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1552, 19, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1553, 20, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1554, 21, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1555, 22, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1556, 23, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1557, 24, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1558, 25, '2026-01-12 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1559, 19, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1560, 20, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1561, 21, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1562, 22, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1563, 23, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1564, 24, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1565, 25, '2026-01-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1566, 19, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1567, 20, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1568, 21, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1569, 22, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1570, 23, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1571, 24, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1572, 25, '2026-01-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1573, 19, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1574, 20, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1575, 21, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1576, 22, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1577, 23, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1578, 24, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1579, 25, '2026-01-15 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1580, 19, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1581, 20, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1582, 21, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1583, 22, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1584, 23, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1585, 24, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1586, 25, '2026-01-16 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1587, 25, '2026-01-19 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1588, 25, '2026-01-20 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1589, 25, '2026-01-21 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1590, 25, '2026-01-22 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1591, 25, '2026-01-23 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1592, 2, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1593, 3, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1594, 4, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1595, 5, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1596, 6, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1597, 7, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1598, 8, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1599, 9, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1600, 10, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1601, 11, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1602, 12, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1603, 13, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1604, 14, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1605, 16, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1606, 17, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1607, 18, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1608, 19, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1609, 20, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1610, 21, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1611, 22, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1612, 23, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1613, 24, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1614, 25, '2026-01-26 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1615, 2, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1616, 3, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1617, 4, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1618, 5, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1619, 6, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1620, 7, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1621, 8, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1622, 9, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1623, 10, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1624, 11, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1625, 12, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1626, 13, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1627, 14, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1628, 16, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1629, 17, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1630, 18, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1631, 19, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1632, 20, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1633, 21, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1634, 22, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1635, 23, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1636, 24, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1637, 25, '2026-01-27 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1638, 2, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1639, 3, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1640, 4, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1641, 5, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1642, 6, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1643, 7, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1644, 8, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1645, 9, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1646, 10, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1647, 11, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1648, 12, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1649, 13, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1650, 14, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1651, 16, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1652, 17, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1653, 18, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1654, 19, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1655, 20, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1656, 21, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1657, 22, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1658, 23, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1659, 24, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1660, 25, '2026-01-28 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1661, 2, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1662, 3, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1663, 4, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1664, 5, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21');
INSERT INTO `presences` (`id`, `agent_id`, `heure_arrivee`, `heure_depart`, `statut`, `notes`, `created_at`, `updated_at`) VALUES
(1665, 6, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1666, 8, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1667, 9, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1668, 10, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1669, 11, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1670, 12, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1671, 13, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1672, 14, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1673, 16, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1674, 17, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1675, 18, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1676, 19, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1677, 20, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1678, 21, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1679, 22, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1680, 23, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1681, 25, '2026-01-29 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1682, 1, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1683, 2, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1684, 3, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1685, 4, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1686, 5, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1687, 6, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1688, 7, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1689, 8, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1690, 9, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1691, 10, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1692, 11, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1693, 12, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1694, 13, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1695, 14, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1696, 16, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1697, 17, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1698, 18, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1699, 19, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1700, 20, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1701, 21, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1702, 22, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1703, 23, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1704, 24, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1705, 25, '2026-01-30 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 10:51:21', '2026-04-14 10:51:21'),
(1706, 15, '2026-01-02 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1707, 15, '2026-01-05 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1708, 15, '2026-01-06 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1709, 15, '2026-01-07 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1710, 15, '2026-01-08 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1711, 15, '2026-01-09 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1712, 15, '2026-01-26 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1713, 15, '2026-01-27 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1714, 15, '2026-01-28 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1715, 15, '2026-01-29 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1716, 15, '2026-01-30 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 10:52:01', '2026-04-14 10:52:01'),
(1717, 1, '2026-04-14 07:32:00', NULL, 'Présent', 'Calculé pour Mardi (Limite: 465m, Arrivée: 452m). ', '2026-04-14 15:32:44', '2026-04-14 15:32:44'),
(1718, 2, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1719, 4, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1720, 5, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1721, 6, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1722, 8, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1723, 9, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1724, 10, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1725, 11, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1726, 12, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1727, 13, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1728, 14, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1729, 16, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1730, 17, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1731, 18, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1732, 19, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1733, 20, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1734, 21, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1735, 22, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1736, 23, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1737, 25, '2026-04-13 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1738, 2, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1739, 4, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1740, 5, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1741, 6, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1742, 8, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1743, 9, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1744, 10, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1745, 11, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1746, 12, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1747, 13, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1748, 14, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1749, 16, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1750, 17, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1751, 18, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1752, 19, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1753, 20, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1754, 21, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1755, 22, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1756, 23, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1757, 25, '2026-04-14 08:00:00', NULL, 'Absent', 'Absence hebdomadaire.', '2026-04-14 16:03:43', '2026-04-14 16:03:43'),
(1758, 3, '2026-04-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1759, 7, '2026-04-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1760, 15, '2026-04-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1761, 24, '2026-04-13 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1762, 3, '2026-04-14 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1763, 7, '2026-04-14 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1764, 15, '2026-04-14 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1765, 24, '2026-04-14 08:00:00', NULL, 'Absence Justifiée', 'Justifié: ', '2026-04-14 16:03:59', '2026-04-14 16:03:59'),
(1766, 1, '2026-04-15 08:19:26', NULL, 'En Retard', 'Pointage automatique (Self-service)', '2026-04-15 08:19:26', '2026-04-15 08:19:26'),
(1767, 1, '2026-04-16 06:50:00', NULL, 'Présent', 'Pointage automatique (Self-service)', '2026-04-16 10:50:39', '2026-04-16 10:51:04');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `validation` enum('en_attente','acceptee','rejetee') NOT NULL DEFAULT 'en_attente',
  `document_final_signe` varchar(191) DEFAULT NULL,
  `date_approbation` timestamp NULL DEFAULT NULL,
  `imputation_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  `fichiers_joints` text DEFAULT NULL,
  `date_reponse` datetime NOT NULL DEFAULT '2026-01-20 09:36:59',
  `pourcentage_avancement` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reponses_imputation_id_foreign` (`imputation_id`),
  KEY `reponses_agent_id_foreign` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id`, `validation`, `document_final_signe`, `date_approbation`, `imputation_id`, `agent_id`, `contenu`, `fichiers_joints`, `date_reponse`, `pourcentage_avancement`, `created_at`, `updated_at`) VALUES
(1, 'en_attente', NULL, NULL, 4, 5, 'TRAVAIL EFFECTUE', '[\"1769087083_Projet de Note du DSESF au DG_S\\u00e9minaire Loi de r\\u00e8glement 18 20 d\\u00e9c 2024.pdf\"]', '2026-01-22 13:04:43', 100, '2026-01-22 13:04:43', '2026-01-22 13:04:43'),
(2, 'en_attente', NULL, NULL, 5, 1, 'merci', '[\"1769093675_Projet de Note du DSESF au DG_S\\u00e9minaire Loi de r\\u00e8glement 18 20 d\\u00e9c 2024.pdf\"]', '2026-01-22 14:54:35', 100, '2026-01-22 14:54:35', '2026-01-22 14:54:35'),
(3, 'acceptee', 'archives/final/1769103119_FINAL_Note de service_DEMANDE D\'INFORMATIONS COMITE COUT SDEEF.pdf', '2026-01-22 17:31:59', 6, 1, 'voici la reponse jointe', '[\"1769102744_Projet de Note du DSESF au DG_S\\u00e9minaire Loi de r\\u00e8glement 18 20 d\\u00e9c 2024.pdf\"]', '2026-01-22 17:25:44', 100, '2026-01-22 17:25:44', '2026-01-22 17:31:59'),
(4, 'acceptee', 'archives/final/1769428292_FINAL_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-01-26 11:51:32', 11, 2, 'Travail accompli', '[\"1769428241__0040_du_2026-01-21.pdf\",\"1769428241_Document_2026-01-26_formation.pdf\"]', '2026-01-26 11:50:41', 100, '2026-01-26 11:50:41', '2026-01-26 11:51:32'),
(5, 'en_attente', NULL, NULL, 23, 1, 'REP', '[\"1769681913_COMMISSION PARITAIRE DE SUIVI DU PROFIL DE CARRIERE.pdf\"]', '2026-01-29 10:18:33', 100, '2026-01-29 10:18:33', '2026-01-29 10:18:33'),
(6, 'acceptee', 'archives/final/1769682106_FINAL_Tuto PHP.pdf', '2026-01-29 10:21:46', 24, 1, 'REP', '[\"1769682035_Tuto PHP.pdf\"]', '2026-01-29 10:20:35', 100, '2026-01-29 10:20:35', '2026-01-29 10:21:46'),
(7, 'acceptee', 'archives/final/1772027436_FINAL_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '2026-02-25 13:50:36', 28, 1, 'travail fait ce jour', '[\"1772026981_Note de service_DEMANDE D\'INFORMATIONS COMITE COUT SDEEF.pdf\",\"1772026981_Projet de Note du DSESF au DG_S\\u00e9minaire Loi de r\\u00e8glement 18 20 d\\u00e9c 2024.pdf\"]', '2026-02-25 13:43:01', 100, '2026-02-25 13:43:01', '2026-02-25 13:50:36');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-01-20 09:37:00', '2026-01-20 09:37:00'),
(2, 'utilisateur', 'web', '2026-01-20 09:37:00', '2026-01-20 09:37:00'),
(3, 'editeur', 'web', '2026-01-27 08:48:28', '2026-01-27 08:48:28'),
(4, 'rh', 'web', '2026-01-27 08:48:28', '2026-01-27 08:48:28'),
(5, 'Superviseur', 'web', '2026-01-27 10:50:42', '2026-01-27 10:50:42'),
(6, 'Accueil', 'web', '2026-04-01 17:18:23', '2026-04-01 17:18:23');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 5),
(2, 1),
(2, 5),
(3, 1),
(3, 2),
(3, 4),
(3, 5),
(3, 6),
(4, 1),
(4, 5),
(5, 1),
(5, 3),
(5, 5),
(6, 1),
(6, 5),
(7, 1),
(7, 5),
(8, 1),
(8, 3),
(8, 4),
(8, 5),
(8, 6);

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(23, 3, 5),
(3, 9, 1),
(4, 2, 2),
(5, 4, 2),
(29, 6, 1),
(7, 5, 2),
(8, 10, 2),
(9, 11, 2),
(10, 12, 2),
(11, 13, 2),
(12, 14, 2),
(13, 15, 2),
(14, 16, 2),
(15, 17, 2),
(16, 21, 2),
(21, 22, 3),
(18, 20, 2),
(22, 19, 4),
(20, 18, 2),
(24, 23, 2),
(25, 24, 2),
(26, 25, 3),
(27, 4, 3),
(28, 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `scripts_extraction`
--

DROP TABLE IF EXISTS `scripts_extraction`;
CREATE TABLE IF NOT EXISTS `scripts_extraction` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parametres` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametres`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `scripts_extraction`
--

INSERT INTO `scripts_extraction` (`id`, `nom`, `description`, `parametres`, `created_at`, `updated_at`, `code`) VALUES
(3, 'Liste des agents', NULL, '\"{\\\"connection_type\\\":\\\"mariadb\\\",\\\"ora_host\\\":null,\\\"ora_db\\\":null,\\\"ora_user\\\":null,\\\"ora_pass\\\":null,\\\"ora_as\\\":\\\"NORMAL\\\"}\"', '2026-02-16 10:33:18', '2026-02-16 10:33:18', 'select * from agents'),
(5, 'iste des imputations', NULL, '\"{\\\"connection_type\\\":\\\"mariadb\\\",\\\"ora_host\\\":null,\\\"ora_db\\\":null,\\\"ora_user\\\":null,\\\"ora_pass\\\":null,\\\"ora_as\\\":\\\"NORMAL\\\"}\"', '2026-03-11 10:22:24', '2026-03-11 10:22:24', 'select * from imputations');

-- --------------------------------------------------------

--
-- Structure de la table `seminaires`
--

DROP TABLE IF EXISTS `seminaires`;
CREATE TABLE IF NOT EXISTS `seminaires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` uuid DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `lieu` varchar(255) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `organisateur` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'planifie',
  `nb_participants_prevu` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seminaires_uuid_unique` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seminaires`
--

INSERT INTO `seminaires` (`id`, `uuid`, `titre`, `description`, `lieu`, `date_debut`, `date_fin`, `organisateur`, `statut`, `nb_participants_prevu`, `created_at`, `updated_at`) VALUES
(1, 'a80b91c8-6a95-4942-bfd7-79b7566518b1', 'Seminaire IA', 'Séminaire de renforcement de capacité sur IA dans la Gestion des Statistiques et de l\'Administration', 'Assinie Sud Comoé', '2026-03-25 09:00:00', '2026-03-27 17:00:00', 'DESEF', 'termine', 10, '2026-04-03 07:38:15', '2026-04-07 14:21:21'),
(2, '749f9352-e0be-4afa-b56b-f3597cae1ce8', 'Séminaire du 1er Trimestre 2026', 'Bilan du 1er Trimestre 2026', 'Grand Bassam', '2026-04-15 07:30:00', '2026-04-18 17:00:00', 'DGI', 'planifie', 12, '2026-04-03 08:41:00', '2026-04-09 07:31:54'),
(3, '06008bb2-e0d9-4f1a-9672-506165e53d92', 'Renforcement de capacité sur la fiscalité numérique', 'Gestion de la fiscalité à travers le numérique', 'Abidjan hotel Ivoire', '2026-05-15 09:00:00', '2026-05-17 16:30:00', 'Direction Générale des Impôts', 'planifie', 15, '2026-04-08 13:37:15', '2026-04-09 07:31:54');

-- --------------------------------------------------------

--
-- Structure de la table `seminaire_documents`
--

DROP TABLE IF EXISTS `seminaire_documents`;
CREATE TABLE IF NOT EXISTS `seminaire_documents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seminaire_id` bigint(20) UNSIGNED NOT NULL,
  `nom_document` varchar(255) NOT NULL,
  `fichier_path` varchar(255) NOT NULL,
  `type` enum('presence','rapport','support') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seminaire_documents_seminaire_id_foreign` (`seminaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seminaire_documents`
--

INSERT INTO `seminaire_documents` (`id`, `seminaire_id`, `nom_document`, `fichier_path`, `type`, `created_at`, `updated_at`) VALUES
(3, 1, 'Note_Service_Objectifs de recettes révisés 2025 N\'GUESSAN.doc.pdf', '1775484980_Note_Service_Objectifs_de_recettes_révisés_2025_N\'GUESSAN.doc.pdf', 'rapport', '2026-04-03 08:57:56', '2026-04-06 14:16:20'),
(4, 1, 'Courrier_444444.pdf', '1775483154_Courrier_444444.pdf', 'rapport', '2026-04-06 13:45:54', '2026-04-06 13:45:54'),
(5, 1, 'Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', '1775483818_Projet de Note du DSESF au DG_Séminaire Loi de règlement 18 20 déc 2024.pdf', 'rapport', '2026-04-06 13:56:58', '2026-04-06 13:56:58');

-- --------------------------------------------------------

--
-- Structure de la table `seminaire_emargements`
--

DROP TABLE IF EXISTS `seminaire_emargements`;
CREATE TABLE IF NOT EXISTS `seminaire_emargements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seminaire_id` bigint(20) UNSIGNED NOT NULL,
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `date_pointage` date NOT NULL,
  `heure_pointage` datetime DEFAULT NULL,
  `est_present` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seminaire_emargements_seminaire_id_foreign` (`seminaire_id`),
  KEY `seminaire_emargements_participant_id_foreign` (`participant_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seminaire_emargements`
--

INSERT INTO `seminaire_emargements` (`id`, `seminaire_id`, `participant_id`, `date_pointage`, `heure_pointage`, `est_present`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-03-25', '2026-03-25 07:30:00', 1, '2026-04-04 10:42:37', '2026-04-04 10:42:37'),
(2, 1, 2, '2026-03-25', '2026-03-25 11:42:00', 1, '2026-04-04 10:42:28', '2026-04-04 10:42:28'),
(3, 1, 3, '2026-03-25', '2026-03-25 10:00:00', 1, '2026-04-08 15:16:02', '2026-04-08 15:16:02');

-- --------------------------------------------------------

--
-- Structure de la table `seminaire_participants`
--

DROP TABLE IF EXISTS `seminaire_participants`;
CREATE TABLE IF NOT EXISTS `seminaire_participants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seminaire_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom_externe` varchar(255) DEFAULT NULL,
  `organisme_externe` varchar(255) DEFAULT NULL,
  `est_present` tinyint(1) NOT NULL DEFAULT 0,
  `heure_pointage` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seminaire_participants_seminaire_id_foreign` (`seminaire_id`),
  KEY `seminaire_participants_agent_id_foreign` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seminaire_participants`
--

INSERT INTO `seminaire_participants` (`id`, `seminaire_id`, `agent_id`, `nom_externe`, `organisme_externe`, `est_present`, `heure_pointage`, `created_at`, `updated_at`, `email`, `telephone`) VALUES
(1, 1, 5, NULL, NULL, 1, '2026-04-08 14:52:22', '2026-04-03 07:39:14', '2026-04-08 14:52:22', NULL, NULL),
(2, 1, 9, NULL, NULL, 1, '2026-04-03 08:47:48', '2026-04-03 07:39:14', '2026-04-03 08:47:48', NULL, NULL),
(3, 1, 18, NULL, NULL, 1, '2026-04-08 15:04:10', '2026-04-03 07:39:14', '2026-04-08 15:04:10', NULL, NULL),
(4, 1, 1, NULL, NULL, 1, '2026-04-08 14:46:09', '2026-04-03 07:39:14', '2026-04-08 14:46:09', 'coulsie@gmail.com', '0707584396'),
(5, 1, NULL, 'Yao Kouadio', 'DERAR', 1, '2026-04-03 08:48:21', '2026-04-03 07:41:38', '2026-04-03 08:48:21', NULL, NULL),
(6, 1, NULL, 'Bamba Salif', 'DSI', 1, '2026-04-04 09:30:17', '2026-04-03 07:42:05', '2026-04-04 09:30:17', NULL, NULL),
(7, 1, 23, NULL, NULL, 1, '2026-04-03 08:48:25', '2026-04-03 08:05:22', '2026-04-03 08:48:25', NULL, NULL),
(8, 2, 25, NULL, NULL, 0, NULL, '2026-04-03 08:49:48', '2026-04-08 08:44:42', NULL, NULL),
(9, 2, 9, NULL, NULL, 1, '2026-04-07 13:59:53', '2026-04-03 08:49:48', '2026-04-07 13:59:53', NULL, NULL),
(10, 2, 18, NULL, NULL, 1, '2026-04-08 08:41:57', '2026-04-03 08:49:48', '2026-04-08 08:41:57', NULL, NULL),
(11, 2, 20, NULL, NULL, 0, NULL, '2026-04-03 08:49:48', '2026-04-03 08:49:48', NULL, NULL),
(12, 2, 2, NULL, NULL, 1, '2026-04-07 10:00:00', '2026-04-03 08:49:48', '2026-04-08 09:04:04', 'coulsie@gmail.com', '0707584396'),
(13, 2, NULL, 'Youboué Kouamé', 'DG des Douanes', 0, NULL, '2026-04-03 08:50:20', '2026-04-03 08:50:20', NULL, NULL),
(14, 2, NULL, 'Sylla Moussa', 'Port Autonome d\'Abidjan', 0, NULL, '2026-04-03 08:50:44', '2026-04-03 08:50:44', NULL, NULL),
(15, 1, NULL, 'Youboué Kouamé', 'DSI', 1, '2026-04-08 09:08:04', '2026-04-08 09:06:21', '2026-04-08 09:08:04', 'nafie410@dgi.gouv.ci', '0505202364'),
(16, 1, 16, NULL, NULL, 0, NULL, '2026-04-08 09:32:15', '2026-04-08 09:32:15', NULL, NULL),
(17, 3, 5, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(18, 3, 23, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(19, 3, 25, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(20, 3, 18, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(21, 3, 1, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(22, 3, 16, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(23, 3, 6, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(24, 3, 4, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(25, 3, 17, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(26, 3, 11, NULL, NULL, 0, NULL, '2026-04-08 13:38:03', '2026-04-08 13:38:03', NULL, NULL),
(27, 3, NULL, 'Youboué Kouamé', 'DSI', 0, NULL, '2026-04-08 13:38:21', '2026-04-08 13:38:21', NULL, NULL),
(28, 3, NULL, 'Bamba Salif', 'DSI', 0, NULL, '2026-04-08 13:38:32', '2026-04-08 13:38:32', NULL, NULL),
(29, 3, 7, NULL, NULL, 0, NULL, '2026-04-08 13:56:10', '2026-04-08 13:56:10', NULL, NULL),
(30, 3, NULL, 'Sylla Moussa', 'DERAR', 0, NULL, '2026-04-08 13:56:25', '2026-04-08 13:56:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `direction_id` bigint(20) UNSIGNED NOT NULL,
  `head_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_code_unique` (`code`),
  KEY `services_direction_id_foreign` (`direction_id`),
  KEY `services_head_id_foreign` (`head_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `name`, `code`, `description`, `direction_id`, `head_id`, `created_at`, `updated_at`) VALUES
(1, 'Appui Informatique', 'Sce AI', NULL, 1, 4, '2026-01-20 12:53:23', '2026-03-25 14:21:41'),
(2, 'Service de Production et de Diffusion des Statistiques', 'Sce PDS', NULL, 1, 7, '2026-01-20 12:54:19', '2026-03-25 14:21:41'),
(3, 'Servcide de la Documentation et des Activités', 'Sce SDA', NULL, 1, 3, '2026-01-20 12:54:59', '2026-03-25 14:21:41'),
(4, 'Service des Statitiques d\'Assiette et du Controle Fiscal', 'Sce SACF', NULL, 2, NULL, '2026-01-20 12:56:37', '2026-01-20 12:56:37'),
(5, 'Service des Prévisions de Recettes et des Indicateurs Economiques', 'Sce PRIE', NULL, 2, NULL, '2026-01-20 12:57:34', '2026-01-20 12:57:34'),
(6, 'Service d\'Analyse des Statitiques de Recettes Fiscales', 'Sce ASRF', NULL, 2, NULL, '2026-01-20 12:58:19', '2026-01-20 12:58:19'),
(7, 'Servcie des Etudes Fiscales', 'Sce EF', NULL, 3, NULL, '2026-01-20 12:58:54', '2026-01-20 12:58:54'),
(8, 'Service des Etudes Sectorielles et des Monographies', 'Sce ESM', NULL, 3, 24, '2026-01-20 12:59:49', '2026-03-25 14:21:41'),
(9, 'Service des Simulations et des Evaluations', 'Sce SE', NULL, 3, NULL, '2026-01-20 13:00:30', '2026-01-20 13:00:30'),
(10, 'Service de la Planification et de Suivi de la Performance', 'Sce PSP', NULL, 4, 16, '2026-01-20 13:01:23', '2026-03-25 14:21:41'),
(11, 'Service de la Veille Stratégique', 'Sce VS', NULL, 4, 19, '2026-01-20 13:02:53', '2026-03-25 14:21:41'),
(12, 'Service de Gestion et d\'Archivage des Etats Financiers', 'Sce SGAEF', NULL, 5, NULL, '2026-01-20 13:03:41', '2026-01-20 13:03:41'),
(13, 'Service d\'Analyse et d\'Exploitation des Données', 'Sce AED', NULL, 5, NULL, '2026-01-20 13:04:39', '2026-01-20 13:04:39'),
(14, 'Service d\'Appui au Dépôt en Ligne des Etats Financiers', 'Sce ADLEF', NULL, 5, NULL, '2026-01-20 13:05:42', '2026-01-20 13:05:42'),
(15, 'Service Statistiques des Directions Centrales et Régionnales', 'Sce SDCR', NULL, 1, NULL, '2026-01-20 13:07:12', '2026-01-20 13:07:12'),
(16, 'Cabinet S/D Prévision et Statistiques', 'CAB Pré&S', NULL, 2, NULL, '2026-01-20 13:09:00', '2026-01-20 13:11:45'),
(17, 'Cabinet S/D Etude et Evaluations Fiscales', 'CAB EEF', NULL, 3, NULL, '2026-01-20 13:10:08', '2026-01-20 13:10:08'),
(18, 'Cabinet S/D Planification et Stratégie', 'CAM P&S', NULL, 4, NULL, '2026-01-20 13:10:48', '2026-01-20 13:10:48'),
(19, 'Cabinet S/D GUDEF', 'CAB GUDEF', NULL, 5, NULL, '2026-01-20 13:11:14', '2026-01-20 13:11:14'),
(20, 'Cabinet Directeur', 'CAB DSESF', NULL, 1, NULL, '2026-01-21 11:31:40', '2026-01-21 11:31:40');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_absences`
--

DROP TABLE IF EXISTS `type_absences`;
CREATE TABLE IF NOT EXISTS `type_absences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_type` enum('Congé','Repos Maladie','Mission','Permission','Autres','Séminaire') NOT NULL DEFAULT 'Congé',
  `code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `est_paye` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_absences`
--

INSERT INTO `type_absences` (`id`, `nom_type`, `code`, `description`, `est_paye`, `created_at`, `updated_at`) VALUES
(1, 'Congé', 'CA', 'Congé de 30 jours auquel a droit tout agent', 1, '2026-01-21 13:40:54', '2026-01-21 13:40:54'),
(2, 'Repos Maladie', 'RM', 'Repôt maladie prescrit par un medecin dûment mandaté par la MADGI', 1, '2026-01-21 13:43:07', '2026-01-21 13:43:07'),
(3, 'Mission', 'M', 'Mission de travail ou de formation', 1, '2026-01-21 13:43:36', '2026-01-21 13:43:36'),
(4, 'Permission', 'P', 'Autorisation d\'absence validée par un spérieur hiérarchique', 1, '2026-01-21 13:44:42', '2026-01-21 13:44:42'),
(5, 'Autres', 'Autre', 'Autre type d\'absence', 1, '2026-01-21 13:45:35', '2026-01-21 13:45:35'),
(7, 'Séminaire', 'SM', 'Séminaire', 1, '2026-03-07 14:59:37', '2026-03-07 14:59:37');

-- --------------------------------------------------------

--
-- Structure de la table `type_courriers`
--

DROP TABLE IF EXISTS `type_courriers`;
CREATE TABLE IF NOT EXISTS `type_courriers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_picture` varchar(191) DEFAULT NULL,
  `signature_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `must_change_password`, `password_changed_at`, `remember_token`, `created_at`, `updated_at`, `bio`, `profile_picture`, `signature_path`) VALUES
(1, 'Admin Test', 'admin@example.com', NULL, '$2y$12$wAf0LxbRALNrwYQY33KXUeAoOYNIKiI243FdTKLXuaD2/XAiL9LrW', 0, NULL, NULL, '2026-01-20 09:37:00', '2026-01-20 10:44:26', NULL, NULL, NULL),
(2, 'Utilisateur Test', 'test@example.com', NULL, '$2y$12$7sPkZYqEOdlX17Wh1A6Iw.Y4Nz6LdMMkPR96o3dqBEfzZePhkdWhK', 0, NULL, NULL, '2026-01-20 09:37:00', '2026-01-20 10:44:26', NULL, NULL, NULL),
(3, 'Sié Yacouba COULIBALY', 'yacouba.coulibaly@dgi.gouv.ci', NULL, '$2y$12$cI/WluOwOysBquPIhjjdUuOE0MSQr.BnBmWSfLVZo/T6bZLwcEbnu', 0, '2026-04-15 12:17:07', 'mBc0vjvnh3RR2vnCKJWSVkEFnLdweuCekoRrtakWXLqIpTpTALsPoPidwyUn', '2026-01-20 13:25:02', '2026-04-15 12:17:07', 'Inspecteur Principal Informatique à la Fonction Publique, précisement à la DGI (Direction Générale des Impôts), à la DSESF (Direction de la Stratégie, des Etudes et Statitiques Fiscales). Première Prise de Service le 08 janvier 2002', 'photos_agents/Km5CbkPx8Rry9FPxsIf9Tu3gi9JOqhDVlXxOtuBP.jpg', 'pad_3_1775121779.png'),
(4, 'Nafata KONE', 'nkone05@dgi.gouv.ci', NULL, '$2y$12$HN0h/eL.dGC/ltkmjZaQTev48U9ECeH.PqA3tlclhDgYo1aQhFH.6', 1, NULL, NULL, '2026-01-20 13:46:32', '2026-03-26 09:10:31', NULL, NULL, NULL),
(5, 'Rosine Générosa Epse Dje OUSSOU', 'roussou@dgi.gouv.ci', NULL, '$2y$12$6levTuTb0vIp1M1nBq/oROhQkRMA0T.OpNdr8GOByOjJy.X9YpvMW', 1, NULL, NULL, '2026-01-20 13:48:59', '2026-01-22 12:31:18', NULL, NULL, NULL),
(6, 'Arlette N\'DOUME', 'andoume@dgi.gouv.ci', NULL, '$2y$12$UptzFnNTF5sgio1UqRK6Ne8.yG7QxbhjxLqmpy9hIoJRKQahDNwmS', 0, NULL, NULL, '2026-01-21 10:43:13', '2026-03-12 06:58:44', NULL, NULL, 'sig_6_1773298724.png'),
(9, 'Innocent ADICO', 'iadico@dgi.gouv.ci', NULL, '$2y$12$6/aHb0Ct2CVGyAI/BtExLu252qRt2r8xrxvZgRoFMQeFPbkmG7uc.', 0, NULL, NULL, '2026-01-21 11:50:04', '2026-03-19 07:07:28', NULL, NULL, 'pad_9_1773408453.png'),
(10, 'Moctar Michel Djépa KEITA', 'michelkeita@dgi.gouv.ci', NULL, '$2y$12$GVJZkuOfiwTdDE.A6946U.6coCnMxYZPHLh.MyfdwfSb3I7eYIBsq', 1, NULL, NULL, '2026-01-21 11:56:29', '2026-01-28 14:20:16', NULL, NULL, NULL),
(11, 'Assi Roger OKPEKON', 'asokpekon@dgi.gouv.ci', NULL, '$2y$12$p4VhIUU7bg6ju1tusqWJneMBfeAbl/nTIKgM.hr832AVQhg7wwVw6', 0, NULL, NULL, '2026-01-21 11:59:18', '2026-01-29 11:08:51', NULL, NULL, NULL),
(12, 'Née Brou Amenan M. KOUADIO', 'kbrou04@dgi.gouv.ci', NULL, '$2y$12$NRt7n8PnxT41./IvAD.GFetDLPqFXcBveV4WdaA10D4DnMtLI/DDm', 1, NULL, NULL, '2026-01-21 12:02:21', '2026-01-21 12:02:21', NULL, NULL, NULL),
(13, 'Maïmouna BALLO', 'mballo@dgi.gouv.ci', NULL, '$2y$12$5pVS9RokI.yFE9sskgIEAe/F8Q3gKgMSitn.geE4Dw00M3epkVr6q', 1, NULL, NULL, '2026-01-21 12:37:32', '2026-01-21 12:37:32', NULL, NULL, NULL),
(14, 'Akpa Leonard DJEDJEMEL', 'adjedjemel@dgi.gouv.ci', NULL, '$2y$12$FqeyBSfjG8plbvr45sVr/ubyh35lheTKUoTnOyd6L8OYLr4oBix42', 1, NULL, NULL, '2026-01-21 12:47:16', '2026-01-21 12:47:16', NULL, NULL, NULL),
(15, 'Mamadou TRAORE', 'mtraore@dgi.gouv.ci', NULL, '$2y$12$pVJ6NdgPnmRntLHilLZLWO0xUKd.pLRjWt7Wyot1SBnpId5lk.9aK', 1, NULL, NULL, '2026-01-21 12:51:08', '2026-01-21 12:51:08', NULL, NULL, NULL),
(16, 'Tiekoura HORO', 'thoro@dgi.gouv.ci', NULL, '$2y$12$pYdqqmYFCTeZxXKoG.LHeeqPkhLpSvAkM9xltNYRoeIrUOCEDT6Je', 1, NULL, NULL, '2026-01-22 08:10:12', '2026-03-11 10:17:56', NULL, NULL, NULL),
(17, 'Brou Tchoumou Serge N\'GUESSAN', 'bnguessan04@dgi.gouv.ci', NULL, '$2y$12$9D9YWt7NlAZQf0btLeAXhOdcKWoeYhVhLkb8MPYWYjgVrWkBTQYP6', 0, NULL, NULL, '2026-01-22 08:27:00', '2026-01-28 11:42:15', NULL, NULL, NULL),
(18, 'Mathurin BEZI', 'mbezi@dgi.gouv.ci', NULL, '$2y$12$BcDeMiB4WI51vVEVNPX/V.Vzjn6pMP2VoM/C96VfJynLvk91c19zO', 1, NULL, NULL, '2026-01-22 08:41:51', '2026-01-22 08:41:51', NULL, NULL, NULL),
(19, 'Bi Suy Robert TOUBOUI', 'rtouboui@dgi.gouv.ci', NULL, '$2y$12$dVhNjgRnLUf95A8qOX1w9uF7c8DtE6VXGVBaEIaxXAf1ovSoQTVQu', 1, NULL, NULL, '2026-01-23 10:25:21', '2026-01-23 10:25:21', NULL, NULL, NULL),
(20, 'Mamadou Lamine COULIBALY', 'mamadoulcoul@dgi.gouv.ci', NULL, '$2y$12$Lfz7QtoJfaRONcHbgo2Qg.3k3fJ2rlVTyFVr7bVCCBG.roawC3qDG', 1, NULL, NULL, '2026-01-23 10:29:57', '2026-01-23 10:29:57', NULL, NULL, NULL),
(21, 'Née Keita Aramata Anne Elise KEDI', 'akeita@dgi.gouv.ci', NULL, '$2y$12$6vph6Z9CtWbD2RBrrtViFOccxOP4LxXoXpcxp4XkqOWH303Oisp4m', 1, NULL, NULL, '2026-01-27 07:57:48', '2026-01-27 07:57:48', NULL, NULL, NULL),
(22, 'Konan Christian René KOFFI', 'christiankonankoffi@dgi.gouv.ci', NULL, '$2y$12$iklZZEklhAlFRdc1RcWRkelt6/2BOWWYuzezk4kFgTlmEnAEqUNcO', 1, NULL, NULL, '2026-01-27 08:14:10', '2026-01-27 08:14:10', NULL, NULL, NULL),
(23, 'M\'bo Erasthène ALEXANDRE', 'erasthene16ja17@dgi.gouv.ci', NULL, '$2y$12$pyiztyHvVrjRiKOwbPCUhekN8qw1kx4sIHaS0pCk4svXJ341adPAe', 1, NULL, NULL, '2026-01-27 14:44:26', '2026-01-27 14:44:26', NULL, NULL, NULL),
(24, 'Yao Ulrich N\'GUESSAN', 'unguessan@dgi.gouv.ci', NULL, '$2y$12$lJSHTiuKgIu3qAgodGZxtuUEDaJg.XJDY4IEMfTb6S6YWS63hTney', 0, NULL, NULL, '2026-01-29 09:39:36', '2026-01-29 09:41:54', NULL, NULL, NULL),
(25, 'Riviere Michel ANGELS', 'riviere@dgi.gouv.ci', NULL, '$2y$12$CJIeLWEevNfHUbeLzo90VORztEzsMu9HmaFpaPC0fDhMAgMGgJbiC', 0, NULL, NULL, '2026-02-27 19:33:26', '2026-02-27 19:38:25', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
