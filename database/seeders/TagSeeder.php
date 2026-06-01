<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Pedas', 'Gurih', 'Manis', 'Asam', 'Asin',
            'Tanpa Gluten', 'Rendah Kalori', 'Tinggi Protein', 'Keto', 'Bebas Laktosa',
            'Cepat', 'Budget Friendly', 'Tradisional', 'Modern', 'Fusion',
            'Anti-Gagal', 'Untuk Pemula', 'Restoran Style', 'Jajanan Pasar', 'Street Food',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }
    }
}
