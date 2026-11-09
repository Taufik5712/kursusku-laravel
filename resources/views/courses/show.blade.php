@extends('layouts.app')

@section('title', 'Detail Kursus')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 fw-bold">Detail Kursus</h1>
        <p class="text-secondary mb-0">{{ $course->code }} — {{ $course->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('courses.index') }}" class="btn btn-outline-light">Kembali</a>
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-accent">Edit</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-3 d-none d-lg-block">
        <div class="persona-art-frame">
            <span class="persona-tag">Profile</span>
            <img src="{{ asset('images/persona/about-character.jpg') }}" alt="Karakter detail kursus">
        </div>
    </div>
    <div class="col-lg-9">
<div class="form-glass p-4 p-md-5">
    <dl class="row mb-0">
        <dt class="col-sm-3 text-secondary">Kode</dt>
        <dd class="col-sm-9"><span class="course-code">{{ $course->code }}</span></dd>

        <dt class="col-sm-3 text-secondary">Nama</dt>
        <dd class="col-sm-9">{{ $course->name }}</dd>

        <dt class="col-sm-3 text-secondary">Deskripsi</dt>
        <dd class="col-sm-9">{{ $course->description ?: '-' }}</dd>

        <dt class="col-sm-3 text-secondary">Biaya</dt>
        <dd class="col-sm-9">Rp {{ number_format($course->fee, 0, ',', '.') }}</dd>

        <dt class="col-sm-3 text-secondary">Kuota</dt>
        <dd class="col-sm-9">{{ $course->quota }} peserta</dd>

        <dt class="col-sm-3 text-secondary">Tanggal Mulai</dt>
        <dd class="col-sm-9">{{ $course->start_date?->format('d-m-Y') }}</dd>

        <dt class="col-sm-3 text-secondary">Status</dt>
        <dd class="col-sm-9">
            @php
                $statusClass = match($course->status) {
                    'open' => 'ok',
                    'draft' => 'low',
                    default => 'full',
                };
            @endphp
            <span class="seat-pill {{ $statusClass }}">{{ ucfirst($course->status) }}</span>
        </dd>
    </dl>
</div>
    </div>
</div>
@endsection
