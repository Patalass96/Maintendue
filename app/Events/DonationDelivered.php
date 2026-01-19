<?php
// app/Events/DonationDelivered.php

namespace App\Events;

use App\Models\Donation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationDelivered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function broadcastOn(): array
    {
        // Diffuser aux deux parties concernées
        return [
            new Channel('user.' . $this->donation->donor_id),
            new Channel('user.' . $this->donation->assigned_association_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->donation->id,
            'title' => $this->donation->title,
            'status' => $this->donation->status,
            'delivered_at' => $this->donation->delivered_at->toDateTimeString(),
            'donor_name' => $this->donation->donor->name,
            'association_name' => $this->donation->assignedAssociation->name ?? 'Association',
        ];
    }
}