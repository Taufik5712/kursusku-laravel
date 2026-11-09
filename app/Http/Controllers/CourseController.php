<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Menampilkan daftar kursus dari database.
     */
    public function index()
    {
        $courses = Course::latest()->get();

        return view('courses.index', compact('courses'));
    }

    /**
     * Menampilkan form tambah kursus.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Menyimpan kursus baru.
     * Aturan validasi ada di StoreCourseRequest — controller hanya
     * menerima data yang sudah lolos pemeriksaan lewat validated().
     */
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    /**
     * Halaman detail satu Course.
     * Parameter Course $course diisi otomatis oleh route model binding.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Form koreksi. Nilai awal field berasal dari record yang sedang diedit.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Menyimpan koreksi.
     * Unique code mengabaikan record ini (lihat UpdateCourseRequest).
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return to_route('courses.show', $course)
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    /**
     * Menghapus satu Course. Dipanggil dari form POST + @method('DELETE').
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}
