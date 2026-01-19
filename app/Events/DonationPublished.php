<?php
// app/Events/DonationPublished.php

namespace App\Events;

use App\Models\Donation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationPublished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function broadcastOn()
    {
        // Diffuser aux associations de la même ville
        return new PrivateChannel('city.' . $this->donation->city);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->donation->id,
            'title' => $this->donation->title,
            'category' => $this->donation->category->name,
            'city' => $this->donation->city,
            'urgency' => $this->donation->urgency,
            'created_at' => $this->donation->created_at->toDateTimeString(),
            'donor_name' => $this->donation->donor->name,
            'thumbnail' => $this->donation->thumbnail,
        ];
    }
}