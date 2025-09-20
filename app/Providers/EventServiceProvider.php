<?php

namespace App\Providers;

use App\Events\Admin\UserRegistered;
use App\Events\Admin\UserJoinedAffiliate;
use App\Events\Admin\UserRenewedAffiliate;
use App\Events\CoinTransactionProcessed;
use App\Listeners\Admin\NotifyAdminsOfNewUser;
use App\Listeners\Admin\NotifyAdminsOfNewAffiliate;
use App\Listeners\Admin\NotifyAdminsOfAffiliateRenewal;
use App\Listeners\SendCoinTransactionNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            NotifyAdminsOfNewUser::class,
        ],
        
        UserJoinedAffiliate::class => [
            NotifyAdminsOfNewAffiliate::class,
        ],
        
        UserRenewedAffiliate::class => [
            NotifyAdminsOfAffiliateRenewal::class,
        ],
        
        CoinTransactionProcessed::class => [
            SendCoinTransactionNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
        
        // Register event with closure to ensure it works
        Event::listen(UserRegistered::class, function ($event) {
            $listener = new NotifyAdminsOfNewUser();
            $listener->handle($event);
        });
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}