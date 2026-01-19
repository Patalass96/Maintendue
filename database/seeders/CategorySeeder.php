<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Alimentaire',
                'icon' => 'fas fa-utensils',
                'description' => 'Produits secs, conserves, riz, et denrées non périssables.',
                'order_index' => 1
            ],
            [
                'name' => 'Vêtements & Chaussures',
                'icon' => 'fas fa-tshirt',
                'description' => 'Habits pour enfants et adultes, chaussures et linges de maison.',
                'order_index' => 2
            ],
            [
                'name' => 'Fournitures Scolaires',
                'icon' => 'fas fa-book-open',
                'description' => 'Cahiers, sacs à dos, stylos et livres pour écoliers.',
                'order_index' => 3
            ],
            [
                'name' => 'Hygiène & Santé',
                'icon' => 'fas fa-medkit',
                'description' => 'Savons, protections hygiéniques, kits de premiers secours.',
                'order_index' => 4
            ],
            [
                'name' => 'Équipement Maison',
                'icon' => 'fas fa-couch',
                'description' => 'Petit électmonager, vaisselle, lampes et mobilier.',
                'order_index' => 5
            ],
            [
                'name' => 'Jouets & Puériculture',
                'icon' => 'fas fa-baby-carriage',
                'description' => 'Jeux pour enfants et articles pour bébés.',
                'order_index' => 6
            ],
            [
                'name' => 'Autres',
                'icon' => 'fas fa-ellipsis-h',
                'description' => 'Tout autre objet ne rentrant pas dans les catégories ci-dessus.',
                'order_index' => 99 // On met un grand nombre pour qu'elle reste à la fin
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])], 
                [
                    'name'        => $category['name'],
                    'icon'        => $category['icon'],
                    'description' => $category['description'],
                    'order_index' => $category['order_index'],
                    'is_active'   => true,
                ]
            );
        }
    }
}