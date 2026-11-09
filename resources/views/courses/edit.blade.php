@extends('layouts.app')

@section('title', 'Edit Kursus')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="h3 mb-0 fw-bold">Edit Kursus</h1>
            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-light">Batal</a>
        </div>

        {{-- old('field', nilai database): jika validasi gagal, input terakhir user tetap ada. --}}
        <form method="POST" action="{{ route('courses.update', $course) }}" class="form-glass p-4 p-md-5">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="code">Kode Kursus</label>
                <input class="form-control @error('code') is-invalid @enderror"
                       id="code" name="code" maxlength="20"
                       value="{{ old('code', $course->code) }}">
                @error('code')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">Nama Kursus</label>
                <input class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" maxlength="120"
                       value="{{ old('name', $course->name) }}">
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="4" maxlength="2000">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="fee">Biaya</label>
                    <input class="form-control @error('fee') is-invalid @enderror"
                           id="fee" type="number" name="fee" min="0"
                           value="{{ old('fee', $course->fee) }}">
                    @error('fee')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="quota">Kuota</label>
                    <input class="form-control @error('quota') is-invalid @enderror"
                           id="quota" type="number" name="quota" min="1" max="500"
                           value="{{ old('quota', $course->quota) }}">
                    @error('quota')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="start_date">Tanggal Mulai</label>
                    <input class="form-control @error('start_date') is-invalid @enderror"
                           id="start_date" type="date" name="start_date"
                           value="{{ old('start_date', $course->start_date?->format('Y-m-d')) }}">
                    @error('start_date')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status">
                        @foreach (['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $course->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-2">
                <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-light">Batal</a>
                <button class="btn btn-accent" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
