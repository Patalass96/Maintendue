<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // --- GÉNÉRAL ---
            [
                'question' => 'Qu\'est-ce que MainTendue ?',
                'answer' => 'MainTendue est une plateforme de solidarité au Togo qui facilite la mise en relation entre donateurs particuliers et associations caritatives.',
                'category' => 'general',
                'order_index' => 1,
            ],
            [
                'question' => 'L\'utilisation de la plateforme est-elle payante ?',
                'answer' => 'Non, MainTendue est entièrement gratuite pour les donateurs et les associations. Notre but est uniquement de faciliter l\'entraide.',
                'category' => 'general',
                'order_index' => 2,
            ],

            // --- DONATEURS (Donor) ---
            [
                'question' => 'Comment puis-je faire un don ?',
                'answer' => 'Il vous suffit de créer un compte, de cliquer sur "Faire un don", de remplir les informations sur l\'objet (photo, état, catégorie) et de choisir un point de collecte.',
                'category' => 'donor',
                'order_index' => 1,
            ],
            [
                'question' => 'Puis-je donner des articles d\'occasion ?',
                'answer' => 'Oui, à condition qu\'ils soient en bon état et fonctionnels. La dignité de ceux qui reçoivent est notre priorité.',
                'category' => 'donor',
                'order_index' => 2,
            ],

            // --- ASSOCIATIONS ---
            [
                'question' => 'Comment enregistrer mon association ?',
                'answer' => 'Lors de l\'inscription, choisissez le rôle "Association". Vous devrez fournir votre numéro d\'enregistrement officiel pour être validé par l\'administrateur.',
                'category' => 'association',
                'order_index' => 1,
            ],
            [
                'question' => 'Comment récupérer les dons ?',
                'answer' => 'Une fois que vous demandez un don et que le donateur accepte, vous pouvez vous organiser pour la récupération au point de collecte indiqué.',
                'category' => 'association',
                'order_index' => 2,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}