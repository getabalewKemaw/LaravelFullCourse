<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    //  Define the channels (Email + Database + Broadcast)
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    // Email format
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Alert 🚨')
            ->greeting('Hey ' . $notifiable->name . '!')
            ->line($this->message)
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thanks for staying with us!');
    }

    //  Database format
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'user' => $notifiable->name,
        ];
    }

    //  Broadcast format
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message,
            'user' => $notifiable->name,
        ]);
    }
}
