<?php

namespace App\Events;

use App\Models\DonationRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationRequestCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $donationRequest;

    public function __construct(DonationRequest $donationRequest)
    {
        $this->donationRequest = $donationRequest;
    }

    public function broadcastOn(): array
    {
        // Diffuser au donateur
        return [
            new Channel('user.' . $this->donationRequest->donation->donor_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->donationRequest->id,
            'donation_id' => $this->donationRequest->donation_id,
            'donation_title' => $this->donationRequest->donation->title,
            'association_name' => $this->donationRequest->association->name,
            'message' => $this->donationRequest->message,
            'created_at' => $this->donationRequest->created_at->toDateTimeString(),
        ];
    }
}