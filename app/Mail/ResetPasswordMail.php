<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Le lien de réinitialisation
     */
    public string $resetLink;

    /**
     * Le nom de l'utilisateur
     */
    public string $userName;

    /**
     * Crée une nouvelle instance du mail
     */
    public function __construct($resetLink, $userName)
    {
        $this->resetLink = $resetLink;
        $this->userName = $userName;
    }

    /**
     * Récupère l'enveloppe du message
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Réinitialisation de votre mot de passe - MainTendue',
        );
    }

    /**
     * Récupère la définition du contenu du message
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
            with: [
                'resetLink' => $this->resetLink,
                'userName' => $this->userName,
            ],
        );
    }

    /**
     * Récupère les pièces jointes du message
     */
    public function attachments(): array
    {
        return [];
    }
}
