<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Masakan Indonesia',  'slug' => 'masakan-indonesia',  'icon' => '🍛', 'color' => '#FF6B35'],
            ['name' => 'Masakan Asia',       'slug' => 'masakan-asia',       'icon' => '🍜', 'color' => '#E63946'],
            ['name' => 'Masakan Barat',      'slug' => 'masakan-barat',      'icon' => '🍝', 'color' => '#457B9D'],
            ['name' => 'Makanan Sehat',      'slug' => 'makanan-sehat',      'icon' => '🥗', 'color' => '#2D6A4F'],
            ['name' => 'Dessert & Kue',      'slug' => 'dessert-kue',        'icon' => '🍰', 'color' => '#C77DFF'],
            ['name' => 'Minuman',            'slug' => 'minuman',            'icon' => '🥤', 'color' => '#48CAE4'],
            ['name' => 'Sarapan',            'slug' => 'sarapan',            'icon' => '🍳', 'color' => '#F4A261'],
            ['name' => 'Makanan Bayi',       'slug' => 'makanan-bayi',       'icon' => '🍼', 'color' => '#A8DADC'],
            ['name' => 'Vegetarian & Vegan', 'slug' => 'vegetarian-vegan',   'icon' => '🥦', 'color' => '#52B788'],
            ['name' => 'Seafood',            'slug' => 'seafood',            'icon' => '🦐', 'color' => '#0096C7'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], array_merge($cat, ['is_active' => true]));
        }
    }
}
