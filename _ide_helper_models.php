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
 * @property int $admin_id
 * @property string $action_type Ex: user_suspended, donation_removed, association_verified.
 * @property string $target_type Ex: User, Donation, Association, Report.
 * @property int|null $target_id ID de l'entité ciblée (Nullable si l'action n'a pas de cible spécifique, ex: "login admin").
 * @property string $description
 * @property array<array-key, mixed>|null $metadata Données supplémentaires sur l'action (ex: ancienne valeur, nouvelle valeur).
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $administrator
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $target
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereTargetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereTargetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminAction whereUpdatedAt($value)
 */
	class AdminAction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key Nom unique du paramètre (ex: maintenance_mode, donation_limit).
 * @property string $value Valeur du paramètre (peut être une chaîne, un JSON, ou un nombre).
 * @property string|null $description Description pour l'administrateur.
 * @property bool $is_public Indique si le paramètre peut être lu par les utilisateurs non connectés (ex: conditions générales).
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting public()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppSetting whereValue($value)
 */
	class AppSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $legal_name
 * @property string $description
 * @property string|null $siret
 * @property string $legal_address
 * @property string $contact_person
 * @property string $phone
 * @property string|null $website
 * @property string|null $logo
 * @property string $verification_status
 * @property string|null $verification_document Chemin vers le justificatif légal
 * @property string|null $needs_description Description textuelle des besoins actuels.
 * @property string|null $opening_hours Horaires pour la collecte ou la livraison.
 * @property int|null $delivery_radius Rayon d’acceptation des dons en km.
 * @property bool $accepts_direct_delivery
 * @property bool $accepts_collection_points
 * @property bool $is_featured
 * @property int $stats_total_donations
 * @property float|null $stats_satisfaction_rate Note moyenne sur 5
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $acceptedDonations
 * @property-read int|null $accepted_donations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CollectionPoint> $collectionPoints
 * @property-read int|null $collection_points_count
 * @property-read \App\Models\User $manager
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DonationRequest> $requests
 * @property-read int|null $requests_count
 * @method static \Database\Factories\AssociationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereAcceptsCollectionPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereAcceptsDirectDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereDeliveryRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereLegalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereLegalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereNeedsDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereOpeningHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereSiret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereStatsSatisfactionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereStatsTotalDonations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereVerificationDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Association whereWebsite($value)
 */
	class Association extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $icon
 * @property string|null $description
 * @property bool $is_active
 * @property int $order_index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $association_id
 * @property string $name
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 * @property string $opening_hours
 * @property string|null $instructions
 * @property string|null $contact_phone
 * @property bool $is_active
 * @property int|null $max_capacity
 * @property int $current_usage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Association $association
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @method static \Database\Factories\CollectionPointFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereAssociationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereCurrentUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereMaxCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereOpeningHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CollectionPoint whereUpdatedAt($value)
 */
	class CollectionPoint extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $donation_id
 * @property int $initiator_id
 * @property int $recipient_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $last_message_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Donation $donation
 * @property-read \App\Models\User $initiator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $recipient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereInitiatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereLastMessageAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUpdatedAt($value)
 */
	class Conversation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $donor_id
 * @property int|null $association_id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property int $quantity
 * @property string $status
 * @property string $condition
 * @property string $urgency_level
 * @property string|null $size
 * @property string|null $gender
 * @property \Illuminate\Support\Carbon|null $expiration_date
 * @property string|null $school_level
 * @property string|null $item_type
 * @property string $delivery_method
 * @property int|null $collection_point_id
 * @property \Illuminate\Support\Carbon|null $meeting_date
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $reserved_at
 * @property \Illuminate\Support\Carbon|null $delivered_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Association|null $assignedAssociation
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\CollectionPoint|null $collectionPoint
 * @property-read \App\Models\Conversation|null $conversation
 * @property-read \App\Models\User $donor
 * @property-read mixed $thumbnail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DonationImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\DonationImage|null $primaryImage
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DonationRequest> $requests
 * @property-read int|null $requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Association|null $targetedAssociation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation available()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation byUrgency($urgency)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation inCity($city)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereAssociationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCollectionPointId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDeliveryMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDonorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereItemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereMeetingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereReservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereSchoolLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereUrgencyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereViewCount($value)
 */
	class Donation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read string $url
 * @property int $id
 * @property int $donation_id
 * @property string $path
 * @property string $filename
 * @property bool $is_primary
 * @property int $order_index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Donation $donation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage primary()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationImage whereUpdatedAt($value)
 */
	class DonationImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $donation_id
 * @property int $association_id
 * @property string $status
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $proposed_date
 * @property string|null $admin_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Association $association
 * @property-read \App\Models\Donation $donation
 * @property-read \App\Models\User|null $handledBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereAssociationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereProposedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DonationRequest whereUpdatedAt($value)
 */
	class DonationRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property string $category Ex: donor, association, general.
 * @property int $order_index Ordre d'affichage au sein d'une catégorie.
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq forCategory(string $category)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq whereUpdatedAt($value)
 */
	class Faq extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $conversation_id
 * @property int $sender_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property bool $is_system_message
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Conversation $conversation
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereIsSystemMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $type Type de notification (ex: request_received, message_received).
 * @property string $title
 * @property string $message
 * @property array<array-key, mixed>|null $data Données structurées supplémentaires (ex: ID du don, ID de la conversation).
 * @property string|null $action_url URL vers laquelle la notification doit diriger l'utilisateur.
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereActionUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $reporter_id
 * @property string $reported_type Type de l'entité signalée (Donation, User, Association).
 * @property int $reported_id ID de l'entité signalée.
 * @property string $reason
 * @property string|null $description
 * @property string $status
 * @property string|null $admin_notes Notes internes de l'administrateur.
 * @property \Illuminate\Support\Carbon|null $resolved_at
 * @property int|null $resolved_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reported
 * @property-read \App\Models\User $reporter
 * @property-read \App\Models\User|null $resolver
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReporterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereResolvedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereResolvedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $reviewer_id
 * @property int $reviewed_id
 * @property int|null $donation_id
 * @property int $rating Note de 1 à 5.
 * @property string|null $comment
 * @property string|null $response Réponse de l'utilisateur noté (ex: Association).
 * @property bool $is_visible Visibilité publique de l'avis.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Donation|null $donation
 * @property-read \App\Models\User $reviewed
 * @property-read \App\Models\User $reviewer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereReviewedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUpdatedAt($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $provider_id
 * @property string|null $access_token
 * @property string|null $refresh_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereUserId($value)
 */
	class SocialAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $role
 * @property bool $is_active
 * @property string|null $avatar
 * @property string|null $phone
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property array<array-key, mixed>|null $settings
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdminAction> $adminActions
 * @property-read int|null $admin_actions_count
 * @property-read \App\Models\Association|null $association
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @property-read string $avatar_url
 * @property-read \App\Models\UserNotificationSetting|null $notificationSettings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reportsMade
 * @property-read int|null $reports_made_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reportsReceived
 * @property-read int|null $reports_received_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviewsGiven
 * @property-read int|null $reviews_given_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviewsReceived
 * @property-read int|null $reviews_received_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialAccount> $socialAccounts
 * @property-read int|null $social_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property bool $email_new_donations Recevoir des emails pour les nouveaux dons dans le secteur.
 * @property bool $email_messages Recevoir des emails pour les nouveaux messages privés.
 * @property bool $email_requests Recevoir des emails pour les nouvelles demandes de dons.
 * @property bool $push_new_donations Recevoir des notifications push pour les nouveaux dons.
 * @property bool $push_messages Recevoir des notifications push pour les nouveaux messages.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereEmailMessages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereEmailNewDonations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereEmailRequests($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting wherePushMessages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting wherePushNewDonations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereUserId($value)
 */
	class UserNotificationSetting extends \Eloquent {}
}

