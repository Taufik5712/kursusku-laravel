import './bootstrap';
import 'bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

/**
 * Pertemuan 9 — jQuery Ajax: cek sisa kursi tanpa reload halaman.
 * Dipicu oleh event change pada <select id="course_id"> di halaman
 * resources/views/enrollments/create.blade.php.
 */
$(document).on('change', '#course_id', function () {
    const id = this.value;
    const $box = $('#availability');

    if (!id) {
        $box
            .removeClass('alert-success alert-danger')
            .addClass('alert-secondary')
            .text('Pilih kursus untuk melihat sisa kursi.');
        return;
    }

    $box
        .removeClass('alert-success alert-danger')
        .addClass('alert-secondary')
        .text('Memuat ketersediaan...');

    $.ajax({
        url: `/courses/${id}/availability`,
        method: 'GET',
        dataType: 'json',
        success(data) {
            $box
                .removeClass('alert-secondary alert-danger')
                .addClass('alert-success')
                .text(`${data.remaining} kursi tersisa untuk ${data.course}.`);
        },
        error() {
            $box
                .removeClass('alert-secondary alert-success')
                .addClass('alert-danger')
                .text('Gagal memuat ketersediaan kursus.');
        }
    });
});
