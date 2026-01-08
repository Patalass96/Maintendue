@extends('layouts.association')

@section('title', 'Messagerie - Main Tendue')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            @include('associations.partials.sidebar')
        </div>
        
        <!-- Main content -->
        <div class="col-lg-9 col-md-8">
            <h2 class="mb-4">Messagerie</h2>
            
            <div class="card">
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="fas fa-envelope fa-4x text-muted mb-4"></i>
                        <h3>Messagerie en développement</h3>
                        <p class="text-muted mb-4">
                            La fonctionnalité de messagerie sera bientôt disponible.<br>
                            Vous pourrez communiquer avec les donateurs ici.
                        </p>
                        <a href="{{ route('associations.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Messaging System */
    .messages-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        height: 600px;
    }
    
    /* Conversations list */
    .conversations-list {
        border-right: 1px solid #e3e6f0;
        height: 100%;
        overflow-y: auto;
        background: #f8f9fc;
    }
    
    .conversations-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e3e6f0;
        background: white;
    }
    
    .conversations-search {
        position: relative;
    }
    
    .conversations-search .form-control {
        border-radius: 20px;
        padding-left: 2.5rem;
    }
    
    .conversations-search .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    .conversation-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e3e6f0;
        cursor: pointer;
        transition: background 0.3s;
        display: flex;
        align-items: center;
        background: white;
    }
    
    .conversation-item:hover {
        background: #f0f3ff;
    }
    
    .conversation-item.active {
        background: #e3f2fd;
        border-left: 3px solid #4e73df;
    }
    
    .conversation-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        margin-right: 1rem;
        object-fit: cover;
    }
    
    .conversation-info {
        flex: 1;
    }
    
    .conversation-name {
        font-weight: 600;
        color: #2e59d9;
        margin-bottom: 0.25rem;
    }
    
    .conversation-preview {
        color: #6c757d;
        font-size: 0.875rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    
    .conversation-meta {
        text-align: right;
    }
    
    .conversation-time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    
    .conversation-unread {
        background: #4e73df;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* Chat area */
    .chat-area {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .chat-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e3e6f0;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .chat-user-info {
        display: flex;
        align-items: center;
    }
    
    .chat-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 1rem;
        object-fit: cover;
    }
    
    .chat-user-name {
        font-weight: 600;
        color: #2e59d9;
        margin-bottom: 0.25rem;
    }
    
    .chat-user-status {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .chat-user-status.online {
        color: #1cc88a;
    }
    
    .chat-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .chat-actions .btn {
        width: 36px;
        height: 36px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Messages container */
    .messages-wrapper {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
        background: #f8f9fc;
    }
    
    .message-date {
        text-align: center;
        margin: 1rem 0;
    }
    
    .date-separator {
        background: white;
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        color: #6c757d;
        display: inline-block;
        border: 1px solid #e3e6f0;
    }
    
    .message {
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-end;
        max-width: 80%;
    }
    
    .message.incoming {
        margin-right: auto;
    }
    
    .message.outgoing {
        margin-left: auto;
        flex-direction: row-reverse;
    }
    
    .message-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 0 0.5rem;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
    }
    
    .message.incoming .message-bubble {
        background: white;
        border: 1px solid #e3e6f0;
        border-bottom-left-radius: 4px;
    }
    
    .message.outgoing .message-bubble {
        background: #4e73df;
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .message-time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
        text-align: right;
    }
    
    .message.outgoing .message-time {
        color: rgba(255,255,255,0.8);
    }
    
    /* Message input */
    .message-input-container {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e3e6f0;
        background: white;
    }
    
    .message-input-wrapper {
        display: flex;
        gap: 0.5rem;
        align-items: flex-end;
    }
    
    .message-input-attachments {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    
    .attachment-preview {
        position: relative;
        width: 60px;
        height: 60px;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .attachment-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .attachment-remove {
        position: absolute;
        top: 2px;
        right: 2px;
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .message-input {
        flex: 1;
        border: 1px solid #d1d3e2;
        border-radius: 20px;
        padding: 0.75rem 1rem;
        resize: none;
        max-height: 120px;
        min-height: 40px;
    }
    
    .message-input:focus {
        outline: none;
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .message-input-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .message-input-actions .btn {
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Typing indicator */
    .typing-indicator {
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .typing-dots {
        display: flex;
        margin-left: 0.5rem;
    }
    
    .typing-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6c757d;
        margin: 0 2px;
        animation: typing 1.4s infinite;
    }
    
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
    }
    
    /* Empty state */
    .messages-empty-state {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        text-align: center;
    }
    
    .messages-empty-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .messages-container {
            height: 500px;
        }
        
        .conversations-list {
            position: absolute;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 10;
            display: none;
        }
        
        .conversations-list.active {
            display: block;
        }
        
        .chat-area {
            width: 100%;
        }
        
        .back-to-conversations {
            display: flex !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Système de messagerie
        const messagesContainer = document.querySelector('.messages-wrapper');
        const messageInput = document.querySelector('.message-input');
        const sendButton = document.querySelector('.send-message');
        const attachmentInput = document.querySelector('#messageAttachment');
        const attachmentsContainer = document.querySelector('.message-input-attachments');
        
        // Charger les conversations
        function loadConversations() {
            // Simulation de données
            const conversations = [
                {
                    id: 1,
                    name: 'Ati Justin',
                    avatar: null,
                    lastMessage: 'Merci pour le don !',
                    time: '10:30',
                    unread: 2,
                    online: true
                },
                {
                    id: 2,
                    name: 'Marie Martin',
                    avatar: null,
                    lastMessage: 'Quand pouvez-vous venir ?',
                    time: 'Hier',
                    unread: 0,
                    online: false
                }
            ];
            
            const container = document.querySelector('.conversations-list .list-group');
            if (container) {
                container.innerHTML = '';
                
                conversations.forEach(conv => {
                    const item = document.createElement('div');
                    item.className = 'conversation-item';
                    item.dataset.conversationId = conv.id;
                    
                    item.innerHTML = `
                        <img src="${conv.avatar || '/assets/images/default-avatar.png'}" 
                             alt="${conv.name}" 
                             class="conversation-avatar">
                        <div class="conversation-info">
                            <div class="conversation-name">${conv.name}</div>
                            <div class="conversation-preview">${conv.lastMessage}</div>
                        </div>
                        <div class="conversation-meta">
                            <div class="conversation-time">${conv.time}</div>
                            ${conv.unread > 0 ? `<div class="conversation-unread">${conv.unread}</div>` : ''}
                        </div>
                    `;
                    
                    item.addEventListener('click', function() {
                        // Marquer comme active
                        document.querySelectorAll('.conversation-item').forEach(el => {
                            el.classList.remove('active');
                        });
                        this.classList.add('active');
                        
                        // Charger les messages
                        loadMessages(conv.id);
                        
                        // Sur mobile, passer au chat
                        if (window.innerWidth < 768) {
                            document.querySelector('.conversations-list').classList.remove('active');
                            document.querySelector('.chat-area').style.display = 'flex';
                        }
                    });
                    
                    container.appendChild(item);
                });
            }
        }
        
        // Charger les messages d'une conversation
        function loadMessages(conversationId) {
            // Simulation de messages
            const messages = [
                {
                    id: 1,
                    text: 'Bonjour ! J\'ai des vêtements à donner.',
                    sender: 'donor',
                    time: '10:25',
                    date: 'Aujourd\'hui'
                },
                {
                    id: 2,
                    text: 'Bonjour ! Avec plaisir, nous acceptons tous les dons.',
                    sender: 'association',
                    time: '10:28',
                    date: 'Aujourd\'hui'
                },
                {
                    id: 3,
                    text: 'Parfait, quand puis-je passer ?',
                    sender: 'donor',
                    time: '10:30',
                    date: 'Aujourd\'hui'
                }
            ];
            
            if (messagesContainer) {
                let lastDate = '';
                let html = '';
                
                messages.forEach(msg => {
                    // Ajouter un séparateur de date si nécessaire
                    if (msg.date !== lastDate) {
                        html += `
                            <div class="message-date">
                                <span class="date-separator">${msg.date}</span>
                            </div>
                        `;
                        lastDate = msg.date;
                    }
                    
                    const isOutgoing = msg.sender === 'association';
                    html += `
                        <div class="message ${isOutgoing ? 'outgoing' : 'incoming'}">
                            ${!isOutgoing ? `
                                <img src="/assets/images/default-avatar.png" alt="Avatar" class="message-avatar">
                            ` : ''}
                            
                            <div>
                                <div class="message-bubble">${msg.text}</div>
                                <div class="message-time">${msg.time}</div>
                            </div>
                            
                            ${isOutgoing ? `
                                <img src="{{ auth()->user()->avatar_url }}" alt="Vous" class="message-avatar">
                            ` : ''}
                        </div>
                    `;
                });
                
                messagesContainer.innerHTML = html;
                
                // Scroll vers le bas
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 100);
            }
        }
        
        // Envoyer un message
        function sendMessage() {
            const text = messageInput?.value.trim();
            if (!text) return;
            
            // Créer le message
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message outgoing';
            messageDiv.innerHTML = `
                <div>
                    <div class="message-bubble">${text}</div>
                    <div class="message-time">${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</div>
                </div>
                <img src="{{ auth()->user()->avatar_url }}" alt="Vous" class="message-avatar">
            `;
            
            messagesContainer.appendChild(messageDiv);
            messageInput.value = '';
            
            // Scroll vers le bas
            setTimeout(() => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 100);
            
            // Simuler une réponse après 1 seconde
            setTimeout(() => {
                const typingIndicator = document.querySelector('.typing-indicator');
                if (typingIndicator) {
                    typingIndicator.style.display = 'flex';
                    
                    setTimeout(() => {
                        typingIndicator.style.display = 'none';
                        
                        const replyDiv = document.createElement('div');
                        replyDiv.className = 'message incoming';
                        replyDiv.innerHTML = `
                            <img src="/assets/images/default-avatar.png" alt="Avatar" class="message-avatar">
                            <div>
                                <div class="message-bubble">Merci pour votre message !</div>
                                <div class="message-time">${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</div>
                            </div>
                        `;
                        
                        messagesContainer.appendChild(replyDiv);
                        
                        // Scroll vers le bas
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }, 1500);
                }
            }, 1000);
        }
        
        // Gestion des pièces jointes
        if (attachmentInput) {
            attachmentInput.addEventListener('change', function() {
                for (const file of this.files) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const attachment = document.createElement('div');
                        attachment.className = 'attachment-preview';
                        
                        if (file.type.startsWith('image/')) {
                            attachment.innerHTML = `
                                <img src="${e.target.result}" alt="Pièce jointe">
                                <button type="button" class="attachment-remove">&times;</button>
                            `;
                        } else {
                            attachment.innerHTML = `
                                <div style="background: #f8f9fc; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file"></i>
                                </div>
                                <button type="button" class="attachment-remove">&times;</button>
                            `;
                        }
                        
                        attachment.querySelector('.attachment-remove').addEventListener('click', function() {
                            attachment.remove();
                        });
                        
                        attachmentsContainer.appendChild(attachment);
                    };
                    
                    reader.readAsDataURL(file);
                }
                
                // Réinitialiser l'input pour permettre la sélection du même fichier
                this.value = '';
            });
        }
        
        // Événements
        if (sendButton) {
            sendButton.addEventListener('click', sendMessage);
        }
        
        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            
            // Auto-resize
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
        
        // Bouton retour sur mobile
        const backButton = document.querySelector('.back-to-conversations');
        if (backButton) {
            backButton.addEventListener('click', function() {
                document.querySelector('.conversations-list').classList.add('active');
                document.querySelector('.chat-area').style.display = 'none';
            });
        }
        
        // Initialisation
        loadConversations();
        
        // Sélectionner la première conversation
        setTimeout(() => {
            const firstConversation = document.querySelector('.conversation-item');
            if (firstConversation) {
                firstConversation.click();
            }
        }, 500);
        
        // WebSocket pour les messages en temps réel (exemple)
        function connectWebSocket() {
            if (typeof io !== 'undefined') {
                const socket = io('{{ env("WS_URL", "http://localhost:6001") }}');
                
                socket.on('connect', () => {
                    console.log('Connecté au serveur de messagerie');
                });
                
                socket.on('new-message', (data) => {
                    // Gérer les nouveaux messages entrants
                    console.log('Nouveau message:', data);
                });
                
                socket.on('typing', (data) => {
                    // Gérer l'indicateur de frappe
                    console.log('Quelqu\'un tape...', data);
                });
            }
        }
        
        // Connecter au WebSocket si disponible
        // connectWebSocket();
        
        // Recherche de conversations
        const searchInput = document.querySelector('.conversations-search input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const items = document.querySelectorAll('.conversation-item');
                
                items.forEach(item => {
                    const name = item.querySelector('.conversation-name').textContent.toLowerCase();
                    const preview = item.querySelector('.conversation-preview').textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || preview.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush

@endsection