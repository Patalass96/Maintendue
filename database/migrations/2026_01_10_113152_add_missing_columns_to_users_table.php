<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. COLONNES DE BASE MANQUANTES
            if (!Schema::hasColumn('users', 'description')) {
                $table->text('description')->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
            
            // 2. INFORMATIONS ASSOCIATION (si l'utilisateur est une association)
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('role');
            }
            
            if (!Schema::hasColumn('users', 'association_name')) {
                $table->string('association_name')->nullable()->after('is_verified');
            }
            
            if (!Schema::hasColumn('users', 'association_description')) {
                $table->text('association_description')->nullable()->after('association_name');
            }
            
            if (!Schema::hasColumn('users', 'association_website')) {
                $table->string('association_website')->nullable()->after('association_description');
            }
            
            if (!Schema::hasColumn('users', 'association_logo')) {
                $table->string('association_logo')->nullable()->after('association_website');
            }
            
            if (!Schema::hasColumn('users', 'association_legal_number')) {
                $table->string('association_legal_number')->nullable()->after('association_logo');
            }
            
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('is_verified');
            }
            
            // 3. MODÉRATION ET SUSPENSION
            if (!Schema::hasColumn('users', 'is_suspended')) {
                $table->boolean('is_suspended')->default(false)->after('is_active');
            }
            
            if (!Schema::hasColumn('users', 'suspended_until')) {
                $table->timestamp('suspended_until')->nullable()->after('is_suspended');
            }
            
            if (!Schema::hasColumn('users', 'suspension_reason')) {
                $table->text('suspension_reason')->nullable()->after('suspended_until');
            }
            
            if (!Schema::hasColumn('users', 'warning_count')) {
                $table->integer('warning_count')->default(0)->after('suspension_reason');
            }
            
            // 4. STATISTIQUES ET ÉVALUATIONS
            if (!Schema::hasColumn('users', 'average_rating')) {
                $table->decimal('average_rating', 3, 2)->nullable()->default(0)->after('warning_count');
            }
            
            if (!Schema::hasColumn('users', 'total_donations')) {
                $table->integer('total_donations')->default(0)->after('average_rating');
            }
            
            if (!Schema::hasColumn('users', 'total_received')) {
                $table->integer('total_received')->default(0)->after('total_donations');
            }
            
            if (!Schema::hasColumn('users', 'successful_transactions')) {
                $table->integer('successful_transactions')->default(0)->after('total_received');
            }
            
            if (!Schema::hasColumn('users', 'positive_reviews')) {
                $table->integer('positive_reviews')->default(0)->after('successful_transactions');
            }
            
            if (!Schema::hasColumn('users', 'negative_reviews')) {
                $table->integer('negative_reviews')->default(0)->after('positive_reviews');
            }
            
            // 5. NOTIFICATIONS ET PRÉFÉRENCES
            if (!Schema::hasColumn('users', 'push_token')) {
                $table->string('push_token')->nullable()->after('settings');
            }
            
            if (!Schema::hasColumn('users', 'device_type')) {
                $table->enum('device_type', ['ios', 'android', 'web'])->nullable()->after('push_token');
            }
            
            if (!Schema::hasColumn('users', 'push_notifications_enabled')) {
                $table->boolean('push_notifications_enabled')->default(true)->after('device_type');
            }
            
            if (!Schema::hasColumn('users', 'email_notifications_enabled')) {
                $table->boolean('email_notifications_enabled')->default(true)->after('push_notifications_enabled');
            }
            
            if (!Schema::hasColumn('users', 'language')) {
                $table->string('language')->default('fr')->after('email_notifications_enabled');
            }
            
            if (!Schema::hasColumn('users', 'timezone')) {
                $table->string('timezone')->default('Europe/Paris')->after('language');
            }
            
            // 6. SÉCURITÉ ET AUDIT
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('timezone');
            }
            
            if (!Schema::hasColumn('users', 'last_login_ip')) {
                $table->ipAddress('last_login_ip')->nullable()->after('last_login_at');
            }
            
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                // Cette colonne existe déjà dans votre migration, mais je la vérifie
                if (!Schema::hasColumn('users', 'email_verified_at')) {
                    $table->timestamp('email_verified_at')->nullable()->after('email');
                }
            }
            
            // 7. SOFT DELETES
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
            
            // 8. INDEX POUR LES PERFORMANCES
            if (!Schema::hasIndex('users', 'users_city_index')) {
                $table->index('city');
            }
            
            if (!Schema::hasIndex('users', 'users_role_index')) {
                $table->index('role');
            }
            
            if (!Schema::hasIndex('users', 'users_is_active_index')) {
                $table->index('is_active');
            }
            
            if (!Schema::hasIndex('users', 'users_is_suspended_index')) {
                $table->index('is_suspended');
            }
            
            if (!Schema::hasIndex('users', 'users_is_verified_index')) {
                $table->index('is_verified');
            }
            
            if (!Schema::hasIndex('users', 'users_average_rating_index')) {
                $table->index('average_rating');
            }
            
            if (!Schema::hasIndex('users', 'users_created_at_index')) {
                $table->index('created_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer uniquement les colonnes que nous avons ajoutées
            $columnsToDrop = [
                'description', 'city', 'postal_code',
                'is_verified', 'association_name', 'association_description',
                'association_website', 'association_logo', 'association_legal_number',
                'verified_at', 'is_suspended', 'suspended_until', 'suspension_reason',
                'warning_count', 'average_rating', 'total_donations', 'total_received',
                'successful_transactions', 'positive_reviews', 'negative_reviews',
                'push_token', 'device_type', 'push_notifications_enabled',
                'email_notifications_enabled', 'language', 'timezone',
                'last_login_at', 'last_login_ip'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Supprimer soft deletes si présent
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            
            // Supprimer les index que nous avons ajoutés
            $indexesToDrop = [
                'users_city_index', 'users_role_index', 'users_is_active_index',
                'users_is_suspended_index', 'users_is_verified_index',
                'users_average_rating_index', 'users_created_at_index'
            ];
            
            foreach ($indexesToDrop as $index) {
                if (Schema::hasIndex('users', $index)) {
                    $table->dropIndex($index);
                }
            }
        });
    }
};
