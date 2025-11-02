<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UserRegistered;
use Illuminate\Support\Facades\Log;


class AdminNotificationSubscriber
{
    /**
     * Create the event listener.
     */

        public function handleUserRegistered($event)
    {
        Log::info("👑 Admin notified about new user: {$event->user['email']}");
    }

    public function subscribe($events)
    {
        $events->listen(
            UserRegistered::class,
            [self::class, 'handleUserRegistered']
        );
    }
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
