<?php

namespace App\Notifications\FrogotpasswordOTPsend;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordChangeConfirmation extends Notification
{
    use Queueable;

    protected $otp;
    protected $email;

    public function __construct($otp, $email)
    {
        $this->otp = $otp;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable) :MailMessage
    {
        return (new MailMessage)
            ->subject('Your OTP for Password Change')
            ->markdown('mail.forgot_password.forgot-password-notification', [
                'otp' => $this->otp,
            ]);
    }
}
