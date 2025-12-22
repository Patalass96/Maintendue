<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'MainTendue',
                'description' => 'Nom officiel de la plateforme.',
                'is_public' => true,
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@maintendue.tg',
                'description' => 'Email de support pour les utilisateurs.',
                'is_public' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'description' => 'Active ou désactive l\'accès au site pour maintenance.',
                'is_public' => false,
            ],
            [
                'key' => 'donation_limit_per_user',
                'value' => '10',
                'description' => 'Nombre maximum de dons actifs par donateur.',
                'is_public' => false,
            ],
            [
                'key' => 'social_links',
                'value' => json_encode([
                    'facebook' => 'https://facebook.com/maintendue',
                    'youtube' => 'https://youtube.com/c/maintendue',
                    'linkedin' => 'https://linkedin.com/company/maintendue'
                ]),
                'description' => 'Liens vers les réseaux sociaux (Format JSON).',
                'is_public' => true,
            ],
            [
                'key' => 'footer_text',
                'value' => 'Ensemble, aidons ceux qui en ont besoin au Togo.',
                'description' => 'Texte affiché en bas de page.',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(
                ['key' => $setting['key']], 
                $setting
            );
        }
    }
}