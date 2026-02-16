<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $agent_id
 * @property int $type_absence_id
 * @property \Illuminate\Support\Carbon $date_debut
 * @property \Illuminate\Support\Carbon $date_fin
 * @property int $approuvee
 * @property string|null $document_justificatif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agent|null $agent
 * @property-read \App\Models\TypeAbsence|null $type
 * @property-read \App\Models\TypeAbsence|null $typeAbsence
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereApprouvee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereDocumentJustificatif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereTypeAbsenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence whereUpdatedAt($value)
 */
	class Absence extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $email_professionnel
 * @property string $matricule
 * @property string $first_name
 * @property string $last_name
 * @property string $status
 * @property string|null $sexe
 * @property string|null $date_of_birth
 * @property string|null $Place_birth
 * @property string|null $photo
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $Emploi
 * @property string|null $Grade
 * @property string|null $Date_Prise_de_service
 * @property string|null $Personne_a_prevenir
 * @property string|null $Contact_personne_a_prevenir
 * @property int $service_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Absence> $absences
 * @property-read int|null $absences_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Direction> $directionsResponsable
 * @property-read int|null $directions_responsable_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Imputation> $imputations
 * @property-read int|null $imputations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Presence> $presences
 * @property-read int|null $presences_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Service|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $servicesResponsable
 * @property-read int|null $services_responsable_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereContactPersonneAPrevenir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereDatePriseDeService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereEmailProfessionnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereEmploi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent wherePersonneAPrevenir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent wherePlaceBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent withoutRole($roles, $guard = null)
 */
	class Agent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $titre
 * @property string $contenu
 * @property string $type
 * @property int $is_active
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Annonce whereUpdatedAt($value)
 */
	class Annonce extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $num_enregistrement
 * @property bool $affecter
 * @property string $reference
 * @property string|null $type
 * @property string $objet
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $date_courrier
 * @property string|null $date_document_original
 * @property string $expediteur_nom
 * @property string|null $expediteur_contact
 * @property string $destinataire_nom
 * @property string|null $destinataire_contact
 * @property string $statut
 * @property string|null $assigne_a
 * @property string|null $chemin_fichier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_confidentiel
 * @property string|null $code_acces
 * @property-read \App\Models\Imputation|null $imputation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereAffecter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereAssigneA($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereCheminFichier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereCodeAcces($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereDateCourrier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereDateDocumentOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereDestinataireContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereDestinataireNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereExpediteurContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereExpediteurNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereIsConfidentiel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereNumEnregistrement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereObjet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courrier whereUpdatedAt($value)
 */
	class Courrier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property int|null $head_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agent|null $head
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Direction whereUpdatedAt($value)
 */
	class Direction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $jour
 * @property \Illuminate\Support\Carbon $heure_debut
 * @property \Illuminate\Support\Carbon $heure_fin
 * @property int $tolerance_retard
 * @property bool $est_ouvre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire joursOuvres()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereEstOuvre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereHeureDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereHeureFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereToleranceRetard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Horaire whereUpdatedAt($value)
 */
	class Horaire extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $courrier_id
 * @property string|null $chemin_fichier
 * @property int $user_id
 * @property int|null $suivi_par
 * @property string|null $niveau
 * @property string|null $instructions
 * @property string|null $observations
 * @property array<array-key, mixed>|null $documents_annexes
 * @property \Illuminate\Support\Carbon $date_imputation
 * @property \Illuminate\Support\Carbon|null $date_traitement
 * @property \Illuminate\Support\Carbon|null $echeancier
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agent> $agents
 * @property-read int|null $agents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agent> $assignedAgents
 * @property-read int|null $assigned_agents_count
 * @property-read \App\Models\User|null $auteur
 * @property-read \App\Models\Courrier|null $courrier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reponse> $reponses
 * @property-read int|null $reponses_count
 * @property-read \App\Models\User|null $superviseur
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereCheminFichier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereCourrierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereDateImputation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereDateTraitement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereDocumentsAnnexes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereEcheancier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereNiveau($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereSuiviPar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imputation whereUserId($value)
 */
	class Imputation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutRole($roles, $guard = null)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $agent_id
 * @property \Illuminate\Support\Carbon $heure_arrivee
 * @property \Illuminate\Support\Carbon|null $heure_depart
 * @property string $statut
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Absence|null $absence
 * @property-read \App\Models\Agent|null $agent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence absences()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence presentes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereHeureArrivee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereHeureDepart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presence whereUpdatedAt($value)
 */
	class Presence extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $validation
 * @property string|null $document_final_signe
 * @property string|null $date_approbation
 * @property int $imputation_id
 * @property int $agent_id
 * @property string $contenu
 * @property array<array-key, mixed>|null $fichiers_joints
 * @property \Illuminate\Support\Carbon $date_reponse
 * @property int $pourcentage_avancement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agent|null $agent
 * @property-read \App\Models\Imputation|null $imputation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereDateApprobation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereDateReponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereDocumentFinalSigne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereFichiersJoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereImputationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse wherePourcentageAvancement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reponse whereValidation($value)
 */
	class Reponse extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutPermission($permissions)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property array<array-key, mixed>|null $parametres
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction whereParametres($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScriptExtraction whereUpdatedAt($value)
 */
	class ScriptExtraction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property int $direction_id
 * @property int|null $head_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agent> $agents
 * @property-read int|null $agents_count
 * @property-read \App\Models\Direction|null $direction
 * @property-read \App\Models\Agent|null $head
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDirectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom_type
 * @property string|null $code
 * @property string|null $description
 * @property bool $est_paye
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Absence> $absences
 * @property-read int|null $absences_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Presence> $presences
 * @property-read int|null $presences_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereEstPaye($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereNomType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeAbsence whereUpdatedAt($value)
 */
	class TypeAbsence extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $must_change_password
 * @property string|null $password_changed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $bio
 * @property string|null $profile_picture
 * @property \App\Enums\UserRole $role
 * @property-read \App\Models\Agent|null $agent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMustChangePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordChangedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

