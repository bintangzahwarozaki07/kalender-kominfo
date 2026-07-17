@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

    {{-- Header Dashboard --}}

    <div class="row mb-4">

        <div class="col-lg-8">

            <h2 class="fw-bold mb-1">

                <i class="bi bi-speedometer2 text-success"></i>

                Dashboard Kalender Publikasi Kominfo

            </h2>

            <p class="text-muted mb-0">

                Selamat datang di Sistem Informasi Kalender Publikasi Dinas Komunikasi dan Informatika.

            </p>

        </div>

        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">

            <a href="{{ route('activities.create') }}"
               class="btn btn-success">

                <i class="bi bi-plus-circle"></i>

                Tambah Kegiatan

            </a>

            <a href="{{ route('activities.export.pdf') }}"
               class="btn btn-danger">

                <i class="bi bi-file-earmark-pdf"></i>

                Export PDF

            </a>

        </div>

    </div>



    {{-- Statistik --}}

    <div class="row g-4">

        <div class="col-xl col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Kategori

                            </small>

                            <h2 class="fw-bold text-primary">

                                {{ $totalKategori }}

                            </h2>

                        </div>

                        <i class="bi bi-folder-fill text-primary"
                           style="font-size:45px"></i>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Instansi

                            </small>

                            <h2 class="fw-bold text-success">

                                {{ $totalInstansi }}

                            </h2>

                        </div>

                        <i class="bi bi-building text-success"
                           style="font-size:45px"></i>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Kegiatan

                            </small>

                            <h2 class="fw-bold text-warning">

                                {{ $totalKegiatan }}

                            </h2>

                        </div>

                        <i class="bi bi-calendar-event-fill text-warning"
                           style="font-size:45px"></i>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Dokumentasi

                            </small>

                            <h2 class="fw-bold text-danger">

                                {{ $totalDokumentasi }}

                            </h2>

                        </div>

                        <i class="bi bi-images text-danger"
                           style="font-size:45px"></i>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Link Publikasi

                            </small>

                            <h2 class="fw-bold text-info">

                                {{ $totalLink }}

                            </h2>

                        </div>

                        <i class="bi bi-link-45deg text-info"
                           style="font-size:45px"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <br>

    <div class="row">

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                Grafik Status Kegiatan

            </div>

            <div class="card-body" style="height:320px">

                <canvas id="statusChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                Grafik Kegiatan per Bulan

            </div>

            <div class="card-body" style="height:320px">

                <canvas id="bulanChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-info text-white">

        Kalender Publikasi

    </div>

    <div class="card-body">

        <div id="calendar"></div>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">

        5 Kegiatan Terbaru

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>Judul</th>

                    <th>Tanggal</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

            @forelse($kegiatanTerbaru as $item)

                <tr>

                    <td>{{ $item->title }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->activity_date)->format('d M Y') }}</td>

                    <td>

                        @if($item->status=='Draft')

                            <span class="badge bg-secondary">Draft</span>

                        @elseif($item->status=='Terjadwal')

                            <span class="badge bg-warning text-dark">Terjadwal</span>

                        @elseif($item->status=='Dipublikasikan')

                            <span class="badge bg-success">Dipublikasikan</span>

                        @else

                            <span class="badge bg-primary">Selesai</span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="3" class="text-center">

                        Belum ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('statusChart'), {
    type: 'bar',
    data: {
        labels: @json($statusLabels),
        datasets: [{
            label: 'Jumlah',
            data: @json($statusData),
            backgroundColor: '#0d6efd'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins:{
            legend:{
                display:true
            }
        },
        scales:{
            y:{
                beginAtZero:true
            }
        }
    }
});

new Chart(document.getElementById('bulanChart'), {
    type: 'line',
    data: {
        labels: @json($bulanLabel),
        datasets: [{
            label: 'Jumlah Kegiatan',
            data: @json($bulanTotal),
            borderColor: '#198754',
            backgroundColor: 'rgba(25,135,84,.2)',
            fill: true,
            tension: .4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

</script>

@endpush

@endsection