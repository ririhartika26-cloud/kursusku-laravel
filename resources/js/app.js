import './bootstrap';
import 'bootstrap';
import $ from 'jquery';

window.$ = window.jQuery = $;

$(document).on('change', '#course_id', function () {
    const id = this.value;

    if (!id) {
        $('#availability')
            .removeClass('alert-success alert-danger')
            .addClass('alert-secondary')
            .text('Pilih kursus untuk melihat informasi kuota.');
        return;
    }

    $('#availability')
        .removeClass('alert-success alert-danger')
        .addClass('alert-secondary')
        .text('Memuat ketersediaan...');

    $.ajax({
        url: `/availability/${id}`,
        method: 'GET',
        dataType: 'json',

        success(data) {
            $('#availability')
                .removeClass('alert-secondary alert-danger')
                .addClass('alert-success')
                .text(
                    `Kuota kursus: ${data.quota} peserta (${data.code} - ${data.name}, Status: ${data.status}).`
                );
        },

        error() {
            $('#availability')
                .removeClass('alert-secondary alert-success')
                .addClass('alert-danger')
                .text('Gagal memuat ketersediaan kursus.');
        }
    });
});
