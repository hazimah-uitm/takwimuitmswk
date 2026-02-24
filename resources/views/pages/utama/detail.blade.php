@extends('layouts.frontend')

@section('content')
    <div class="wrapper-main">
        <div class="container py-4">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h2 class="fw-500 mb-0" style="font-size: 1.3rem;">TAKWIM UiTM CAWANGAN SARAWAK</h2>
                </div>

                <a href="{{ route('public.home') }}" class="btn btn-primary btn-sm">
                    &larr; Kembali
                </a>
            </div>

            <div class="row g-3">
                {{-- Maklumat Program --}}
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <strong>Maklumat Program</strong>
                            </div>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th width="35%">Nama Program</th>
                                    <td>{{ $event->nama_program ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Ringkasan Program</th>
                                    <td class="text-wrap">
                                        @if (!empty($event->catatan))
                                            {!! nl2br(e($event->catatan)) !!}
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Tarikh & Masa</th>
                                    <td>
                                        @php
                                            $mula = $event->mula_at
                                                ? \Carbon\Carbon::parse($event->mula_at)->format('d M Y, H:i')
                                                : '-';

                                            $tamat = $event->tamat_at
                                                ? \Carbon\Carbon::parse($event->tamat_at)->format('d M Y, H:i')
                                                : null;
                                        @endphp

                                        {{ $mula }}
                                        @if ($tamat)
                                            hingga {{ $tamat }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $event->lokasi ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Penganjur</th>
                                    <td>{{ $event->penganjur ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Peringkat</th>
                                    <td>{{ $event->peringkat ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Agensi Terlibat</th>
                                    <td>{{ $event->agensi_terlibat ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Pegawai Rujukan</th>
                                    <td>{{ $event->pegawai_rujukan ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Pautan</th>
                                    <td>
                                        @if (!empty($event->pautan))
                                            <a href="{{ $event->pautan }}" target="_blank" class="text-decoration-none">
                                                <i class="bx bx-link-external me-1"></i> Buka pautan
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr class="border-top">
                                    <th>Didaftarkan oleh</th>
                                    <td>{{ optional($event->creator)->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tarikh Didaftarkan</th>
                                    <td>{{ optional($event->created_at)->format('d/m/Y') ?? '-' }}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">

                            @php
                                // kalau relationship attachments wujud:
                                $attachments = method_exists($event, 'attachments')
                                    ? $event->attachments()->latest()->get()
                                    : collect();

                                $imageAttachments = $attachments->filter(function ($att) {
                                    $ext = strtolower(pathinfo($att->file_path, PATHINFO_EXTENSION));
                                    return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                });

                                $nonImageAttachments = $attachments->filter(function ($att) {
                                    $ext = strtolower(pathinfo($att->file_path, PATHINFO_EXTENSION));
                                    return !in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                });

                                $carouselId = 'carouselEventAtt' . $event->id;
                            @endphp

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <strong>Infografik / Aturcara / Poster Program</strong>
                            </div>

                            @if ($imageAttachments->count() > 0)
                                @if ($imageAttachments->count() == 1)
                                    @php $img = $imageAttachments->first(); @endphp
                                    <a href="{{ asset('public/storage/' . $img->file_path) }}" target="_blank"
                                        class="d-block text-decoration-none">
                                        <img src="{{ asset('public/storage/' . $img->file_path) }}"
                                            class="img-fluid rounded border" alt="Lampiran">
                                    </a>
                                @else
                                    <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner rounded border">
                                            @foreach ($imageAttachments as $idx => $img)
                                                <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                                    <a href="{{ asset('public/storage/' . $img->file_path) }}"
                                                        target="_blank" class="d-block">
                                                        <img src="{{ asset('public/storage/' . $img->file_path) }}"
                                                            class="d-block w-100"
                                                            style="max-height: 340px; object-fit: contain; background: #f8f9fa;"
                                                            alt="Lampiran {{ $idx + 1 }}">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>

                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-muted">Tiada lampiran imej</div>
                            @endif

                            @if ($nonImageAttachments->count() > 0)
                                <div class="mt-3">
                                    <div class="text-muted small mb-2">Fail lain</div>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($nonImageAttachments as $att)
                                            <a href="{{ asset('public/storage/' . $att->file_path) }}" target="_blank"
                                                class="text-decoration-none">
                                                <i class="bx bxs-file me-1"></i>
                                                {{ basename($att->file_path) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
