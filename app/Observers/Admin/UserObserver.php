<?php

namespace App\Observers\Admin;

use App\Models\User;
use App\Events\Admin\UserRegistered;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user): void
    {
        Log::info('UserObserver triggered for user: ' . $user->email);
        
        // Directly notify admins instead of using events
        $listener = new \App\Listeners\Admin\NotifyAdminsOfNewUser();
        $event = new UserRegistered($user);
        $listener->handle($event);
        
        // Send welcome notification to the new user
        $user->notify(new \App\Notifications\User\WelcomeNotification($user));
        
        Log::info('Notifications sent for user: ' . $user->email);
    }
}