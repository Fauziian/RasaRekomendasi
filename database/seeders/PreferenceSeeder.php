<?php

namespace Database\Seeders;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    public function run(): void
    {
        $prefsData = [
            'siti@example.com' => [
                'preferred_category_ids' => [1, 4],   // Indonesia, Sehat
                'allergies'              => ['seafood', 'nuts'],
                'available_ingredients'  => ['ayam', 'bawang', 'tomat', 'nasi'],
                'cooking_time_limit'     => 60,
                'preferred_difficulty'   => 'easy',
                'calorie_limit'          => 400,
            ],
            'budi@example.com' => [
                'preferred_category_ids' => [1, 2, 10], // Indonesia, Asia, Seafood
                'allergies'              => [],
                'available_ingredients'  => ['daging', 'bawang', 'cabai', 'santan'],
                'cooking_time_limit'     => 120,
                'preferred_difficulty'   => 'medium',
                'calorie_limit'          => null,
            ],
            'mega@example.com' => [
                'preferred_category_ids' => [4, 5, 9],  // Sehat, Dessert, Vegan
                'allergies'              => ['gluten', 'dairy'],
                'available_ingredients'  => ['pisang', 'mangga', 'sayuran', 'tahu', 'tempe'],
                'cooking_time_limit'     => 45,
                'preferred_difficulty'   => 'any',
                'calorie_limit'          => 300,
            ],
        ];

        foreach ($prefsData as $email => $prefs) {
            $user = User::where('email', $email)->first();
            if ($user) {
                Preference::updateOrCreate(
                    ['user_id' => $user->id],
                    $prefs
                );
            }
        }
    }
}
