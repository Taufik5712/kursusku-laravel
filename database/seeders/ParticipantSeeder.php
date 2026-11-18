<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Opsional — jalankan dengan:
     *   php artisan db:seed --class=ParticipantSeeder
     * Tetap coba tambah satu data lewat php artisan tinker secara manual
     * dulu (lihat Langkah 5 panduan) agar paham cara Eloquent create().
     */
    public function run(): void
    {
        $participants = [
            ['Alya Rahma', 'alya@example.test', '081200000001'],
            ['Bima Putra', 'bima@example.test', '081200000002'],
            ['Citra Nabila', 'citra@example.test', null],
        ];

        foreach ($participants as [$name, $email, $phone]) {
            Participant::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'phone' => $phone]
            );
        }
    }
}
