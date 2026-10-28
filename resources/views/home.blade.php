@extends('layouts.app')

@section('title', 'Beranda - KursusKu')

@section('content')
<section class="hero-glass mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="badge-accent mb-3">Kursus teknologi untuk mahasiswa</span>
            <h1 class="display-5 fw-bold mt-3">Belajar lebih terarah bersama {{ $siteName }}</h1>
            <p class="lead text-secondary">
                Pilih kursus, cek ketersediaan kursi secara langsung, lalu isi formulir pendaftaran.
            </p>
            <a href="{{ route('enrollments.create') }}" class="btn btn-accent">Daftar Kursus</a>
        </div>
        <div class="col-lg-5">
            <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Ilustrasi kelas {{ $siteName }}" class="img-fluid">
        </div>
    </div>
</section>

<section>
    <h2 class="fw-bold mb-4">Kursus Pilihan</h2>
    <div class="row g-4">
        @foreach ($featured as $course)
            @php
                $remaining = $course['quota'] - $course['registered'];
                $pillClass = $remaining <= 0 ? 'full' : ($remaining <= 3 ? 'low' : 'ok');
                $pillText = $remaining <= 0 ? 'Kuota penuh' : $remaining . ' kursi tersisa';
            @endphp
            <div class="col-md-6 col-lg-4">
                <article class="course-card">
                    <span class="course-code">{{ $course['code'] }}</span>
                    <h3>{{ $course['name'] }}</h3>
                    <p>{{ $course['description'] }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Rp {{ number_format($course['fee'], 0, ',', '.') }}</strong>
                        <span class="seat-pill {{ $pillClass }}">{{ $pillText }}</span>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>
@endsection
