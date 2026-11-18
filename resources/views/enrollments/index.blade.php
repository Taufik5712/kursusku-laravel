@extends('layouts.app')

@section('title', 'Laporan Enrollment - KursusKu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 fw-bold">Laporan Enrollment</h1>
        <p class="text-secondary mb-0">
            Data gabungan participant, course, tanggal mulai, dan status pendaftaran
            (dibaca lintas tabel lewat relasi Eloquent).
        </p>
    </div>
    <a href="{{ route('enrollments.create') }}" class="btn btn-accent">+ Tambah Enrollment</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="form-glass p-0">
    <div class="table-responsive">
        <table class="table table-dark mb-0 align-middle">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Tanggal Mulai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->participant->name }}</td>
                        <td>{{ $enrollment->participant->email }}</td>
                        <td>{{ $enrollment->course->code }} - {{ $enrollment->course->name }}</td>
                        <td>{{ $enrollment->course->start_date?->format('d-m-Y') }}</td>
                        <td><span class="seat-pill ok">{{ ucfirst($enrollment->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            Belum ada enrollment. Mulai dari
                            <a href="{{ route('enrollments.create') }}">halaman tambah enrollment</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
