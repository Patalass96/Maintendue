<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Donation;
use App\Models\User;
use App\servises\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    /**
     * Afficher toutes les notifications
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer les notifications (dans un vrai projet, vous utiliseriez le système de notifications de Laravel)
        $notifications = [
            'today' => $this->getTodayNotifications(),
            'yesterday' => $this->getYesterdayNotifications(),
            'this_week' => $this->getThisWeekNotifications(),
        ];

        // Récupérer les paramètres de notification
        $notificationSettings = $this->getNotificationSettings($user);

        return view('notifications.index', compact('notifications', 'notificationSettings'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        // Dans un vrai projet, vous marqueriez la notification comme lue dans la base de données
        // $notification = Auth::user()->notifications()->find($id);
        // $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        // Dans un vrai projet, vous marqueriez toutes les notifications comme lues
        // Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id)
    {
        // Dans un vrai projet, vous supprimeriez la notification
        // $notification = Auth::user()->notifications()->find($id);
        // $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification supprimée'
        ]);
    }

    /**
     * Supprimer toutes les notifications
     */
    public function destroyAll()
    {
        // Dans un vrai projet, vous supprimeriez toutes les notifications
        // Auth::user()->notifications()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Toutes les notifications ont été supprimées'
        ]);
    }

    /**
     * Mettre à jour les paramètres de notification
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email_notifications' => ['boolean'],
            'push_notifications' => ['boolean'],
            'donation_notifications' => ['boolean'],
            'association_notifications' => ['boolean'],
            'system_notifications' => ['boolean'],
            'message_notifications' => ['boolean'],
        ]);

        // Sauvegarder les paramètres (dans un vrai projet, vous les sauvegarderiez dans la base de données)
        // $user->notification_settings = json_encode($validated);
        // $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Paramètres de notification mis à jour'
        ]);
    }

    /**
     * Récupérer les notifications d'aujourd'hui (simulées)
     */
    private function getTodayNotifications()
    {
        return [
            [
                'id' => 1,
                'type' => 'donations',
                'title' => 'Don confirmé !',
                'message' => 'Votre don de 5000f à l\'association Les Jeunes Espoirs a été confirmé avec succès.',
                'time' => 'Il y a 2 heures',
                'read' => false,
                'icon' => 'donate',
                'color' => 'success',
            ],
            [
                'id' => 2,
                'type' => 'associations',
                'title' => 'Nouvelle association suivie',
                'message' => 'L\'association Solidarité pour Tous a publié un nouveau besoin.',
                'time' => 'Il y a 4 heures',
                'read' => false,
                'icon' => 'hands-helping',
                'color' => 'primary',
            ],
            [
                'id' => 3,
                'type' => 'system',
                'title' => 'Mise à jour des conditions d\'utilisation',
                'message' => 'Nous avons mis à jour nos conditions d\'utilisation.',
                'time' => 'Il y a 6 heures',
                'read' => true,
                'icon' => 'bell',
                'color' => 'warning',
            ],
        ];
    }

    /**
     * Récupérer les notifications d'hier (simulées)
     */
    private function getYesterdayNotifications()
    {
        return [
            [
                'id' => 4,
                'type' => 'messages',
                'title' => 'Nouveau message',
                'message' => 'Association Cœur de Lion vous a envoyé un message concernant votre don récent.',
                'time' => 'Hier à 14:30',
                'read' => true,
                'icon' => 'comment',
                'color' => 'info',
            ],
            [
                'id' => 5,
                'type' => 'donations',
                'title' => 'Recevez nos remerciements !',
                'message' => 'L\'association Espoir Nouveau vous remercie chaleureusement pour votre soutien continu.',
                'time' => 'Hier à 11:15',
                'read' => true,
                'icon' => 'check-circle',
                'color' => 'success',
            ],
        ];
    }

    /**
     * Récupérer les notifications de la semaine (simulées)
     */
    private function getThisWeekNotifications()
    {
        return [
            [
                'id' => 6,
                'type' => 'system',
                'title' => 'Maintenance prévue',
                'message' => 'Une maintenance est prévue dimanche prochain de 02h00 à 04h00.',
                'time' => 'Lundi à 09:00',
                'read' => true,
                'icon' => 'exclamation-triangle',
                'color' => 'warning',
            ],
        ];
    }

    /**
     * Récupérer les paramètres de notification (simulés)
     */
    private function getNotificationSettings($user)
    {
        // Dans un vrai projet, vous récupéreriez ces données de la base de données
        // $settings = json_decode($user->notification_settings, true);

        return [
            'email_notifications' => true,
            'push_notifications' => true,
            'donation_notifications' => true,
            'association_notifications' => true,
            'system_notifications' => false,
            'message_notifications' => true,
        ];
    }
}
