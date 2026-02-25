<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('public/assets/images/uitm-favicon.png') }}" type="image/png" />
    <link href="{{ asset('public/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('public/assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet">
    {{-- Tom Select CSS + JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css">

    <title>{{ config('app.name', 'Takwim UiTM Cawangan Sarawak') }}</title>
    <style>
        .fc .fc-toolbar-title {
            font-size: 1.05rem;
        }

        /* tinggi anggaran navbar */
        :root {
            --nav-h: 64px;
        }

        html,
        body {
            background: #ffffff !important;
            margin: 0;
            padding: 0;
        }

        @media (min-width: 992px) {
            :root {
                --nav-h: 72px;
            }
        }

        :root {
            --fc-purple: #392E6A;
            --fc-purple-weekend: #4e447e;
            --ungu-soft: rgba(57, 46, 106, .18);
        }

        /* ===== BUTTON TOOLBAR (SEMUA) ===== */
        #publicCalendar .fc .fc-button.fc-button-primary {
            background-color: var(--ungu-utama) !important;
            border-color: var(--ungu-utama) !important;
            color: #fff !important;
            box-shadow: none !important;
            text-transform: capitalize;
        }

        #publicCalendar .fc .fc-button.fc-button-primary:hover {
            background-color: var(--ungu-hover) !important;
            border-color: var(--ungu-hover) !important;
        }

        /* Button aktif (month/week/list yang dipilih) */
        #publicCalendar .fc .fc-button.fc-button-primary.fc-button-active {
            background-color: var(--ungu-hover) !important;
            border-color: var(--ungu-hover) !important;
            color: #fff !important;
        }

        /* Button focus (bila klik) */
        #publicCalendar .fc .fc-button.fc-button-primary:focus {
            box-shadow: 0 0 0 .2rem var(--ungu-soft) !important;
        }

        /* Button disabled (kadang today jadi disabled) */
        #publicCalendar .fc .fc-button.fc-button-primary:disabled {
            background-color: rgba(57, 46, 106, .55) !important;
            border-color: rgba(57, 46, 106, .55) !important;
            color: #fff !important;
            opacity: 1 !important;
        }

        /* Icon arrow < > */
        #publicCalendar .fc .fc-button .fc-icon {
            color: #fff !important;
        }

        /* ===============================
       HEADER HARI BIASA (MON–FRI)
       =============================== */
        #publicCalendar .fc-col-header-cell {
            background-color: var(--fc-purple);
            border-color: var(--fc-purple);
        }

        /* ===============================
       HEADER WEEKEND (SAT & SUN)
       =============================== */
        #publicCalendar th.fc-day-sat,
        #publicCalendar th.fc-day-sun {
            background-color: var(--fc-purple-weekend);
            border-color: var(--fc-purple-weekend);
        }

        /* Teks nama hari */
        #publicCalendar .fc-col-header-cell-cushion {
            color: #fff !important;
            font-weight: 500;
            text-decoration: none;
            padding: .45rem .25rem;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container py-2 mt-3">
        <div id="publicCalendar"></div>
        <small class="text-muted fst-italic">*Sila klik program untuk maklumat lanjut. Tarikh dan masa program tertakluk pada pindaan.</small>
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
                    <a href="#" id="eventModalDetailBtn" class="btn btn-primary" target="_blank">
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
    <!-- Scripts -->
    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
</body>

</html>
