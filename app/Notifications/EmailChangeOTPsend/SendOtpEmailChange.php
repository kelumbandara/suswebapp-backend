<?php

namespace App\Notifications\EmailChangeOTPsend;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpEmailChange extends Notification
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
            ->markdown('mail.email_change.change-email-notification', [
                'otp' => $this->otp,
            ]);
    }
}
