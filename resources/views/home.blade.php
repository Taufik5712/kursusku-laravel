<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <div class="container">
        <div class="brand">
            <img src="{{ asset('images/logo-kursusku.svg') }}" alt="Logo KursusKu" class="brand-logo">
            <strong>{{ $siteName }}</strong>
        </div>
        <nav>
            <a href="{{ route('home') }}">Beranda</a>
        </nav>
    </div>
</header>

<main class="container">
    <section class="hero">
        <div>
            <span class="badge-accent">Kursus teknologi untuk mahasiswa</span>
            <h1>Bangun kemampuan web dari PHP sampai Laravel.</h1>
            <p>{{ $siteName }} menyediakan latihan terarah untuk pemula.</p>
        </div>
        <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Ilustrasi kelas {{ $siteName }}">
    </section>

    <section>
        <h2>Kursus Pilihan</h2>
        <div class="course-grid">
            @foreach ($featured as $course)
                @php
                    $remaining = $course['quota'] - $course['registered'];
                @endphp
                <article class="card">
                    <small>{{ $course['code'] }}</small>
                    <h3>{{ $course['name'] }}</h3>
                    <p>{{ $course['description'] }}</p>
                    <div class="card-footer">
                        <strong>Rp {{ number_format($course['fee'], 0, ',', '.') }}</strong>
                        <span>{{ $remaining }} kursi tersisa</span>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} {{ $siteName }} &mdash; Project Pemrograman Web III.</p>
    </div>
</footer>

</body>
</html>
