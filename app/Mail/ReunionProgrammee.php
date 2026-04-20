<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReunionProgrammee extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * L'instance de la réunion.
     */
    public $reunion;

    /**
     * Crée une nouvelle instance de message.
     *
     * @param Meeting $reunion
     */
    public function __construct(Meeting $reunion)
    {
        $this->reunion = $reunion;
    }

    /**
     * Définit l'enveloppe du message (Sujet).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Convocation : ' . $this->reunion->objet,
        );
    }

    /**
     * Définit le contenu du message (Vue et données).
     */
   
    public function content(): Content
    {
        return new Content(
            // Remplace 'emails.reunion_notification' par :
            view: 'Reunions.reunion_notification',
            with: [
                'reunion' => $this->reunion,
            ],
        );
    }


    /**
     * Obtenir les pièces jointes pour le message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
