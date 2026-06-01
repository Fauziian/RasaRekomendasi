<?php

namespace Database\Seeders;

use App\Models\VipPackage;
use Illuminate\Database\Seeder;

class VipPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name'          => 'Paket Bulanan',
                'description'   => 'Akses penuh selama 30 hari. Cocok untuk pemula yang ingin mencoba layanan VIP.',
                'price'         => 49000,
                'duration_days' => 30,
                'features'      => [
                    'Akses semua resep eksklusif',
                    'Video tutorial premium',
                    '1x Konsultasi langsung dengan chef',
                    'Download resep tanpa batas',
                    'Bebas iklan',
                ],
                'is_active'     => true,
            ],
            [
                'name'          => 'Paket Triwulan',
                'description'   => 'Akses penuh selama 90 hari dengan harga lebih hemat.',
                'price'         => 129000,
                'duration_days' => 90,
                'features'      => [
                    'Semua fitur Paket Bulanan',
                    '3x Konsultasi langsung dengan chef',
                    'Akses materi kelas memasak online',
                    'Sertifikat digital setelah konsultasi',
                    'Prioritas dalam booking chef',
                ],
                'is_active'     => true,
            ],
            [
                'name'          => 'Paket Tahunan',
                'description'   => 'Akses penuh selama 365 hari. Paket terbaik dengan harga paling terjangkau.',
                'price'         => 399000,
                'duration_days' => 365,
                'features'      => [
                    'Semua fitur Paket Triwulan',
                    'Konsultasi tak terbatas',
                    'Akses komunitas chef eksklusif',
                    'Early access resep baru',
                    'Badge VIP di profil',
                    'Diskon 20% untuk merchandise RasaRekomendasi',
                ],
                'is_active'     => true,
            ],
        ];

        foreach ($packages as $pkg) {
            VipPackage::firstOrCreate(['name' => $pkg['name']], $pkg);
        }
    }
}
