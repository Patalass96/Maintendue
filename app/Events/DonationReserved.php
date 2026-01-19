<?php

namespace App\Events;

use App\Models\Donation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationReserved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function broadcastOn()
    {
        // Diffuser à TOUTES les associations (pour montrer que le don est réservé)
        return new Channel('donations');
        
        // OU diffuser uniquement au donateur (notification privée)
        // return new PrivateChannel('user.' . $this->donation->donor_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->donation->id,
            'title' => $this->donation->title,
            'status' => $this->donation->status,
            'reserved_at' => $this->donation->reserved_at->format('d/m/Y H:i'),
            'association_name' => $this->donation->assignedAssociation->name ?? 'Une association',
            'message' => "Le don '{$this->donation->title}' a été réservé"
        ];
    }
}

