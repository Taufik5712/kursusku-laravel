@extends('layouts.app')

@section('title', 'Pendaftaran Kursus - KursusKu')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-glass p-4 p-md-5">
            <h1 class="h3 mb-2 fw-bold">Pendaftaran Kursus</h1>
            <p class="text-secondary mb-4">
                Pilih kursus di bawah ini. Sisa kursi akan dicek secara langsung tanpa reload halaman.
            </p>

            <form method="POST" action="{{ route('enrollments.preview') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           class="form-control" placeholder="Nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           class="form-control" placeholder="nama@email.com" required>
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">Pilih Kursus</label>
                    <select id="course_id" name="course_id" class="form-select" required>
                        <option value="">-- pilih kursus --</option>
                        @foreach ($courses as $code => $course)
                            <option value="{{ $code }}" @selected(old('course_id') == $code)>
                                {{ $course['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="availability" class="alert alert-secondary">
                    Pilih kursus untuk melihat sisa kursi.
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button class="btn btn-accent" type="submit">Kirim Pendaftaran</button>
            </form>
        </div>
    </div>
</div>
@endsection
