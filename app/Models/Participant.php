<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Relasi utama 1:M — dipakai saat butuh baris enrollment lengkap
     * (termasuk status), bukan hanya daftar course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Relasi convenience M:N lewat tabel enrollments — jalan pintas untuk
     * membaca "course apa saja yang diikuti participant ini" tanpa harus
     * menulis ->enrollments->pluck('course') setiap saat.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('status')
            ->withTimestamps();
    }
}
