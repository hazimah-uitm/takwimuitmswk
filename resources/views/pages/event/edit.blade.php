@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Takwim</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event') }}">Senarai Program</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $str_mode }} Program</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <h6 class="mb-0 text-uppercase">{{ $str_mode }} Program</h6>
    <hr />

    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{ $save_route }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <h6 class="text-uppercase text-secondary mb-3 d-flex align-items-center gap-2">
                    <i class="bx bx-calendar-event"></i>
                    Maklumat Program
                </h6>

                {{-- Nama Program --}}
                <div class="mb-3">
                    <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                    <input type="text" class="form-control {{ $errors->has('nama_program') ? 'is-invalid' : '' }}"
                        id="nama_program" name="nama_program"
                        value="{{ old('nama_program') ?? ($event->nama_program ?? '') }}" autocomplete="off">
                    @if ($errors->has('nama_program'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('nama_program') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="row">
                    {{-- Tarikh & Masa Mula --}}
                    <div class="col-md-6 mb-3">
                        <label for="mula_at" class="form-label">
                            Tarikh & Masa Mula <span class="text-danger">*</span>
                        </label>

                        <input type="text" class="form-control {{ $errors->has('mula_at') ? 'is-invalid' : '' }}"
                            id="mula_at" name="mula_at"
                            value="{{ old('mula_at') ?? (!empty($event->mula_at) ? $event->mula_at->format('Y-m-d H:i') : '') }}"
                            autocomplete="off">

                        @if ($errors->has('mula_at'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('mula_at') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Tarikh & Masa Tamat --}}
                    <div class="col-md-6 mb-3">
                        <label for="tamat_at" class="form-label">
                            Tarikh & Masa Tamat (Jika ada)
                        </label>

                        <input type="text" class="form-control {{ $errors->has('tamat_at') ? 'is-invalid' : '' }}"
                            id="tamat_at" name="tamat_at"
                            value="{{ old('tamat_at') ?? (!empty($event->tamat_at) ? $event->tamat_at->format('Y-m-d H:i') : '') }}"
                            autocomplete="off">

                        @if ($errors->has('tamat_at'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('tamat_at') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    {{-- Lokasi --}}
                    <div class="col-md-6 mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control {{ $errors->has('lokasi') ? 'is-invalid' : '' }}"
                            id="lokasi" name="lokasi" value="{{ old('lokasi') ?? ($event->lokasi ?? '') }}"
                            autocomplete="off">
                        @if ($errors->has('lokasi'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('lokasi') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Penganjur --}}
                    <div class="col-md-6 mb-3">
                        <label for="penganjur" class="form-label">Penganjur</label>
                        <input type="text" class="form-control {{ $errors->has('penganjur') ? 'is-invalid' : '' }}"
                            id="penganjur" name="penganjur" value="{{ old('penganjur') ?? ($event->penganjur ?? '') }}"
                            autocomplete="off">
                        @if ($errors->has('penganjur'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('penganjur') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    {{-- Peringkat --}}
                    <div class="col-md-6 mb-3">
                        <label for="peringkat" class="form-label">Peringkat</label>
                        <select class="form-select {{ $errors->has('peringkat') ? 'is-invalid' : '' }}" id="peringkat"
                            name="peringkat">
                            <option value="">-- Pilih --</option>
                            @php
                                $peringkatOptions = ['Kampus', 'Cawangan', 'Universiti', 'Kebangsaan', 'Antarabangsa'];
                                $selectedPeringkat = old('peringkat') ?? ($event->peringkat ?? '');
                            @endphp
                            @foreach ($peringkatOptions as $opt)
                                <option value="{{ $opt }}" {{ $selectedPeringkat == $opt ? 'selected' : '' }}>
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('peringkat'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('peringkat') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Pegawai Rujukan --}}
                    <div class="col-md-6 mb-3">
                        <label for="pegawai_rujukan" class="form-label">Pegawai Rujukan</label>
                        <input type="text"
                            class="form-control {{ $errors->has('pegawai_rujukan') ? 'is-invalid' : '' }}"
                            id="pegawai_rujukan" name="pegawai_rujukan"
                            value="{{ old('pegawai_rujukan') ?? ($event->pegawai_rujukan ?? '') }}" autocomplete="off">
                        @if ($errors->has('pegawai_rujukan'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('pegawai_rujukan') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Agensi Terlibat --}}
                <div class="mb-3">
                    <label for="agensi_terlibat" class="form-label">Agensi Terlibat (Jika ada)</label>
                    <textarea class="form-control {{ $errors->has('agensi_terlibat') ? 'is-invalid' : '' }}" id="agensi_terlibat"
                        name="agensi_terlibat" rows="2">{{ old('agensi_terlibat') ?? ($event->agensi_terlibat ?? '') }}</textarea>
                    @if ($errors->has('agensi_terlibat'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('agensi_terlibat') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <h6 class="text-uppercase text-secondary mb-3 d-flex align-items-center gap-2 mt-4">
                    <i class="bx bx-info-circle"></i>
                    Maklumat Ringkas
                </h6>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Deskripsi Program (Jika ada)</label>
                    <textarea class="form-control {{ $errors->has('catatan') ? 'is-invalid' : '' }}" id="catatan" name="catatan"
                        rows="4">{{ old('catatan') ?? ($event->catatan ?? '') }}</textarea>
                    @if ($errors->has('catatan'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('catatan') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Pautan --}}
                <div class="mb-3">
                    <label for="pautan" class="form-label">Pautan (Jika ada)</label>
                    <input type="url" class="form-control {{ $errors->has('pautan') ? 'is-invalid' : '' }}"
                        id="pautan" name="pautan" value="{{ old('pautan') ?? ($event->pautan ?? '') }}"
                        autocomplete="off">
                    @if ($errors->has('pautan'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('pautan') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Lampiran baru --}}
                <div class="mb-3">
                    <label for="attachments" class="form-label">Tambah Lampiran (Jika ada)</label>
                    <input type="file" class="form-control {{ $errors->has('attachments') ? 'is-invalid' : '' }}"
                        id="attachments" name="attachments[]" multiple>
                    @if ($errors->has('attachments'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('attachments') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if ($errors->has('attachments.*'))
                        <div class="text-danger small mt-2">
                            @foreach ($errors->get('attachments.*') as $errorGroup)
                                @foreach ($errorGroup as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            @endforeach
                        </div>
                    @endif



                    <small class="text-muted">Contoh: Poster / Aturcara / Infografik Program. <br> Format: JPG atau PNG
                        sahaja. Maksimum 5MB setiap gambar.</small>

                    {{-- Lampiran sedia ada --}}
                    @php
                        // kalau controller tak eager load pun ok
                        $existingAttachments = $event->attachments()->latest()->get();
                    @endphp

                    @if (count($existingAttachments) > 0)
                        <div class="row mt-2">
                            @foreach ($existingAttachments as $att)
                                <div class="col-md-3 mb-3">
                                    <div class="border rounded p-2 position-relative">

                                        <a href="{{ asset('public/storage/' . $att->file_path) }}" target="_blank">
                                            <img src="{{ asset('public/storage/' . $att->file_path) }}"
                                                class="img-fluid rounded" alt="Lampiran">
                                        </a>

                                        <button type="button" class="btn btn-sm btn-danger position-absolute"
                                            style="top:8px; right:8px;" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttachmentModal" data-attach-id="{{ $att->id }}"
                                            data-attach-img="{{ asset('public/storage/' . $att->file_path) }}">
                                            <i class="bx bx-trash"></i>
                                        </button>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">{{ $str_mode }}</button>
                <a href="{{ route('event') }}" class="btn btn-secondary ms-1">Kembali</a>
            </form>
        </div>
    </div>

    <!-- Delete Attachment Modal -->
    <div class="modal fade" id="deleteAttachmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Padam Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">Anda pasti padam lampiran ini?</p>

                    <img id="delPreviewImg" src="" class="img-fluid rounded border" alt="Preview">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                    <form id="deleteAttachmentForm" method="POST" action="">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Ya, Padam</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('deleteAttachmentModal');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var attachId = button.getAttribute('data-attach-id');
                var imgSrc = button.getAttribute('data-attach-img');

                // set preview
                var preview = document.getElementById('delPreviewImg');
                if (preview) preview.src = imgSrc;

                // set action form delete
                var form = document.getElementById('deleteAttachmentForm');
                if (form) {
                    // route: event.attachment.delete
                    form.action = "{{ url('/event/attachment') }}/" + attachId;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mulaEl = document.getElementById('mula_at');
            const tamatEl = document.getElementById('tamat_at');

            const tamatPicker = flatpickr(tamatEl, {
                enableTime: true,
                time_24hr: false,
                minuteIncrement: 5,
                dateFormat: "Y-m-d H:i", // backend
                altInput: true,
                altFormat: "d M Y h:i K", // display
                allowInput: false,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.altInput.setAttribute(
                        'placeholder',
                        'DD MMM YYYY HH:MM AM/PM'
                    );
                },
                defaultDate: tamatEl.value ? tamatEl.value : null
            });

            const mulaPicker = flatpickr(mulaEl, {
                enableTime: true,
                time_24hr: false,
                minuteIncrement: 5,
                dateFormat: "Y-m-d H:i",
                altInput: true,
                altFormat: "d M Y h:i K",
                allowInput: false,
                defaultDate: mulaEl.value ? mulaEl.value : null,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.altInput.setAttribute(
                        'placeholder',
                        'DD MMM YYYY HH:MM AM/PM'
                    );
                },
                onChange: function(selectedDates) {
                    const start = selectedDates[0] ?? null;

                    if (!start) {
                        tamatPicker.clear();
                        tamatPicker.set('minDate', null);
                        return;
                    }

                    tamatPicker.set('minDate', start);

                    const end = tamatPicker.selectedDates[0] ?? null;
                    if (end && end < start) tamatPicker.clear();
                }
            });

            const startInit = mulaPicker.selectedDates[0] ?? null;
            if (startInit) {
                tamatPicker.set('minDate', startInit);

                const endInit = tamatPicker.selectedDates[0] ?? null;
                if (endInit && endInit < startInit) {
                    tamatPicker.clear();
                }
            }
        });
    </script>
@endsection
