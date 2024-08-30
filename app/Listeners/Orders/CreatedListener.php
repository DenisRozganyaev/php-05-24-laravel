<?php

namespace App\Listeners\Orders;

use App\Enums\Role;
use App\Events\OrderCreatedEvent;
use App\Models\User;
use App\Notifications\Admins\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class CreatedListener implements ShouldQueue
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function viaQueue(): string
    {
        return 'listeners';
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        logs()->info('CreatedListener::handle');
        Notification::send(
            User::role(Role::ADMIN->value)->get(),
            app(OrderCreatedNotification::class, ['order' => $event->order])
        );
    }
}
