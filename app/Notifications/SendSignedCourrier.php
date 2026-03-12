<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendSignedCourrier extends Notification
{
    use Queueable;

    // 1. DÉCLARATION DES PROPRIÉTÉS (Vital pour éviter "Undefined property")
    protected $courrier;
    protected $pdfPath;

    /**
     * 2. LE CONSTRUCTEUR (Pour recevoir les données du Controller)
     */
    public function __construct($courrier, $pdfPath)
    {
        $this->courrier = $courrier;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Les canaux de notification
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * 3. LE MESSAGE MAIL (Une seule fois dans le fichier)
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau courrier signé : ' . $this->courrier->reference)
            ->greeting('Bonjour ' . ($notifiable->name ?? 'Mme/M.'))
            ->line('Veuillez trouver en pièce jointe le courrier signé ainsi que son bordereau de certification.')
            // Vérification si le fichier existe avant d'attacher
            ->attach($this->pdfPath, [
                'as' => 'Courrier_' . $this->courrier->reference . '.pdf',
                'mime' => 'application/pdf',
            ])
            ->action('Voir le courrier en ligne', url('/courriers/' . $this->courrier->id))
            ->line('Merci d’utiliser notre application !');
    }

    /**
     * Version tableau (optionnel)
     */
    public function toArray($notifiable): array
    {
        return [
            'courrier_id' => $this->courrier->id,
            'reference' => $this->courrier->reference,
        ];
    }
}
