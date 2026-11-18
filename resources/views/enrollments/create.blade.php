@extends('layouts.app')

@section('title', 'Tambah Enrollment - KursusKu')

@section('content')
<div class="row justify-content-center g-4">
    <div class="col-lg-3 d-none d-lg-block">
        <div class="persona-art-frame">
            <span class="persona-tag">Contact</span>
            <img src="{{ asset('images/persona/contact-character.jpg') }}" alt="Karakter pendaftaran">
        </div>
    </div>
    <div class="col-lg-8">
        <div class="form-glass p-4 p-md-5">
            <h1 class="h3 mb-2 fw-bold">Tambah Enrollment</h1>
            <p class="text-secondary mb-4">
                Pilih participant dan kursus yang akan didaftarkan. Satu participant hanya
                boleh terdaftar sekali pada kursus yang sama.
            </p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('enrollments.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="participant_id" class="form-label">Participant</label>
                    <select id="participant_id" name="participant_id"
                            class="form-select @error('participant_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Participant --</option>
                        @foreach ($participants as $participant)
                            <option value="{{ $participant->id }}"
                                @selected(old('participant_id') == $participant->id)>
                                {{ $participant->name }} - {{ $participant->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('participant_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($participants->isEmpty())
                        <div class="form-text text-warning">
                            Belum ada data participant. Tambahkan dulu lewat
                            <code>php artisan tinker</code> atau
                            <code>php artisan db:seed --class=ParticipantSeeder</code>.
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">Pilih Kursus</label>
                    <select id="course_id" name="course_id"
                            class="form-select @error('course_id') is-invalid @enderror" required>
                        <option value="">-- pilih kursus --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                {{ $course->code }} - {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($courses->isEmpty())
                        <div class="form-text text-warning">
                            Belum ada kursus berstatus "open". Ubah status kursus lewat halaman
                            <a href="{{ route('courses.index') }}">Daftar Kursus</a>.
                        </div>
                    @endif
                </div>

                <div id="availability" class="alert alert-secondary">
                    Pilih kursus untuk melihat sisa kursi.
                </div>

                <button class="btn btn-accent" type="submit">Simpan Enrollment</button>
            </form>
        </div>
    </div>
</div>
@endsection
