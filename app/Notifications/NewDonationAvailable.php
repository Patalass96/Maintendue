<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDonationAvailable extends Notification
{
    use Queueable;

    public $donation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle donation disponible - MainTendue')
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Une nouvelle donation est disponible dans votre région !')
            ->line('Titre: ' . $this->donation->title)
            ->line('Catégorie: ' . $this->donation->category->name)
            ->action('Voir la donation', route('donations.show', $this->donation->id))
            ->line('Merci de votre engagement envers MainTendue.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'donation_id' => $this->donation->id,
            'title' => $this->donation->title,
            'city' => $this->donation->city,
            'category' => $this->donation->category->name,
        ];
    }
}