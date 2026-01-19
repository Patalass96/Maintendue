<?php

namespace App\Listeners;

use App\Events\DonationRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewRequestNotification
{
    public function __construct()
    {
        //
    }

    public function handle(DonationRequestCreated $event): void
    {
        $donationRequest = $event->donationRequest;
        $donor = $donationRequest->donation->donor;
        
        // Notifier le donateur
        // Vous pouvez utiliser des notifications Laravel, des emails, etc.
        
        // Exemple : notification dans l'application
        $donor->notifications()->create([
            'type' => 'donation_request',
            'title' => 'Nouvelle demande pour votre don',
            'message' => "L'association {$donationRequest->association->name} souhaite recevoir votre don '{$donationRequest->donation->title}'",
            'data' => [
                'donation_request_id' => $donationRequest->id,
                'donation_id' => $donationRequest->donation_id,
            ],
        ]);
    }
}