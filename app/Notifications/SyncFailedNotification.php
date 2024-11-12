<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SyncFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $errorMessage;

    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Erro durante a Sincronização dos Produtos')
            ->line('Houve um erro durante a sincronização dos produtos:')
            ->line($this->errorMessage);

        if (env('MAIL_COPY_RECIPIENT')) {
            $mail->cc(env('MAIL_COPY_RECIPIENT'));
        }

        return $mail;
    }
}
