<?php

namespace App\Listeners;

use App\Events\SocialiteCreatedAccountEvent;
use App\Notifications\CreatedAccountNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CreatedAccListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SocialiteCreatedAccountEvent $event): void
    {
        Notification::send(
            $event->user,
            app(CreatedAccountNotification::class, ['password' => $event->password]),
        );
    }
}
