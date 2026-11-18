<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Mengisi data dummy enrollment sesuai Panduan Praktikum Pertemuan 12.
     * Menggunakan firstOrCreate agar aman dijalankan berulang kali.
     */
    public function run(): void
    {
        $alya = Participant::where('email', 'alya@example.test')->first();
        $bima = Participant::where('email', 'bima@example.test')->first();

        $laravel = Course::where('code', 'LRV-101')->first()
            ?? Course::where('status', 'open')->first();
        $php = Course::where('code', 'PHP-101')->first();

        if ($alya && $laravel) {
            Enrollment::firstOrCreate(
                [
                    'participant_id' => $alya->id,
                    'course_id'      => $laravel->id,
                ],
                [
                    'status' => 'registered',
                ]
            );
        }

        if ($alya && $php) {
            Enrollment::firstOrCreate(
                [
                    'participant_id' => $alya->id,
                    'course_id'      => $php->id,
                ],
                [
                    'status' => 'registered',
                ]
            );
        }

        if ($bima && $laravel) {
            Enrollment::firstOrCreate(
                [
                    'participant_id' => $bima->id,
                    'course_id'      => $laravel->id,
                ],
                [
                    'status' => 'registered',
                ]
            );
        }
    }
}
