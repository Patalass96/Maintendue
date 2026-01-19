<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Models\UserNotificationSetting;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    /**
     * Créer une notification pour l'utilisateur
     */
    public function notify(User $user, string $type, string $message, ?array $data = null, ?string $link = null): ?Notification
    {
        // Vérifier si l'utilisateur a les notifications activées
        $setting = $user->notificationSettings()->where('type', $type)->first();
        if ($setting && !$setting->is_enabled) {
            return null;
        }

        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'message' => $message,
            'data' => $data ? json_encode($data) : null,
            'link' => $link,
            'read_at' => null,
        ]);
    }

    /**
     * Notifier plusieurs utilisateurs
     */
    public function notifyMany(array $userIds, string $type, string $message, ?array $data = null, ?string $link = null): Collection
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $notification = $this->notify($user, $type, $message, $data, $link);
                if ($notification) {
                    $notifications[] = $notification;
                }
            }
        }
        return collect($notifications);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Notification $notification): void
    {
        $notification->update(['read_at' => now()]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead(User $user): void
    {
        $user->notifications()->update(['read_at' => now()]);
    }

    /**
     * Obtenir les notifications non lues de l'utilisateur
     */
    public function getUnreadNotifications(User $user, int $limit = 10): Collection
    {
        return $user->notifications()
            ->whereNull('read_at')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir le nombre de notifications non lues
     */
    public function getUnreadCount(User $user): int
    {
        return $user->notifications()->whereNull('read_at')->count();
    }

    /**
     * Supprimer une notification
     */
    public function delete(Notification $notification): void
    {
        $notification->delete();
    }

    /**
     * Obtenir les paramètres de notification par défaut pour un utilisateur
     */
    public function initializeNotificationSettings(User $user): void
    {
        $defaultSettings = [
            'donation_published' => true,
            'donation_reserved' => true,
            'donation_delivered' => true,
            'donation_request_created' => true,
            'new_message' => true,
            'review_received' => true,
            'report_resolved' => true,
            'admin_notification' => true,
        ];

        foreach ($defaultSettings as $type => $enabled) {
            UserNotificationSetting::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'type' => $type,
                ],
                [
                    'is_enabled' => $enabled,
                ]
            );
        }
    }

    /**
     * Mettre à jour les paramètres de notification
     */
    public function updateSetting(User $user, string $type, bool $enabled): UserNotificationSetting
    {
        return UserNotificationSetting::updateOrCreate(
            [
                'user_id' => $user->id,
                'type' => $type,
            ],
            [
                'is_enabled' => $enabled,
            ]
        );
    }
}
