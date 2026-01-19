<?php
// app/Listeners/SendDeliveryNotifications.php

namespace App\Listeners;

use App\Events\DonationDelivered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDeliveryNotifications
{
    public function __construct()
    {
        //
    }

    public function handle(DonationDelivered $event): void
    {
        $donation = $event->donation;
        
        // Notifier le donateur
        $donation->donor->notifications()->create([
            'type' => 'donation_delivered',
            'title' => 'Don livré avec succès',
            'message' => "Votre don '{$donation->title}' a été livré à {$donation->assignedAssociation->name}",
            'data' => [
                'donation_id' => $donation->id,
                'delivered_at' => $donation->delivered_at,
            ],
        ]);
        
        // Notifier l'association
        if ($donation->assignedAssociation) {
            $donation->assignedAssociation->notifications()->create([
                'type' => 'donation_received',
                'title' => 'Don reçu avec succès',
                'message' => "Vous avez reçu le don '{$donation->title}' de {$donation->donor->name}",
                'data' => [
                    'donation_id' => $donation->id,
                    'delivered_at' => $donation->delivered_at,
                ],
            ]);
        }
    }
}