@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Takwim</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('event') }}">Senarai Program</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Maklumat Program
                    </li>
                </ol>
            </nav>
        </div>

        <div class="ms-auto">
            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-primary mt-2 mt-lg-0">
                <i class="bx bxs-edit me-1"></i> Kemaskini Maklumat
            </a>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <h6 class="mb-0 text-uppercase">Maklumat Program</h6>
    <hr />

    <div class="row">
        {{-- Maklumat Program (ikut form: yang utama) --}}
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-body">

                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="35%">Nama Program</th>
                            <td>{{ $event->nama_program ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>
                                Ringkasan Program
                            </th>
                            <td class="text-wrap">
                                @if (!empty($event->catatan))
                                    {{ $event->catatan }}
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tarikh & Masa</th>
                            <td>
                                @php
                                    $mula = $event->mula_at ? $event->mula_at->format('d M Y, H:i') : '-';
                                    $tamat = $event->tamat_at ? $event->tamat_at->format('d M Y, H:i') : null;
                                @endphp
                                {{ $mula }} @if ($tamat)
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
                                        <i class="bx bx-link-external me-1"></i>
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

        {{-- Maklumat Ringkas (ikut form: deskripsi + pautan + lampiran) --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">

                    {{-- Lampiran (preview imej + carousel) --}}
                    @php
                        $attachments = $event->attachments()->latest()->get();

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
                                            <a href="{{ asset('public/storage/' . $img->file_path) }}" target="_blank"
                                                class="d-block">
                                                <img src="{{ asset('public/storage/' . $img->file_path) }}"
                                                    class="d-block w-100"
                                                    style="max-height: 340px; object-fit: contain; background: #f8f9fa;"
                                                    alt="Lampiran {{ $idx + 1 }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @endif
                    @else
                        <div>Tiada lampiran imej</div>
                    @endif

                    {{-- Kalau ada PDF / selain imej: bagi link --}}
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
@endsection
