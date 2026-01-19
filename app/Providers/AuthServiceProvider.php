<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\CollectionPoint;
use App\Models\AssociationNeed;
use App\Models\Faq;
use App\Models\SocialAccount;
use App\Policies\CollectionPointPolicy;
use App\Policies\AssociationNeedPolicy;
use App\Policies\FaqPolicy;
use App\Policies\SocialAccountPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CollectionPoint::class => CollectionPointPolicy::class,
        AssociationNeed::class => AssociationNeedPolicy::class,
        Faq::class => FaqPolicy::class,
        SocialAccount::class => SocialAccountPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
