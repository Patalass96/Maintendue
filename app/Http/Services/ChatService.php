<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Donation;
use App\Services\NotificationService;

class ChatService
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Démarrer une conversation
     */
    public function startConversation(Donation $donation, User $initiator, $initialMessage = null)
    {
        // Vérifier si une conversation existe déjà
        $existingConversation = Conversation::where('donation_id', $donation->id)
            ->where(function ($query) use ($initiator) {
                $query->where('initiator_id', $initiator->id)
                      ->orWhere('recipient_id', $initiator->id);
            })
            ->first();

        if ($existingConversation) {
            return $existingConversation;
        }

        // Créer la conversation
        $conversation = Conversation::create([
            'donation_id' => $donation->id,
            'initiator_id' => $initiator->id,
            'recipient_id' => $donation->donor_id,
            'status' => 'active',
        ]);

        // Ajouter un message initial si fourni
        if ($initialMessage) {
            $this->sendMessage($conversation, $initiator, $initialMessage);
        }

        return $conversation;
    }

    /**
     * Envoyer un message
     */
    public function sendMessage(Conversation $conversation, User $sender, $content, $isSystem = false)
    {
        // Vérifier que l'utilisateur fait partie de la conversation
        if (!in_array($sender->id, [$conversation->initiator_id, $conversation->recipient_id])) {
            throw new \Exception('Utilisateur non autorisé dans cette conversation');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $sender->id,
            'content' => $content,
            'is_system_message' => $isSystem,
        ]);

        // Mettre à jour la dernière activité
        $conversation->update([
            'last_message_at' => now(),
        ]);

        // Notifier l'autre participant
        if (!$isSystem) {
            $this->notificationService->notifyNewMessage($conversation, $sender, $content);
        }

        return $message;
    }

    /**
     * Envoyer un message système
     */
    public function sendSystemMessage(Conversation $conversation, $content, $metadata = [])
    {
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => null,
            'content' => $content,
            'is_system_message' => true,
            'metadata' => $metadata,
        ]);

        return $message;
    }

    /**
     * Récupérer les conversations d'un utilisateur
     */
    public function getUserConversations(User $user, $withUnreadCount = true)
    {
        $conversations = Conversation::where('initiator_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->with(['donation', 'initiator', 'recipient', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        if ($withUnreadCount) {
            $conversations->each(function ($conversation) use ($user) {
                $conversation->unread_count = $this->getUnreadCount($conversation, $user);
            });
        }

        return $conversations;
    }

    /**
     * Compter les messages non lus
     */
    public function getUnreadCount(Conversation $conversation, User $user)
    {
        return Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Marquer les messages comme lus
     */
    public function markAsRead(Conversation $conversation, User $user)
    {
        return Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Fermer une conversation
     */
    public function closeConversation(Conversation $conversation, User $user)
    {
        // Vérifier les permissions
        if (!in_array($user->id, [$conversation->initiator_id, $conversation->recipient_id])) {
            throw new \Exception('Permission denied');
        }

        $conversation->update(['status' => 'closed']);

        // Envoyer un message système
        $this->sendSystemMessage($conversation, 
            "Conversation fermée par {$user->name}",
            ['action' => 'conversation_closed', 'closed_by' => $user->id]
        );

        return $conversation;
    }
}