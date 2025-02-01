<?php

namespace App\Notifications\WelcomeNotification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable) :MailMessage
    {
        return (new MailMessage)
        ->subject('Welcome to ABA Group!')
        ->markdown('mail.welcome.welcome-notification', [
            'name' => $this->name,
        ]);
    }
}
