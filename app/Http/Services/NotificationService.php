<?php

namespace App\Services;

use App\Models\User;
use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\Conversation;
use App\Models\Notification;

class NotificationService
{
    /**
     * Notifier un nouveau don
     */
    public function notifyNewDonation(Donation $donation)
    {
        // Notifier les associations dans la même ville
        $associations = User::where('is_association', true)
            ->where('city', $donation->city)
            ->get();

        foreach ($associations as $association) {
            $association->notify(
                'new_donation',
                'Nouveau don disponible !',
                "Un nouveau don '{$donation->title}' est disponible dans votre ville.",
                [
                    'donation_id' => $donation->id,
                    'donation_title' => $donation->title,
                    'category' => $donation->category->name,
                    'city' => $donation->city
                ],
                route('donations.show', $donation)
            );
        }
    }

    /**
     * Notifier une nouvelle demande
     */
    public function notifyNewRequest(DonationRequest $request)
    {
        $donor = $request->donation->donor;
        
        $donor->notify(
            'request',
            'Nouvelle demande pour votre don',
            "L'association {$request->association->name} souhaite recevoir votre don '{$request->donation->title}'.",
            [
                'request_id' => $request->id,
                'donation_id' => $request->donation_id,
                'association_id' => $request->association_id,
                'message' => $request->message
            ],
            route('donor.requests.show', $request)
        );
    }

    /**
     * Notifier l'acceptation d'une demande
     */
    public function notifyRequestAccepted(DonationRequest $request)
    {
        $association = $request->association;
        
        $association->notify(
            'request_accepted',
            'Votre demande a été acceptée !',
            "Votre demande pour le don '{$request->donation->title}' a été acceptée.",
            [
                'request_id' => $request->id,
                'donation_id' => $request->donation_id,
                'donor_id' => $request->donation->donor_id
            ],
            route('association.reservations.show', $request->donation)
        );
    }

    /**
     * Notifier un nouveau message
     */
    public function notifyNewMessage(Conversation $conversation, $sender, $messageContent)
    {
        $recipient = ($conversation->initiator_id === $sender->id) 
            ? $conversation->recipient 
            : $conversation->initiator;

        $recipient->notify(
            'message',
            'Nouveau message',
            "Vous avez reçu un nouveau message de {$sender->name}",
            [
                'conversation_id' => $conversation->id,
                'sender_id' => $sender->id,
                'donation_id' => $conversation->donation_id,
                'message_preview' => substr($messageContent, 0, 100)
            ],
            route('conversations.show', $conversation)
        );
    }

    /**
     * Notifier un avis reçu
     */
    public function notifyNewReview($review)
    {
        $reviewedUser = $review->reviewed;
        
        $reviewedUser->notify(
            'review',
            'Nouvel avis reçu',
            "Vous avez reçu un nouvel avis de {$review->reviewer->name}",
            [
                'review_id' => $review->id,
                'rating' => $review->rating,
                'reviewer_id' => $review->reviewer_id
            ],
            route('profile.reviews')
        );
    }

    /**
     * Notifier un don livré
     */
    public function notifyDonationDelivered(Donation $donation)
    {
        $donor = $donation->donor;
        $association = $donation->assignedAssociation;
        
        // Notifier le donateur
        $donor->notify(
            'donation_delivered',
            'Don livré avec succès',
            "Votre don '{$donation->title}' a été livré à {$association->name}.",
            [
                'donation_id' => $donation->id,
                'association_id' => $association->id,
                'delivered_at' => $donation->delivered_at
            ],
            route('donor.donations.show', $donation)
        );

        // Notifier l'association
        $association->notify(
            'donation_received',
            'Don reçu avec succès',
            "Vous avez reçu le don '{$donation->title}' de {$donor->name}.",
            [
                'donation_id' => $donation->id,
                'donor_id' => $donor->id,
                'delivered_at' => $donation->delivered_at
            ],
            route('association.reservations.show', $donation)
        );
    }
}