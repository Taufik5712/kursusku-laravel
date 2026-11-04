<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
     * Menyimpan kursus baru ke database.
     *
     * Validasi masih diletakkan di controller (bukan Form Request) agar
     * alur Milestone 10 mudah dipahami — refactor dilakukan pada tahap
     * lanjutan sesuai catatan panduan.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => ['required', 'max:20', 'unique:courses,code'],
            'name'        => ['required', 'max:120'],
            'description' => ['nullable', 'string'],
            'fee'         => ['required', 'integer', 'min:0'],
            'quota'       => ['required', 'integer', 'min:1', 'max:500'],
            'start_date'  => ['required', 'date'],
            'status'      => ['required', 'in:draft,open,closed'],
        ]);

        Course::create($data);

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    /**
     * show(), edit(), update(), destroy() belum diimplementasikan.
     * Route::resource tetap mendaftarkan semuanya; bagian ini
     * dilengkapi pada pertemuan berikutnya (Update/Delete).
     */
}
