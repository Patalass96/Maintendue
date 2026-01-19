<?php


namespace App\Models\Traits;

use App\Models\Notification;
use App\Models\UserNotificationSetting;

trait Notifiable
{
    /**
     * Envoyer une notification à l'utilisateur
     */
    public function notify($type, $title, $message, $data = [], $actionUrl = null)
    {
        // Vérifier les préférences de notification
        $settings = $this->notificationSettings;
        
        $shouldNotify = match($type) {
            'new_donation' => $settings?->email_new_donations ?? true,
            'message' => $settings?->email_messages ?? true,
            'request' => $settings?->email_requests ?? true,
            default => true
        };

        if (!$shouldNotify) {
            return null;
        }

        $notification = Notification::create([
            'user_id' => $this->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'action_url' => $actionUrl,
            'is_read' => false,
        ]);

        // Envoyer un email si nécessaire
        if (in_array($type, ['new_donation', 'message', 'request'])) {
            $this->sendEmailNotification($type, $title, $message, $data);
        }

        // Envoyer une notification push si activée
        if ($settings && $this->shouldSendPush($type, $settings)) {
            $this->sendPushNotification($title, $message, $data);
        }

        return $notification;
    }

    /**
     * Récupérer les notifications non lues
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread()->orderBy('created_at', 'desc');
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllNotificationsAsRead()
    {
        return $this->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Relations
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function notificationSettings()
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    private function shouldSendPush($type, $settings)
    {
        return match($type) {
            'new_donation' => $settings->push_new_donations ?? false,
            'message' => $settings->push_messages ?? false,
            default => false
        };
    }

    private function sendEmailNotification($type, $title, $message, $data)
    {
        // Logique d'envoi d'email
        // Vous pouvez utiliser Laravel Mail ou un service tiers
    }

    private function sendPushNotification($title, $message, $data)
    {
        // Logique de notification push
        // Vous pouvez utiliser Firebase, OneSignal, etc.
    }
}