@extends('layouts.frontend')

@section('content')
    <div class="wrapper-main">
        <div class="container py-4">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <h2 class="fw-500 mb-0" style="font-size: 1.3rem;">TAKWIM UiTM CAWANGAN SARAWAK</h2>
            </div>

            <div class="text-muted small mb-3">
                Klik pada nama program dalam kalendar untuk melihat maklumat lanjut.
            </div>

            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="publicCalendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Maklumat Program -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">Maklumat Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="eventModalBody">
                        <div class="text-muted">Memuatkan...</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" id="eventModalDetailBtn" class="btn btn-primary">
                        Lihat Penuh
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('publicCalendar');

            function esc(str) {
                if (!str) return '';
                return ('' + str).replace(/[&<>"']/g, function(m) {
                    return ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [m]);
                });
            }

            function nl2brSafe(str) {
                return esc(str).replace(/\n/g, '<br>');
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                navLinks: true,
                nowIndicator: true,
                dayMaxEvents: true,
                displayEventTime: false,
                events: "{{ route('public.events') }}",

                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    var eventId = info.event.id;
                    if (!eventId) return;

                    // Reset modal
                    document.getElementById('eventModalTitle').innerText = 'Maklumat Program';
                    document.getElementById('eventModalBody').innerHTML =
                        '<div class="text-muted">Memuatkan...</div>';
                    document.getElementById('eventModalDetailBtn').setAttribute('href', '#');

                    // Show modal
                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                    fetch("{{ url('/utama/event-modal') }}/" + eventId)
                        .then(res => res.json())
                        .then(function(data) {
                            document.getElementById('eventModalTitle').innerText = data
                                .nama_program || 'Maklumat Program';
                            document.getElementById('eventModalDetailBtn').setAttribute('href', data
                                .detail_url || '#');

                            // tarikh
                            var tarikh = '-';
                            if (data.mula_at && data.tamat_at) tarikh = esc(data.mula_at) +
                                ' hingga ' + esc(data.tamat_at);
                            else if (data.mula_at) tarikh = esc(data.mula_at);

                            // ringkasan
                            var catatan = data.catatan ? nl2brSafe(data.catatan) : '-';

                            // pautan
                            var pautanHtml = '-';
                            if (data.pautan) {
                                pautanHtml =
                                    '<a href="' + esc(data.pautan) +
                                    '" target="_blank" class="text-decoration-none">' +
                                    '<i class="bx bx-link-external me-1"></i> Buka pautan' +
                                    '</a>';
                            }

                            // attachments split
                            var atts = Array.isArray(data.attachments) ? data.attachments : [];
                            var imgAtts = atts.filter(a => a.is_image);
                            var otherAtts = atts.filter(a => !a.is_image);

                            // image carousel html
                            var lampiranHtml = '';
                            var carouselId = 'modalCarouselEvent' + eventId;

                            if (imgAtts.length > 0) {
                                if (imgAtts.length === 1) {
                                    var img = imgAtts[0];
                                    lampiranHtml =
                                        '<a href="' + esc(img.url) +
                                        '" target="_blank" class="d-block text-decoration-none">' +
                                        '<img src="' + esc(img.url) +
                                        '" class="img-fluid rounded border" alt="Lampiran">' +
                                        '</a>';
                                } else {
                                    var indicators = '';
                                    var slides = '';

                                    imgAtts.forEach(function(img, idx) {
                                        indicators +=
                                            '<button type="button" data-bs-target="#' +
                                            carouselId + '" data-bs-slide-to="' + idx +
                                            '" ' +
                                            (idx === 0 ?
                                                'class="active" aria-current="true"' : '') +
                                            ' aria-label="Slide ' + (idx + 1) +
                                            '"></button>';

                                        slides +=
                                            '<div class="carousel-item ' + (idx === 0 ?
                                                'active' : '') + '">' +
                                            '<a href="' + esc(img.url) +
                                            '" target="_blank" class="d-block">' +
                                            '<img src="' + esc(img.url) +
                                            '" class="d-block w-100" ' +
                                            'style="max-height: 360px; object-fit: contain; background:#f8f9fa;" ' +
                                            'alt="Lampiran ' + (idx + 1) + '">' +
                                            '</a>' +
                                            '</div>';
                                    });

                                    lampiranHtml =
                                        '<div id="' + carouselId +
                                        '" class="carousel slide" data-bs-ride="carousel">' +
                                        '<div class="carousel-indicators">' + indicators +
                                        '</div>' +
                                        '<div class="carousel-inner rounded border">' + slides +
                                        '</div>' +
                                        '<button class="carousel-control-prev" type="button" data-bs-target="#' +
                                        carouselId + '" data-bs-slide="prev">' +
                                        '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
                                        '<span class="visually-hidden">Previous</span>' +
                                        '</button>' +
                                        '<button class="carousel-control-next" type="button" data-bs-target="#' +
                                        carouselId + '" data-bs-slide="next">' +
                                        '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
                                        '<span class="visually-hidden">Next</span>' +
                                        '</button>' +
                                        '</div>';
                                }
                            } else {
                                lampiranHtml = '<div class="text-muted">Tiada lampiran imej</div>';
                            }

                            // other files html
                            var otherHtml = '';
                            if (otherAtts.length > 0) {
                                otherHtml += '<div class="mt-3">';
                                otherHtml += '<div class="text-muted small mb-2">Fail lain</div>';
                                otherHtml += '<div class="d-flex flex-column gap-2">';
                                otherAtts.forEach(function(f) {
                                    otherHtml +=
                                        '<a href="' + esc(f.url) +
                                        '" target="_blank" class="text-decoration-none">' +
                                        '<i class="bx bxs-file me-1"></i> ' + esc(f
                                            .file_name || 'Fail') +
                                        '</a>';
                                });
                                otherHtml += '</div></div>';
                            }

                            // final modal html (2 column dalam modal)
                            var html =
                                '<div class="row g-3">' +

                                '<div class="col-lg-7">' +
                                '<table class="table table-borderless table-sm mb-0">' +
                                '<tr><th style="width:170px;">Nama Program</th><td>' + esc(data
                                    .nama_program || '-') + '</td></tr>' +
                                '<tr><th>Ringkasan Program</th><td class="text-wrap">' + catatan +
                                '</td></tr>' +
                                '<tr><th>Tarikh & Masa</th><td>' + tarikh + '</td></tr>' +
                                '<tr><th>Lokasi</th><td>' + esc(data.lokasi || '-') + '</td></tr>' +
                                '<tr><th>Penganjur</th><td>' + esc(data.penganjur || '-') +
                                '</td></tr>' +
                                '<tr><th>Peringkat</th><td>' + esc(data.peringkat || '-') +
                                '</td></tr>' +
                                '<tr><th>Agensi Terlibat</th><td>' + esc(data.agensi_terlibat ||
                                    '-') + '</td></tr>' +
                                '<tr><th>Pegawai Rujukan</th><td>' + esc(data.pegawai_rujukan ||
                                    '-') + '</td></tr>' +
                                '<tr><th>Pautan</th><td>' + pautanHtml + '</td></tr>' +
                                '<tr><th>Didaftarkan oleh</th><td>' + esc(data
                                    .creator || '-') + '</td></tr>' +
                                '<tr><th>Tarikh Didaftarkan</th><td>' + esc(data.created_at ||
                                    '-') + '</td></tr>' +
                                '</table>' +
                                '</div>' +

                                '<div class="col-lg-5">' +
                                '<div class="mb-2 d-flex align-items-center justify-content-between">' +
                                '<strong>Infografik / Aturcara / Poster Program</strong>' +
                                '<span class="text-muted small">' + esc(atts.length) +
                                ' fail</span>' +
                                '</div>' +
                                lampiranHtml +
                                otherHtml +
                                '</div>' +

                                '</div>';

                            document.getElementById('eventModalBody').innerHTML = html;
                        })
                        .catch(function() {
                            document.getElementById('eventModalBody').innerHTML =
                                '<div class="text-danger">Gagal memuatkan maklumat program.</div>';
                        });
                }
            });

            calendar.render();
        });
    </script>
@endsection
