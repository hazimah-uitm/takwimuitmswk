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

        @media (min-width: 992px) {
            :root {
                --nav-h: 72px;
            }
        }

        /* ruang untuk elak content/alert berlaga dengan navbar fixed */
        /* body { margin: 0; padding-top: calc(var(--nav-h) + 8px); } */

        .custom-navbar {
            background: #392E6A;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
            z-index: 1040;
            /* pastikan sentiasa di atas */
        }

        .navbar-logo {
            height: 38px;
            width: auto;
        }

        .navbar-text-end {
            font-weight: 400;
            font-size: 1rem;
            color: #ffffff;
            white-space: nowrap;
        }

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
            --ungu-utama: #392E6A;
            --ungu-hover: #2f2558;

            --ungu-soft: rgba(57, 46, 106, .18);
        }

        /* bagi calendar boleh scroll kiri-kanan bila skrin kecil */
        #publicCalendar {
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* elak grid FullCalendar paksa mengecil sampai pecah */
        #publicCalendar .fc {
            min-width: 720px;
            /* adjust: 600/700/800 ikut selera */
        }

        /* Mobile: bagi toolbar jadi wrap (tak overflow) */
        @media (max-width: 576px) {
            #publicCalendar .fc .fc-toolbar {
                flex-wrap: wrap;
                gap: .5rem;
            }

            #publicCalendar .fc .fc-toolbar-chunk {
                display: flex;
                flex-wrap: wrap;
                gap: .25rem;
            }

            #publicCalendar .fc .fc-toolbar-title {
                width: 100%;
                text-align: center;
                margin: .25rem 0;
            }
        }

        /* ===== BUTTON TOOLBAR (SEMUA) ===== */
        #publicCalendar .fc .fc-button.fc-button-primary {
            background-color: var(--ungu-utama) !important;
            border-color: var(--ungu-utama) !important;
            color: #fff !important;
            box-shadow: none !important;
            text-transform: capitalize;
        }

        /* modal body scroll bila content panjang */
        .modal-body {
            max-height: calc(100vh - 200px);
            /* adjust ikut header/footer modal */
            overflow-y: auto;
        }

        /* optional: kalau gambar/poster besar, bagi responsive & tak overflow */
        .modal-body img {
            max-width: 100%;
            height: auto;
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

        /* ===== FULLCALENDAR TOOLBAR RESPONSIVE ===== */
        @media (max-width: 576px) {

            /* Toolbar jadi column */
            #publicCalendar .fc-header-toolbar {
                flex-direction: column;
                gap: .5rem;
            }

            /* Setiap chunk full width */
            #publicCalendar .fc-toolbar-chunk {
                width: 100%;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: .25rem;
            }

            /* Title bulan di tengah */
            #publicCalendar .fc-toolbar-title {
                font-size: 1rem;
                text-align: center;
                width: 100%;
                margin: .25rem 0;
            }

            /* Kecilkan sikit button */
            #publicCalendar .fc-button {
                padding: .25rem .5rem;
                font-size: .75rem;
            }

            /* Today button jangan terlalu besar */
            #publicCalendar .fc-today-button {
                font-size: .7rem;
            }
        }

        /* Besarkan title bulan */
        #publicCalendar .fc .fc-toolbar-title {
            font-size: 1.2rem !important;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            #publicCalendar .fc .fc-toolbar-title {
                font-size: 1.15rem !important;
            }
        }

        #publicCalendar {
            --fc-button-bg-color: #392E6A;
            --fc-button-border-color: #392E6A;

            --fc-button-hover-bg-color: #2f2558;
            --fc-button-hover-border-color: #2f2558;

            --fc-button-active-bg-color: #2f2558;
            --fc-button-active-border-color: #2f2558;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    {{-- <nav class="navbar navbar-expand-lg fixed-top custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.home') }}">UiTM CAWANGAN SARAWAK</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @guest
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-sm btn-primary text-uppercase d-flex align-items-center gap-1"
                                href="{{ route('login') }}">
                                <i class="bx bx-log-in"></i> Log Masuk Admin
                            </a>
                        </li>
                    @endguest

                    @hasanyrole('Superadmin|Admin')
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit"
                                    class="btn btn-sm btn-warning text-uppercase d-flex align-items-center gap-1">
                                    <i class="bx bx-log-out"></i> Log Keluar
                                </button>
                            </form>
                        </li>
                    @endhasanyrole
                </ul>
            </div>
        </div>
    </nav> --}}
    <nav class="navbar navbar-expand-lg fixed-top custom-navbar">
        <div class="container d-flex align-items-center justify-content-between">

            {{-- LOGO KIRI --}}
            <a href="{{ route('public.home') }}" class="navbar-brand">
                <img src="{{ asset('public/assets/images/putih.png') }}" class="navbar-logo" alt="Logo UiTM">
            </a>

            {{-- NAMA UITM KANAN --}}
            <div class="navbar-text-end d-none d-lg-block">
                UiTM Cawangan Sarawak
            </div>

            {{-- TOGGLER (mobile) --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>
    <!-- End Navbar -->

    {{-- PAGE CONTENT --}}
    @yield('content')

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
