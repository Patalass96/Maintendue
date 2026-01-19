<template>
    <div class="notification-bell position-relative">
        <button class="btn btn-link text-dark position-relative" @click="toggleDropdown">
            <i class="bi bi-bell fs-5"></i>
            <span v-if="unreadCount > 0" 
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ unreadCount > 99 ? '99+' : unreadCount }}
            </span>
        </button>
        
        <div v-if="dropdownOpen" class="notification-dropdown">
            <div class="dropdown-menu show" style="width: 350px; max-height: 500px; overflow-y: auto;">
                <div class="dropdown-header d-flex justify-content-between align-items-center">
                    <strong>Notifications</strong>
                    <button v-if="unreadCount > 0" 
                            @click="markAllAsRead" 
                            class="btn btn-sm btn-link">
                        Tout marquer comme lu
                    </button>
                </div>
                
                <div v-if="loading" class="text-center p-3">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
                
                <div v-else-if="notifications.length === 0" class="text-center p-3">
                    <p class="text-muted mb-0">Aucune notification</p>
                </div>
                
                <div v-else>
                    <a v-for="notification in notifications" 
                       :key="notification.id"
                       :href="notification.action_url || '#'"
                       class="dropdown-item notification-item"
                       :class="{ 'unread': !notification.is_read }"
                       @click="markAsRead(notification)">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i :class="getIcon(notification.type)" class="fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ notification.title }}</h6>
                                <p class="mb-0 text-muted small">{{ notification.message }}</p>
                                <small class="text-muted">{{ formatDate(notification.created_at) }}</small>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="dropdown-divider"></div>
                <a href="/notifications" class="dropdown-item text-center">
                    Voir toutes les notifications
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dropdownOpen: false,
            notifications: [],
            unreadCount: 0,
            loading: false,
            echo: null
        };
    },
    
    mounted() {
        this.fetchNotifications();
        this.listenForNewNotifications();
        
        // Fermer le dropdown en cliquant à l'extérieur
        document.addEventListener('click', this.handleClickOutside);
    },
    
    beforeUnmount() {
        if (this.echo) {
            this.echo.leave(`user.${window.userId}`);
        }
        document.removeEventListener('click', this.handleClickOutside);
    },
    
    methods: {
        async fetchNotifications() {
            this.loading = true;
            try {
                const response = await axios.get('/api/notifications/recent');
                this.notifications = response.data.notifications;
                this.unreadCount = response.data.unread_count;
            } catch (error) {
                console.error('Erreur lors du chargement des notifications:', error);
            } finally {
                this.loading = false;
            }
        },
        
        listenForNewNotifications() {
            if (window.Echo && window.userId) {
                this.echo = window.Echo.private(`user.${window.userId}`)
                    .listen('.notification.created', (e) => {
                        this.notifications.unshift(e.notification);
                        this.unreadCount++;
                    });
            }
        },
        
        async markAsRead(notification) {
            try {
                await axios.put(`/notifications/${notification.id}`, {
                    is_read: true
                });
                
                notification.is_read = true;
                if (this.unreadCount > 0) {
                    this.unreadCount--;
                }
            } catch (error) {
                console.error('Erreur lors du marquage comme lu:', error);
            }
        },
        
        async markAllAsRead() {
            try {
                await axios.post('/notifications/mark-all-read');
                this.notifications.forEach(n => n.is_read = true);
                this.unreadCount = 0;
            } catch (error) {
                console.error('Erreur:', error);
            }
        },
        
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
            if (this.dropdownOpen && this.unreadCount > 0) {
                this.markAllAsRead();
            }
        },
        
        getIcon(type) {
            const icons = {
                'new_donation': 'bi bi-gift',
                'message': 'bi bi-chat',
                'request': 'bi bi-envelope',
                'request_accepted': 'bi bi-check-circle',
                'review': 'bi bi-star',
                'warning': 'bi bi-exclamation-triangle',
                'donation_delivered': 'bi bi-truck',
                'donation_received': 'bi bi-box-seam',
                'report_created': 'bi bi-flag',
            };
            return icons[type] || 'bi bi-bell';
        },
        
        formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        handleClickOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.dropdownOpen = false;
            }
        }
    }
};
</script>

<style scoped>
.notification-bell {
    position: relative;
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
}

.notification-item.unread {
    background-color: #f8f9fa;
    border-left: 3px solid #0d6efd;
}

.notification-item:hover {
    background-color: #e9ecef;
}

.dropdown-menu {
    transform: translateX(-50%);
    left: 50%;
}
</style>