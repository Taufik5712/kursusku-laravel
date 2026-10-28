# Diagram Request Lifecycle — Milestone 7

```
1. Browser                2. Route                3. Controller
   meminta GET /    ──▶      routes/web.php   ──▶     HomeController@index
                              mencocokkan '/'           menyiapkan $siteName
                              ke HomeController          dan $featured (6 kursus)
                                                                │
                                                                ▼
5. Browser              4. Blade View          
   menerima HTML   ◀──     home.blade.php
   dan menampilkannya       merender {{ }} dan @foreach
                            menjadi HTML akhir
```

**Penjelasan singkat:**
Request GET `/` diterima oleh `routes/web.php`, yang mencocokkan URL ke
`HomeController@index`. Controller menyiapkan data (`$siteName`, `$featured`)
lalu memanggil `view('home', compact(...))`. Blade merender `home.blade.php`
menjadi HTML dengan mengganti `{{ $siteName }}` dan melakukan `@foreach` atas
`$featured`. HTML tersebut dikirim kembali ke browser sebagai response.

*(Ganti file ini dengan screenshot/gambar diagram Anda sendiri sebelum
dikumpulkan — boleh digambar tangan, Excalidraw, atau draw.io.)*
