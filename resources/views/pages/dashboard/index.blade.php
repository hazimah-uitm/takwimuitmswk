@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h5 class="mb-0">TAKWIM UiTM CAWANGAN SARAWAK</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
                <small class="text-muted fst-italic">*Sila klik program untuk maklumat lanjut. Tarikh dan masa program tertakluk pada pindaan.</small>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                firstDay: 1, // Isnin
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },

                displayEventTime: false,
                
                // tarik data dari controller
                events: '{{ route('dashboard.events') }}',

                // bila klik event, ikut url yang kita set (ke event.view)
                eventClick: function(info) {
                    // default FullCalendar akan navigate jika ada url,
                    // tapi kita pastikan behavior konsisten
                    if (info.event.url) {
                        info.jsEvent.preventDefault();
                        window.location.href = info.event.url;
                    }
                }
            });

            calendar.render();
        });
    </script>
@endsection
