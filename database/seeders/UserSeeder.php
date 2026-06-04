<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@rasarekomendasi.id'],
            [
                'name'              => 'Admin RasaRekomendasi',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );

        // ── Chefs ──────────────────────────────────────────────────────────────
        $chefs = [
            [
                'name'           => 'Chef Rina Sari',
                'email'          => 'chef.rina@rasarekomendasi.id',
                'specialization' => 'Masakan Indonesia & Jawa',
                'bio'            => 'Chef berpengalaman 15 tahun dengan keahlian masakan tradisional Jawa dan nusantara.',
                'rating_avg'     => 4.80,
            ],
            [
                'name'           => 'Chef Budi Santoso',
                'email'          => 'chef.budi@rasarekomendasi.id',
                'specialization' => 'Masakan Asia & Fusion',
                'bio'            => 'Spesialis masakan Asia Tenggara dengan sentuhan modern.',
                'rating_avg'     => 4.65,
            ],
            [
                'name'           => 'Chef Dewi Kusuma',
                'email'          => 'chef.dewi@rasarekomendasi.id',
                'specialization' => 'Dessert & Pastry',
                'bio'            => 'Lulusan Le Cordon Bleu Jakarta dengan passion di bidang kue dan dessert.',
                'rating_avg'     => 4.90,
            ],
        ];

        foreach ($chefs as $chef) {
            User::firstOrCreate(
                ['email' => $chef['email']],
                array_merge($chef, [
                    'password'          => Hash::make('password'),
                    'role'              => 'chef',
                    'email_verified_at' => now(),
                    'is_active'         => true,
                ])
            );
        }

        // ── Regular Users ──────────────────────────────────────────────────────
        $users = [
            [
                'name'         => 'Siti Rahayu',
                'email'        => 'siti@example.com',
                'is_vip'       => false,
            ],
            [
                'name'         => 'Budi Prakoso',
                'email'        => 'budi@example.com',
                'is_vip'       => true,
                'vip_expires_at' => Carbon::now()->addDays(30),
            ],
            [
                'name'         => 'Mega Wulandari',
                'email'        => 'mega@example.com',
                'is_vip'       => true,
                'vip_expires_at' => Carbon::now()->addDays(365),
            ],
            [
                'name'         => 'Rizki Pratama',
                'email'        => 'rizki@example.com',
                'is_vip'       => false,
            ],
            [
                'name'         => 'Ayu Lestari',
                'email'        => 'ayu@example.com',
                'is_vip'       => false,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                array_merge($user, [
                    'password'          => Hash::make('password'),
                    'role'              => 'user',
                    'email_verified_at' => now(),
                    'is_active'         => true,
                ])
            );
        }
    }
}
