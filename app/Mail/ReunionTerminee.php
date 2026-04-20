<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReunionTerminee extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $meeting; // On utilise l'instance du modèle Meeting

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Documents de réunion : ' . $this->meeting->objet,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Reunions.reunion_terminee',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        // Ajout du Rapport s'il existe
        if ($this->meeting->report_file) {
            $attachments[] = Attachment::fromPath(public_path($this->meeting->report_file))
                ->as('Compte_Rendu_' . $this->meeting->id . '.pdf');
        }

        // Ajout de la Liste de présence s'elle existe
        if ($this->meeting->presence_file) {
            $attachments[] = Attachment::fromPath(public_path($this->meeting->presence_file))
                ->as('Liste_Presence_' . $this->meeting->id . '.pdf');
        }

        return $attachments;
    }
}
