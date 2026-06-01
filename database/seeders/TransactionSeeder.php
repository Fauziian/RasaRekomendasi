<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\VipPackage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $budi = User::where('email', 'budi@example.com')->first();
        $mega = User::where('email', 'mega@example.com')->first();

        $pkgBulanan  = VipPackage::where('name', 'Paket Bulanan')->first();
        $pkgTahunan  = VipPackage::where('name', 'Paket Tahunan')->first();

        if ($budi && $pkgBulanan) {
            Transaction::firstOrCreate(
                ['invoice_number' => 'RR-2024-00001'],
                [
                    'user_id'              => $budi->id,
                    'vip_package_id'       => $pkgBulanan->id,
                    'amount'               => $pkgBulanan->price,
                    'payment_status'       => 'success',
                    'payment_method'       => 'transfer_bank',
                    'payment_channel'      => 'BCA',
                    'paid_at'              => Carbon::now()->subDays(5),
                    'vip_starts_at'        => Carbon::now()->subDays(5),
                    'vip_ends_at'          => Carbon::now()->addDays(25),
                    'payment_gateway_log'  => ['transaction_id' => 'TRX-BCA-001', 'status' => 'settlement'],
                ]
            );
        }

        if ($mega && $pkgTahunan) {
            Transaction::firstOrCreate(
                ['invoice_number' => 'RR-2024-00002'],
                [
                    'user_id'              => $mega->id,
                    'vip_package_id'       => $pkgTahunan->id,
                    'amount'               => $pkgTahunan->price,
                    'payment_status'       => 'success',
                    'payment_method'       => 'ewallet',
                    'payment_channel'      => 'GoPay',
                    'paid_at'              => Carbon::now()->subDays(30),
                    'vip_starts_at'        => Carbon::now()->subDays(30),
                    'vip_ends_at'          => Carbon::now()->addDays(335),
                    'payment_gateway_log'  => ['transaction_id' => 'TRX-GP-002', 'status' => 'settlement'],
                ]
            );
        }
    }
}
