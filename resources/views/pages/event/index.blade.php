@extends('layouts.master')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Takwim</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Senarai Program</li>
                </ol>
            </nav>
        </div>

        <div class="ms-auto">
            <a href="{{ route('event.trash') }}">
                <button type="button" class="btn btn-primary mt-2 mt-lg-0">Senarai Rekod Dipadam</button>
            </a>
        </div>
    </div>
    <!--end breadcrumb-->

    <h6 class="mb-0 text-uppercase">Senarai Program</h6>
    <hr />

    <div class="card">
        <div class="card-body">

            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <form action="{{ route('event.search') }}" method="GET" id="searchForm"
                        class="d-lg-flex align-items-center gap-3">
                        <div class="input-group">
                            <input type="text" class="form-control rounded" placeholder="Carian..." name="search"
                                value="{{ request('search') }}" id="searchInput">

                            <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">

                            <button type="submit" class="btn btn-primary ms-1 rounded" id="searchButton">
                                <i class="bx bx-search"></i>
                            </button>

                            <button type="button" class="btn btn-secondary ms-1 rounded" id="resetButton">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>

                <div class="ms-auto">
                    <a href="{{ route('event.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i> Tambah Program
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Program</th>
                            <th>Tarikh & Masa</th>
                            <th>Lokasi</th>
                            <th>Penganjur</th>
                            <th>Peringkat</th>
                            <th>Pegawai Rujukan</th>
                            <th>Pautan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($eventList) > 0)
                            @foreach ($eventList as $event)
                                <tr>
                                    <td>
                                        {{ ($eventList->currentPage() - 1) * $eventList->perPage() + $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $event->nama_program ?? '-' }}
                                    </td>

                                    <td class="text-nowrap">
                                        @php
                                            $mula = $event->mula_at ? $event->mula_at->format('d M Y, h:i A') : '-';
                                            $tamat = $event->tamat_at ? $event->tamat_at->format('d M Y, h:i A') : null;
                                        @endphp

                                        {{ $mula }}
                                        @if ($tamat)
                                            – {{ $tamat }}
                                        @endif
                                    </td>

                                    <td>{{ $event->lokasi ?? '-' }}</td>
                                    <td>{{ $event->penganjur ?? '-' }}</td>
                                    <td>{{ $event->peringkat ?? '-' }}</td>
                                    <td>{{ $event->pegawai_rujukan ?? '-' }}</td>
                                    <td class="text-center">
                                        @if (!empty($event->pautan))
                                            <a href="{{ $event->pautan }}" target="_blank" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Buka pautan">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('event.show', $event->id) }}" class="btn btn-primary btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Papar">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kemaskini">
                                            <i class="bx bxs-edit"></i>
                                        </a>

                                        <a type="button" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-title="Padam">
                                            <span class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $event->id }}">
                                                <i class="bx bx-trash"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9">Tiada rekod</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <span class="mr-2 mx-1">Jumlah rekod per halaman</span>
                    <form action="{{ route('event.search') }}" method="GET" id="perPageForm"
                        class="d-flex align-items-center">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="perPage" id="perPage" class="form-select form-select-sm"
                            onchange="document.getElementById('perPageForm').submit()">
                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('perPage') == '20' ? 'selected' : '' }}>20</option>
                            <option value="30" {{ request('perPage') == '30' ? 'selected' : '' }}>30</option>
                        </select>
                    </form>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <span class="mx-2 mt-2 small text-muted">
                        Menunjukkan {{ $eventList->firstItem() }} hingga {{ $eventList->lastItem() }} daripada
                        {{ $eventList->total() }} rekod
                    </span>
                    <div class="pagination-wrapper">
                        {{ $eventList->appends([
                                'search' => request('search'),
                                'perPage' => request('perPage', 10),
                            ])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($eventList as $event)
        <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Pengesahan Padam Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Adakah anda pasti ingin memadam program ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <form class="d-inline" method="POST" action="{{ route('event.destroy', $event->id) }}">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">Padam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('searchInput');
            var searchForm = document.getElementById('searchForm');
            var resetButton = document.getElementById('resetButton');

            var typingTimer = null;
            var delay = 700;

            searchInput.addEventListener('input', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    searchForm.submit();
                }, delay);
            });

            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(typingTimer);
                    e.preventDefault();
                    searchForm.submit();
                }
            });

            resetButton.addEventListener('click', function() {
                window.location.href = "{{ route('event') }}";
            });
        });
    </script>
@endsection
