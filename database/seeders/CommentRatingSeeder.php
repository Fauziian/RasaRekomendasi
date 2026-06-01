<?php

namespace Database\Seeders;

use App\Models\CommentRating;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentRatingSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['user' => 'siti@example.com',  'recipe' => 'Rendang Daging Sapi Padang',    'rating' => 5, 'comment' => 'Rasanya autentik banget! Persis seperti rendang buatan nenek. Wajib coba!'],
            ['user' => 'budi@example.com',  'recipe' => 'Rendang Daging Sapi Padang',    'rating' => 5, 'comment' => 'Langkah-langkahnya jelas dan hasilnya sempurna. Saya pakai daging sapi wagyu, makin juara!'],
            ['user' => 'mega@example.com',  'recipe' => 'Nasi Goreng Kampung Spesial',   'rating' => 4, 'comment' => 'Simpel tapi enak. Cocok untuk makan malam cepat. Saya tambah sedikit terasi.'],
            ['user' => 'siti@example.com',  'recipe' => 'Nasi Goreng Kampung Spesial',   'rating' => 5, 'comment' => 'Ini jadi menu andalan saya sekarang! Hemat waktu dan tetap lezat.'],
            ['user' => 'rizki@example.com', 'recipe' => 'Udang Saus Padang Pedas',       'rating' => 4, 'comment' => 'Pedasnya pas, gurihnya mantap. Udangnya segar. Recommended!'],
            ['user' => 'ayu@example.com',   'recipe' => 'Udang Saus Padang Pedas',       'rating' => 5, 'comment' => 'Saus padangnya kental dan kaya rasa. Lebih enak dari restoran!'],
            ['user' => 'mega@example.com',  'recipe' => 'Smoothie Bowl Tropical',        'rating' => 5, 'comment' => 'Super healthy dan instagrammable! Saya buat setiap pagi sekarang.'],
            ['user' => 'siti@example.com',  'recipe' => 'Smoothie Bowl Tropical',        'rating' => 4, 'comment' => 'Segar dan mengenyangkan. Warnanya cantik. Tapi butuh freezer untuk pisang bekunya.'],
        ];

        foreach ($reviews as $review) {
            $user   = User::where('email', $review['user'])->first();
            $recipe = Recipe::where('title', $review['recipe'])->first();

            if ($user && $recipe) {
                CommentRating::firstOrCreate(
                    ['user_id' => $user->id, 'recipe_id' => $recipe->id],
                    [
                        'rating'      => $review['rating'],
                        'comment'     => $review['comment'],
                        'is_approved' => true,
                        'approved_at' => now(),
                    ]
                );
            }
        }
    }
}
