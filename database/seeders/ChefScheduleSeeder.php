<?php

namespace Database\Seeders;

use App\Models\ChefSchedule;
use App\Models\Consultation;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChefScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $chefRina = User::where('email', 'chef.rina@rasarekomendasi.id')->first();
        $chefBudi = User::where('email', 'chef.budi@rasarekomendasi.id')->first();

        $schedules = [
            // Chef Rina - next 7 days
            ['chef_id' => $chefRina?->id, 'date' => Carbon::today()->addDays(1), 'start' => '09:00', 'end' => '10:00'],
            ['chef_id' => $chefRina?->id, 'date' => Carbon::today()->addDays(1), 'start' => '14:00', 'end' => '15:00'],
            ['chef_id' => $chefRina?->id, 'date' => Carbon::today()->addDays(3), 'start' => '10:00', 'end' => '11:00'],
            ['chef_id' => $chefRina?->id, 'date' => Carbon::today()->addDays(5), 'start' => '09:00', 'end' => '10:00'],
            ['chef_id' => $chefRina?->id, 'date' => Carbon::today()->addDays(7), 'start' => '15:00', 'end' => '16:00'],

            // Chef Budi
            ['chef_id' => $chefBudi?->id, 'date' => Carbon::today()->addDays(2), 'start' => '10:00', 'end' => '11:00'],
            ['chef_id' => $chefBudi?->id, 'date' => Carbon::today()->addDays(4), 'start' => '13:00', 'end' => '14:00'],
            ['chef_id' => $chefBudi?->id, 'date' => Carbon::today()->addDays(6), 'start' => '09:00', 'end' => '10:00'],
        ];

        foreach ($schedules as $s) {
            if ($s['chef_id']) {
                ChefSchedule::firstOrCreate(
                    [
                        'chef_id'        => $s['chef_id'],
                        'available_date' => $s['date']->toDateString(),
                        'available_time_start' => $s['start'],
                    ],
                    [
                        'available_time_end' => $s['end'],
                        'status'             => 'available',
                        'max_bookings'       => 1,
                        'current_bookings'   => 0,
                    ]
                );
            }
        }
    }
}

class ConsultationSeeder extends Seeder
{
    public function run(): void
    {
        $budi     = User::where('email', 'budi@example.com')->first();
        $chefRina = User::where('email', 'chef.rina@rasarekomendasi.id')->first();
        $schedule = ChefSchedule::where('chef_id', $chefRina?->id)->first();

        if ($budi && $chefRina && $schedule) {
            $consultation = Consultation::firstOrCreate(
                ['user_id' => $budi->id, 'schedule_id' => $schedule->id],
                [
                    'chef_id'   => $chefRina->id,
                    'status'    => 'completed',
                    'topic'     => 'Cara membuat rendang agar empuk dan tidak pahit',
                    'started_at'=> Carbon::now()->subDays(2)->setTime(9, 0),
                    'ended_at'  => Carbon::now()->subDays(2)->setTime(9, 45),
                    'duration_minutes' => 45,
                    'user_rating'      => 5,
                    'user_feedback'    => 'Chef Rina sangat membantu dan sabar menjelaskan. Rendang saya jadi sukses!',
                ]
            );

            // Add sample chat messages
            $messages = [
                ['sender_id' => $budi->id,     'sender_role' => 'user', 'body' => 'Halo Chef Rina! Saya mau tanya soal rendang yang tidak empuk.'],
                ['sender_id' => $chefRina->id, 'sender_role' => 'chef', 'body' => 'Halo Budi! Silakan, ceritakan prosesnya. Sudah berapa lama memasaknya?'],
                ['sender_id' => $budi->id,     'sender_role' => 'user', 'body' => 'Saya masak sekitar 2 jam tapi masih alot.'],
                ['sender_id' => $chefRina->id, 'sender_role' => 'chef', 'body' => 'Rendang butuh minimal 3-4 jam dengan api kecil. Kuncinya sabar! Gunakan daging bagian sengkel untuk hasil terbaik.'],
                ['sender_id' => $budi->id,     'sender_role' => 'user', 'body' => 'Oh begitu! Terima kasih Chef, saya coba lagi!'],
                ['sender_id' => $chefRina->id, 'sender_role' => 'chef', 'body' => 'Sama-sama! Semangat ya. Kalau ada pertanyaan lagi, jangan ragu untuk konsultasi lagi. 😊'],
            ];

            foreach ($messages as $msg) {
                Message::firstOrCreate(
                    ['consultation_id' => $consultation->id, 'sender_id' => $msg['sender_id'], 'body' => $msg['body']],
                    array_merge($msg, ['consultation_id' => $consultation->id, 'is_read' => true, 'read_at' => now()])
                );
            }
        }
    }
}
