<?php

namespace App\Notifications;

use App\Models\Publication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvellePublication extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Publication $publication)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre publication a été créée')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line('Votre publication « '.$this->publication->titre.' » est disponible sur MediaHub.')
            ->action('Consulter la publication', route('contenus.show', $this->publication));
    }
}