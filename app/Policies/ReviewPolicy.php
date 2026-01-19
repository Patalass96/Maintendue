<?php


namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use App\Models\Donation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Déterminer si l'utilisateur peut créer un avis pour ce don
     */
    public function createReview(User $user, Donation $donation)
    {
        // Seules les personnes impliquées dans le don peuvent laisser un avis
        $isInvolved = false;
        
        if ($user->isAssociation()) {
            // L'association doit avoir reçu le don
            $isInvolved = $donation->assigned_association_id === $user->id 
                && $donation->status === 'delivered';
        } else {
            // Le donateur doit avoir donné le don
            $isInvolved = $donation->donor_id === $user->id 
                && $donation->status === 'delivered';
        }

        // Vérifier qu'il n'y a pas déjà un avis pour cette transaction
        $existingReview = Review::where('donation_id', $donation->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        return $isInvolved && !$existingReview;
    }

    /**
     * Déterminer si l'utilisateur peut répondre à un avis
     */
    public function reply(User $user, Review $review)
    {
        // Seule la personne évaluée peut répondre
        return $review->reviewed_id === $user->id;
    }

    /**
     * Déterminer si l'utilisateur peut signaler un avis
     */
    public function report(User $user, Review $review)
    {
        // Tout utilisateur connecté peut signaler, sauf l'auteur de l'avis
        return $user->id !== $review->reviewer_id;
    }
}