@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="sipkp-dashboard">

    {{-- HEADER --}}
    <section class="dashboard-heading">
        <div>
            <div class="dashboard-eyebrow">
                <span class="eyebrow-dot"></span>
                SISTEM INFORMASI PUBLIKASI
            </div>
            <h1>Dashboard</h1>
            <p>Selamat datang di pusat pengelolaan kalender publikasi Kominfo Ngawi.</p>
        </div>

        <div class="dashboard-actions">
            <a href="{{ route('activities.create') }}" class="btn-dashboard-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah Kegiatan
            </a>
            <a href="{{ route('activities.index') }}" class="btn-dashboard-secondary">
                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF
            </a>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="dashboard-stats">
        <article class="stat-card stat-green">
            <div class="stat-top">
                <span>Total Kategori</span>
                <div class="stat-icon"><i class="bi bi-grid-1x2"></i></div>
            </div>
            <div class="stat-number">{{ $totalKategori }}</div>
            <div class="stat-bottom">
                <span>Data kategori tersimpan</span>
                <i class="bi bi-arrow-up-right"></i>
            </div>
        </article>

        <article class="stat-card stat-blue">
            <div class="stat-top">
                <span>Total Instansi</span>
                <div class="stat-icon"><i class="bi bi-buildings"></i></div>
            </div>
            <div class="stat-number">{{ $totalInstansi }}</div>
            <div class="stat-bottom">
                <span>Data instansi terdaftar</span>
                <i class="bi bi-arrow-up-right"></i>
            </div>
        </article>

        <article class="stat-card stat-orange">
            <div class="stat-top">
                <span>Total Kegiatan</span>
                <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
            </div>
            <div class="stat-number">{{ $totalKegiatan }}</div>
            <div class="stat-bottom">
                <span>Seluruh kegiatan</span>
                <i class="bi bi-arrow-up-right"></i>
            </div>
        </article>

        <article class="stat-card stat-purple">
            <div class="stat-top">
                <span>Dokumentasi</span>
                <div class="stat-icon"><i class="bi bi-images"></i></div>
            </div>
            <div class="stat-number">{{ $totalDokumentasi }}</div>
            <div class="stat-bottom">
                <span>Dokumentasi tersimpan</span>
                <i class="bi bi-arrow-up-right"></i>
            </div>
        </article>

        <article class="stat-card stat-cyan">
            <div class="stat-top">
                <span>Link Publikasi</span>
                <div class="stat-icon"><i class="bi bi-link-45deg"></i></div>
            </div>
            <div class="stat-number">{{ $totalLink }}</div>
            <div class="stat-bottom">
                <span>Tautan publikasi tersimpan</span>
                <i class="bi bi-arrow-up-right"></i>
            </div>
        </article>
    </section>

    {{-- GRAFIK --}}
    <section class="dashboard-chart-grid">
        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h3>Status Kegiatan</h3>
                    <p>Distribusi kegiatan berdasarkan status</p>
                </div>
                <span class="panel-icon"><i class="bi bi-bar-chart-line"></i></span>
            </div>
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h3>Aktivitas Bulanan</h3>
                    <p>Jumlah kegiatan berdasarkan bulan</p>
                </div>
                <span class="panel-icon"><i class="bi bi-graph-up-arrow"></i></span>
            </div>
            <div class="chart-container">
                <canvas id="bulanChart"></canvas>
            </div>
        </div>
    </section>

    {{-- KALENDER --}}
    <section class="dashboard-panel calendar-panel">
        <div class="panel-heading calendar-heading">
            <div>
                <div class="panel-kicker">PERENCANAAN DAN PUBLIKASI</div>
                <h3>Kalender Kegiatan</h3>
                <p>Pantau jadwal kegiatan dan publikasi dinas.</p>
            </div>
            <span class="calendar-heading-icon">
                <i class="bi bi-calendar3"></i>
            </span>
        </div>

        <div id="calendarMessage"></div>
        <div id="calendar" class="sipkp-calendar"></div>

        <div class="calendar-legend">
            <span><i class="legend-dot legend-draft"></i> Draft</span>
            <span><i class="legend-dot legend-scheduled"></i> Terjadwal</span>
            <span><i class="legend-dot legend-published"></i> Dipublikasikan</span>
            <span><i class="legend-dot legend-finished"></i> Selesai</span>
        </div>
    </section>

    {{-- KEGIATAN TERBARU --}}
    <section class="dashboard-panel latest-panel">
        <div class="panel-heading">
            <div>
                <h3>Kegiatan Terbaru</h3>
                <p>Lima data kegiatan yang terakhir ditambahkan.</p>
            </div>
            <a href="{{ route('activities.index') }}" class="panel-link">
                Lihat semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table dashboard-table">
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Kategori</th>
                        <th>Instansi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatanTerbaru as $item)
                        <tr>
                            <td>
                                <div class="activity-name">
                                    <span class="activity-table-icon">
                                        <i class="bi bi-calendar2-check"></i>
                                    </span>
                                    <strong>{{ $item->title }}</strong>
                                </div>
                            </td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->institution->name ?? '-' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->activity_date)->translatedFormat('d M Y') }}
                            </td>
                            <td>
                                @php
                                    $statusClass = match($item->status) {
                                        'Draft' => 'status-draft',
                                        'Terjadwal' => 'status-scheduled',
                                        'Dipublikasikan' => 'status-published',
                                        'Selesai' => 'status-finished',
                                        default => 'status-default',
                                    };
                                @endphp
                                <span class="status-pill {{ $statusClass }}">
                                    <span></span>
                                    {{ $item->status ?? 'Belum ditentukan' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-table">
                                <i class="bi bi-inbox"></i>
                                <strong>Belum ada kegiatan</strong>
                                <span>Data kegiatan akan muncul di sini setelah ditambahkan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <footer class="dashboard-footer">
        <span>SIPKP · Dinas Kominfo Kabupaten Ngawi</span>
        <span>Sistem Informasi Kalender Publikasi</span>
    </footer>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const green = '#059669';
    const textColor = '#64748b';
    const gridColor = '#edf1f0';

    // Grafik status kegiatan
    const statusCanvas = document.getElementById('statusChart');

    if (statusCanvas && typeof Chart !== 'undefined') {
        new Chart(statusCanvas, {
            type: 'bar',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    label: 'Jumlah Kegiatan',
                    data: @json($statusData),
                    backgroundColor: ['#94a3b8', '#3b82f6', '#10b981', '#334155'],
                    borderRadius: 7,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: textColor },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    // Grafik kegiatan per bulan
    const monthCanvas = document.getElementById('bulanChart');

    if (monthCanvas && typeof Chart !== 'undefined') {
        new Chart(monthCanvas, {
            type: 'line',
            data: {
                labels: @json($bulanLabel),
                datasets: [{
                    label: 'Jumlah Kegiatan',
                    data: @json($bulanTotal),
                    borderColor: green,
                    backgroundColor: 'rgba(5, 150, 105, 0.10)',
                    fill: true,
                    tension: 0.38,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: green,
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: textColor },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }
});
</script>
@endpush
