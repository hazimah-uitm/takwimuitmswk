<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="semi-dark">

<head>
    @include('includes.head')
    <style>
        .event-img {
            width: 100%;
            height: 340px;
            /* SEMUA sama tinggi */
            object-fit: contain;
            /* cover = cantik & konsisten */
            background: #f8f9fa;
        }

        :root {
            --fc-purple: #392E6A;
            --fc-purple-weekend: #4e447e;
            --ungu-utama: #392E6A;
            --ungu-hover: #2f2558;

            --ungu-soft: rgba(57, 46, 106, .18);
        }

        /* bagi calendar boleh scroll kiri-kanan bila skrin kecil */
        #calendar {
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* elak grid FullCalendar paksa mengecil sampai pecah */
        #calendar .fc {
            min-width: 720px;
            /* adjust: 600/700/800 ikut selera */
        }

        /* Mobile: bagi toolbar jadi wrap (tak overflow) */
        @media (max-width: 576px) {
            #calendar .fc .fc-toolbar {
                flex-wrap: wrap;
                gap: .5rem;
            }

            #calendar .fc .fc-toolbar-chunk {
                display: flex;
                flex-wrap: wrap;
                gap: .25rem;
            }

            #calendar .fc .fc-toolbar-title {
                width: 100%;
                text-align: center;
                margin: .25rem 0;
            }
        }

        /* ===== BUTTON TOOLBAR (SEMUA) ===== */
        #calendar .fc .fc-button.fc-button-primary {
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

        #calendar .fc .fc-button.fc-button-primary:hover {
            background-color: var(--ungu-hover) !important;
            border-color: var(--ungu-hover) !important;
        }

        /* Button aktif (month/week/list yang dipilih) */
        #calendar .fc .fc-button.fc-button-primary.fc-button-active {
            background-color: var(--ungu-hover) !important;
            border-color: var(--ungu-hover) !important;
            color: #fff !important;
        }

        /* Button focus (bila klik) */
        #calendar .fc .fc-button.fc-button-primary:focus {
            box-shadow: 0 0 0 .2rem var(--ungu-soft) !important;
        }

        /* Button disabled (kadang today jadi disabled) */
        #calendar .fc .fc-button.fc-button-primary:disabled {
            background-color: rgba(57, 46, 106, .55) !important;
            border-color: rgba(57, 46, 106, .55) !important;
            color: #fff !important;
            opacity: 1 !important;
        }

        /* Icon arrow < > */
        #calendar .fc .fc-button .fc-icon {
            color: #fff !important;
        }

        /* ===============================
       HEADER HARI BIASA (MON–FRI)
       =============================== */
        #calendar .fc-col-header-cell {
            background-color: var(--fc-purple);
            border-color: var(--fc-purple);
        }

        /* ===============================
       HEADER WEEKEND (SAT & SUN)
       =============================== */
        #calendar th.fc-day-sat,
        #calendar th.fc-day-sun {
            background-color: var(--fc-purple-weekend);
            border-color: var(--fc-purple-weekend);
        }

        /* Teks nama hari */
        #calendar .fc-col-header-cell-cushion {
            color: #fff !important;
            font-weight: 500;
            text-decoration: none;
            padding: .45rem .25rem;
            display: inline-block;
        }

        /* ===== FULLCALENDAR TOOLBAR RESPONSIVE ===== */
        @media (max-width: 576px) {

            /* Toolbar jadi column */
            #calendar .fc-header-toolbar {
                flex-direction: column;
                gap: .5rem;
            }

            /* Setiap chunk full width */
            #calendar .fc-toolbar-chunk {
                width: 100%;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: .25rem;
            }

            /* Title bulan di tengah */
            #calendar .fc-toolbar-title {
                font-size: 1rem;
                text-align: center;
                width: 100%;
                margin: .25rem 0;
            }

            /* Kecilkan sikit button */
            #calendar .fc-button {
                padding: .25rem .5rem;
                font-size: .75rem;
            }

            /* Today button jangan terlalu besar */
            #calendar .fc-today-button {
                font-size: .7rem;
            }
        }

        /* Besarkan title bulan */
        #calendar .fc .fc-toolbar-title {
            font-size: 1.2rem !important;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            #calendar .fc .fc-toolbar-title {
                font-size: 1.15rem !important;
            }
        }

        #calendar {
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
    <!--wrapper-->
    <div class="wrapper">

        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            @include('includes.sidebar')
        </div>
        <!--end sidebar wrapper -->

        <!--start header -->
        <header>
            @include('includes.header')
        </header>
        <!--end header -->

        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--wrapper-->
                @if (session('success'))
                    <div id="floating-success-message" class="position-fixed top-0 start-50 translate-middle-x p-3"
                        style="z-index: 11; display: none; animation: fadeInUp 0.5s ease-out;">
                        <div class="alert alert-success alert-dismissible fade show bg-light bg-opacity-75"
                            role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>

                    <!-- JavaScript to show the message after the page is loaded -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var floatingMessage = document.getElementById('floating-success-message');
                            floatingMessage.style.display = 'block';
                            setTimeout(function() {
                                floatingMessage.style.display = 'none';
                            }, 4500); // Adjust the timeout (in milliseconds) based on how long you want the message to be visible
                        });
                    </script>
                @endif
                @yield('content')
            </div>
        </div>
        <!--end page wrapper -->

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

        <footer class="page-footer">
            @include('includes.footer')
        </footer>
    </div>
    <!--end wrapper-->

    <!-- Bootstrap JS -->
    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!--plugins-->
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('public/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/index.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the toggle icon element
            var toggleIcon = document.getElementById('toggle-icon');

            // Add a click event listener to the toggle icon
            toggleIcon.addEventListener('click', function() {
                // Toggle the class for the arrow icon
                var iconElement = toggleIcon.querySelector('i');
                iconElement.classList.toggle('bx-arrow-to-left');
                iconElement.classList.toggle('bx-arrow-to-right');
            });
        });
    </script>
    <script>
        // Get the current year
        var currentYear = new Date().getFullYear();

        // Update the content of the element with the current year
        document.getElementById("copyright").innerHTML = ' © ' + currentYear +
            ' <a href="https://sarawak.uitm.edu.my/" target="_blank">UiTM Cawangan Sarawak</a>.';
    </script>
    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
    </script>
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        function selectAllGroupCheckboxes(selectAllCheckbox) {
            const group = selectAllCheckbox.closest('.col-md-6');
            const checkboxes = group.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            // Uncheck the Deselect All checkbox in the same group
            const deselectAll = group.querySelector('.deselect-all');
            if (deselectAll) {
                deselectAll.checked = false;
            }
        }

        function deselectAllGroupCheckboxes(deselectAllCheckbox) {
            const group = deselectAllCheckbox.closest('.col-md-6');
            const checkboxes = group.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            // Uncheck the Select All checkbox in the same group
            const selectAll = group.querySelector('.select-all');
            if (selectAll) {
                selectAll.checked = false;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    {{-- FullCalendar JS (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    {{-- date time --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>

</html>
