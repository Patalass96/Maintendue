<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\DonationPublished;
use App\Listeners\SendNewDonationNotifications;
use App\Events\DonationRequestCreated;
use App\Listeners\SendNewRequestNotification;
use App\Events\DonationDelivered;
use App\Listeners\SendDeliveryNotifications;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        DonationPublished::class => [
            SendNewDonationNotifications::class,
        ],
        DonationRequestCreated::class => [
            SendNewRequestNotification::class,
        ],
        DonationDelivered::class => [
            SendDeliveryNotifications::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}