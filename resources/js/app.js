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

// Live Search, Filter & Pagination Ajax pada Halaman Course Index (Progressive Enhancement)
$(function () {
    const $filterForm = $('#course-filter-form');
    const $results = $('#course-results');
    const $feedback = $('#course-search-feedback');

    if (!$filterForm.length || !$results.length) {
        return;
    }

    let searchTimer = null;

    function fetchCourses(url, pushHistory = true) {
        $feedback
            .removeClass('d-none text-danger')
            .addClass('text-muted')
            .text('Memuat data kursus...');

        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success(html) {
                $results.html(html);
                $feedback.addClass('d-none');

                if (pushHistory && window.history && window.history.pushState) {
                    window.history.pushState({ path: url }, '', url);
                }
            },
            error() {
                $feedback
                    .removeClass('d-none text-muted')
                    .addClass('text-danger')
                    .text('Gagal memuat hasil pencarian. Silakan gunakan tombol Cari.');
            }
        });
    }

    function buildFilterUrl() {
        const baseUrl = $filterForm.attr('action');
        const params = new URLSearchParams();
        const q = String($('#q').val() ?? '').trim();
        const status = $('#status').val() || '';

        if (q !== '') {
            params.set('q', q);
        }
        if (status !== '') {
            params.set('status', status);
        }

        const queryString = params.toString();
        return queryString ? `${baseUrl}?${queryString}` : baseUrl;
    }

    $('#q').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            fetchCourses(buildFilterUrl());
        }, 300);
    });

    $('#status').on('change', function () {
        clearTimeout(searchTimer);
        fetchCourses(buildFilterUrl());
    });

    $filterForm.on('submit', function (event) {
        event.preventDefault();
        clearTimeout(searchTimer);
        fetchCourses(buildFilterUrl());
    });

    $results.on('click', '.pagination a', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        if (url) {
            fetchCourses(url);
        }
    });
});

// Toggle Tampil/Sembunyikan Password
$(document).on('click', '.toggle-password', function () {
    const targetSelector = $(this).data('target');
    const $input = $(targetSelector);

    if (!$input.length) {
        return;
    }

    const isPassword = $input.attr('type') === 'password';
    $input.attr('type', isPassword ? 'text' : 'password');
    $(this).text(isPassword ? 'Sembunyikan' : 'Tampilkan');
});
