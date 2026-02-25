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
