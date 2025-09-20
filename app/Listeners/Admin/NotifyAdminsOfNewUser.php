<?php

namespace App\Listeners\Admin;

use App\Events\Admin\UserRegistered;
use App\Models\Admin;
use App\Notifications\Admin\UserRegisteredNotification;
use Illuminate\Support\Facades\Notification;

class NotifyAdminsOfNewUser
{
    public function handle($event): void
    {
        \Log::info('NotifyAdminsOfNewUser listener triggered');
        
        $user = $event instanceof UserRegistered ? $event->user : $event->user;
        
        if (!$user instanceof \App\Models\User) {
            \Log::info('User is not instance of User model');
            return;
        }
        
        \Log::info('Processing notification for user: ' . $user->email);
        
        $admins = Admin::where('is_active', true)
            ->whereHas('roles.permissions', function($query) {
                $query->where('name', 'receive-user-registered-notifications');
            })
            ->orWhere(function($query) {
                $query->where('is_active', true)->whereDoesntHave('roles');
            })
            ->get();
        
        \Log::info('Found ' . $admins->count() . ' admins to notify');
        
        if ($admins->count() > 0) {
            Notification::send($admins, new UserRegisteredNotification($user));
            \Log::info('Notification sent to admins');
        }
    }
}