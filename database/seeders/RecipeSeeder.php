<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $chefRina  = User::where('email', 'chef.rina@rasarekomendasi.id')->first();
        $chefBudi  = User::where('email', 'chef.budi@rasarekomendasi.id')->first();
        $chefDewi  = User::where('email', 'chef.dewi@rasarekomendasi.id')->first();

        $catIndo    = Category::where('slug', 'masakan-indonesia')->first();
        $catAsia    = Category::where('slug', 'masakan-asia')->first();
        $catDessert = Category::where('slug', 'dessert-kue')->first();
        $catSehat   = Category::where('slug', 'makanan-sehat')->first();
        $catSeafood = Category::where('slug', 'seafood')->first();

        $recipes = [
            // ── Indonesian ─────────────────────────────────────────────────────
            [
                'chef_id'       => $chefRina->id,
                'category_id'   => $catIndo->id,
                'title'         => 'Rendang Daging Sapi Panggang',
                'description'   => 'Rendang adalah masakan khas Minangkabau yang kaya rempah. Daging sapi dimasak perlahan dengan santan dan bumbu rempah hingga mengering dan berwarna cokelat kehitaman.',
                'ingredients'   => [
                    ['name' => 'Daging sapi', 'amount' => '1', 'unit' => 'kg'],
                    ['name' => 'Santan kelapa', 'amount' => '800', 'unit' => 'ml'],
                    ['name' => 'Bawang merah', 'amount' => '15', 'unit' => 'siung'],
                    ['name' => 'Bawang putih', 'amount' => '8', 'unit' => 'siung'],
                    ['name' => 'Cabai merah keriting', 'amount' => '20', 'unit' => 'buah'],
                    ['name' => 'Lengkuas', 'amount' => '3', 'unit' => 'cm'],
                    ['name' => 'Serai', 'amount' => '3', 'unit' => 'batang'],
                    ['name' => 'Daun salam', 'amount' => '5', 'unit' => 'lembar'],
                    ['name' => 'Kunyit', 'amount' => '2', 'unit' => 'cm'],
                    ['name' => 'Garam', 'amount' => '2', 'unit' => 'sdt'],
                ],
                'cooking_steps' => [
                    ['step' => 1, 'instruction' => 'Haluskan bawang merah, bawang putih, cabai, lengkuas, dan kunyit.'],
                    ['step' => 2, 'instruction' => 'Tumis bumbu halus bersama serai dan daun salam hingga harum.'],
                    ['step' => 3, 'instruction' => 'Masukkan daging sapi, aduk hingga berubah warna.'],
                    ['step' => 4, 'instruction' => 'Tuang santan, masak dengan api sedang sambil terus diaduk.'],
                    ['step' => 5, 'instruction' => 'Kecilkan api, masak selama 3-4 jam hingga santan mengering dan rendang berwarna cokelat.'],
                ],
                'prep_time'     => 0,
                'cook_time'     => 14,
                'difficulty'    => 'hard',
                'calories'      => 450,
                'servings'      => 6,
                'allergens'     => [],
                'is_vip_content'=> false,
                'video_url'     => 'https://www.youtube.com/watch?v=DMcFqtm1lfY',
                'status'        => 'published',
                'tags'          => ['Tradisional', 'Gurih', 'Pedas'],
            ],
            [
                'chef_id'       => $chefRina->id,
                'category_id'   => $catIndo->id,
                'title'         => 'Nasi Goreng Kampung Spesial',
                'description'   => 'Nasi goreng dengan bumbu kampung sederhana namun penuh cita rasa. Cocok untuk sarapan pagi yang cepat dan lezat.',
                'ingredients'   => [
                    ['name' => 'Nasi putih', 'amount' => '3', 'unit' => 'piring'],
                    ['name' => 'Telur ayam', 'amount' => '2', 'unit' => 'butir'],
                    ['name' => 'Bawang merah', 'amount' => '5', 'unit' => 'siung'],
                    ['name' => 'Bawang putih', 'amount' => '3', 'unit' => 'siung'],
                    ['name' => 'Cabai rawit', 'amount' => '5', 'unit' => 'buah'],
                    ['name' => 'Kecap manis', 'amount' => '2', 'unit' => 'sdm'],
                    ['name' => 'Garam & merica', 'amount' => 'secukupnya', 'unit' => ''],
                    ['name' => 'Minyak goreng', 'amount' => '3', 'unit' => 'sdm'],
                ],
                'cooking_steps' => [
                    ['step' => 1, 'instruction' => 'Haluskan bawang merah, bawang putih, and cabai rawit.'],
                    ['step' => 2, 'instruction' => 'Panaskan minyak, tumis bumbu halus hingga harum dan matang.'],
                    ['step' => 3, 'instruction' => 'Masukkan telur, orak-arik hingga setengah matang.'],
                    ['step' => 4, 'instruction' => 'Masukkan nasi, aduk rata dengan bumbu.'],
                    ['step' => 5, 'instruction' => 'Tambahkan kecap manis, garam, dan merica. Aduk rata.'],
                    ['step' => 6, 'instruction' => 'Sajikan dengan kerupuk, acar, dan irisan timun.'],
                ],
                'prep_time'     => 0,
                'cook_time'     => 9,
                'difficulty'    => 'easy',
                'calories'      => 380,
                'servings'      => 2,
                'allergens'     => ['eggs'],
                'is_vip_content'=> false,
                'video_url'     => 'https://www.youtube.com/watch?v=W1zb_ugYlu8',
                'status'        => 'published',
                'tags'          => ['Cepat', 'Anti-Gagal', 'Untuk Pemula', 'Budget Friendly'],
            ],
            // ── Asian ──────────────────────────────────────────────────────────
            [
                'chef_id'       => $chefBudi->id,
                'category_id'   => $catAsia->id,
                'title'         => 'Ramen Tonkotsu Homemade',
                'description'   => 'Ramen kuah tonkotsu dengan kaldu tulang babi yang dimasak selama 12 jam hingga creamy dan kaya umami. Versi premium dengan video tutorial eksklusif.',
                'ingredients'   => [
                    ['name' => 'Mie ramen segar', 'amount' => '400', 'unit' => 'gram'],
                    ['name' => 'Tulang babi', 'amount' => '1', 'unit' => 'kg'],
                    ['name' => 'Telur rebus', 'amount' => '4', 'unit' => 'butir'],
                    ['name' => 'Chashu (daging babi gulung)', 'amount' => '200', 'unit' => 'gram'],
                    ['name' => 'Nori (rumput laut)', 'amount' => '4', 'unit' => 'lembar'],
                    ['name' => 'Bawang daun', 'amount' => '2', 'unit' => 'batang'],
                    ['name' => 'Tare (saus dasar)', 'amount' => '4', 'unit' => 'sdm'],
                ],
                'cooking_steps' => [
                    ['step' => 1, 'instruction' => 'Rebus tulang babi selama 12 jam dengan api kecil hingga kaldu menjadi putih dan creamy.'],
                    ['step' => 2, 'instruction' => 'Buat tare dari kecap, mirin, dan sake.'],
                    ['step' => 3, 'instruction' => 'Rebus mie sesuai petunjuk, tiriskan.'],
                    ['step' => 4, 'instruction' => 'Siapkan mangkuk, tuang tare dan kaldu tonkotsu panas.'],
                    ['step' => 5, 'instruction' => 'Tata mie, telur, chashu, nori, dan bawang daun di atasnya.'],
                ],
                'prep_time'     => 0,
                'cook_time'     => 18,
                'difficulty'    => 'hard',
                'calories'      => 650,
                'servings'      => 4,
                'allergens'     => ['gluten', 'eggs'],
                'is_vip_content'=> true,
                'video_url'     => 'https://www.youtube.com/watch?v=uPqzY8rZLZM',
                'status'        => 'published',
                'tags'          => ['Restoran Style', 'Gurih'],
            ],
            // ── Seafood ────────────────────────────────────────────────────────
            [
                'chef_id'       => $chefBudi->id,
                'category_id'   => $catSeafood->id,
                'title'         => 'Udang Saus Padang Pedas',
                'description'   => 'Udang segar dimasak dengan saus padang yang pedas dan gurih. Sajian seafood premium yang mudah dibuat di rumah.',
                'ingredients'   => [
                    ['name' => 'Udang tiger', 'amount' => '500', 'unit' => 'gram'],
                    ['name' => 'Cabai merah', 'amount' => '8', 'unit' => 'buah'],
                    ['name' => 'Tomat merah', 'amount' => '2', 'unit' => 'buah'],
                    ['name' => 'Bawang bombay', 'amount' => '1', 'unit' => 'buah'],
                    ['name' => 'Saus tomat', 'amount' => '3', 'unit' => 'sdm'],
                    ['name' => 'Saus tiram', 'amount' => '2', 'unit' => 'sdm'],
                ],
                'cooking_steps' => [
                    ['step' => 1, 'instruction' => 'Bersihkan udang, belah punggung, marinasi dengan garam dan merica.'],
                    ['step' => 2, 'instruction' => 'Tumis bawang bombay hingga harum, masukkan cabai yang sudah dihaluskan.'],
                    ['step' => 3, 'instruction' => 'Masukkan tomat, saus tomat, dan saus tiram. Aduk rata.'],
                    ['step' => 4, 'instruction' => 'Masukkan udang, masak hingga matang dan saus mengental.'],
                    ['step' => 5, 'instruction' => 'Sajikan dengan nasi putih hangat.'],
                ],
                'prep_time'     => 0,
                'cook_time'     => 11,
                'difficulty'    => 'medium',
                'calories'      => 280,
                'servings'      => 3,
                'allergens'     => ['seafood'],
                'is_vip_content'=> false,
                'video_url'     => 'https://www.youtube.com/watch?v=jYAo-UmbLGk&t=262s',
                'status'        => 'published',
                'tags'          => ['Pedas', 'Gurih'],
            ],
            // ── Dessert ────────────────────────────────────────────────────────
            [
                'chef_id'       => $chefDewi->id,
                'category_id'   => $catDessert->id,
                'title'         => 'Lapis Legit Premium Saffron',
                'description'   => 'Lapis legit dengan sentuhan saffron yang mewah. Resep rahasia dengan teknik memanggang berlapis yang membutuhkan kesabaran dan ketelitian tinggi. Tersedia video tutorial eksklusif.',
                'ingredients'   => [
                    ['name' => 'Tepung terigu', 'amount' => '100', 'unit' => 'gram'],
                    ['name' => 'Margarin', 'amount' => '500', 'unit' => 'gram'],
                    ['name' => 'Telur kuning', 'amount' => '30', 'unit' => 'butir'],
                    ['name' => 'Gula pasir halus', 'amount' => '200', 'unit' => 'gram'],
                    ['name' => 'Saffron', 'amount' => '1', 'unit' => 'gram'],
                    ['name' => 'Susu kental manis', 'amount' => '2', 'unit' => 'sdm'],
                    ['name' => 'Bumbu spekuk', 'amount' => '1', 'unit' => 'sdt'],
                ],
                'cooking_steps' => [
                    ['step' => 1, 'instruction' => 'Kocok margarin hingga putih dan fluffy, sisihkan.'],
                    ['step' => 2, 'instruction' => 'Kocok telur dan gula hingga mengembang dan berwarna pucat.'],
                    ['step' => 3, 'instruction' => 'Campurkan kedua adonan, masukkan tepung secara bertahap.'],
                    ['step' => 4, 'instruction' => 'Bagi adonan menjadi 2: satu polos, satu dengan saffron.'],
                    ['step' => 5, 'instruction' => 'Panggang berlapis satu per satu dalam oven 180°C dengan posisi api atas.'],
                    ['step' => 6, 'instruction' => 'Ulangi proses hingga 18-20 lapisan. Panggang lapisan terakhir sampai matang.'],
                ],
                'prep_time'     => 0,
                'cook_time'     => 21,
                'difficulty'    => 'hard',
                'calories'      => 520,
                'servings'      => 20,
                'allergens'     => ['gluten', 'eggs', 'dairy'],
                'is_vip_content'=> true,
                'video_url'     => 'https://www.youtube.com/watch?v=A7XveUfM6Gk',
                'status'        => 'published',
                'tags'          => ['Tradisional', 'Restoran Style'],
            ],
            // ── Healthy ────────────────────────────────────────────────────────
            [
                'chef_id'       => $chefDewi->id,
                'category_id'   => $catSehat->id,
                'title'         => 'Smoothie Bowl Tropical',
                'description'   => 'Sarapan sehat berbasis buah tropis dengan topping granola dan biji chia. Rendah kalori, tinggi serat dan vitamin.',
                'ingredients'   => [
                    ['name' => 'Pisang beku', 'amount' => '2', 'unit' => 'buah'],
                    ['name' => 'Mangga beku', 'amount' => '100', 'unit' => 'gram'],
                    ['name' => 'Yogurt plain', 'amount' => '100', 'unit' => 'ml'],
                    ['name' => 'Granola', 'amount' => '50', 'unit' => 'gram'],
                    ['name' => 'Biji chia', 'amount' => '1', 'unit' => 'sdm'],
                    ['name' => 'Buah naga', 'amount' => '50', 'unit' => 'gram'],
                    ['name' => 'Madu', 'amount' => '1', 'unit' => 'sdt'],
                ],
                'cooking_steps' => [
                    ['step' => 1, 'instruction' => 'Blender pisang beku, mangga, dan yogurt hingga smooth dan creamy.'],
                    ['step' => 2, 'instruction' => 'Tuang ke mangkuk, ratakan permukaannya.'],
                    ['step' => 3, 'instruction' => 'Tata granola, buah naga, dan topping lain di atasnya.'],
                    ['step' => 4, 'instruction' => 'Taburkan biji chia dan drizzle madu. Sajikan segera.'],
                ],
                'prep_time'     => 0,
                'cook_time'     => 9,
                'difficulty'    => 'easy',
                'calories'      => 180,
                'servings'      => 1,
                'allergens'     => ['dairy'],
                'is_vip_content'=> false,
                'video_url'     => 'https://www.youtube.com/watch?v=fXLYqqxB2wc&t=45s',
                'status'        => 'published',
                'tags'          => ['Makanan Sehat', 'Rendah Kalori', 'Untuk Pemula', 'Cepat'],
            ],
        ];

        foreach ($recipes as $data) {
            $tags = $data['tags'] ?? [];
            unset($data['tags']);

            $recipe = Recipe::updateOrCreate(['title' => $data['title']], $data);

            // Attach tags
            $tagIds = Tag::whereIn('name', $tags)->pluck('id');
            $recipe->tags()->syncWithoutDetaching($tagIds);
        }
    }
}
