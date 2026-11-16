<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Institution;
use App\Models\Documentation;
use App\Models\Link;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKategori = Category::count();
        $totalInstansi = Institution::count();
        $totalKegiatan = Activity::count();
        $totalDokumentasi = Documentation::count();
        $totalLink = Link::count();

        $kegiatanTerbaru = Activity::with([
            'category',
            'institution'
        ])
            ->latest()
            ->take(5)
            ->get();

        $statusLabels = [
            'Draft',
            'Terjadwal',
            'Dipublikasikan',
            'Selesai'
        ];

        $statusData = [];

        foreach ($statusLabels as $status) {
            $statusData[] = Activity::where(
                'status',
                $status
            )->count();
        }

        $bulanData = Activity::select(
            DB::raw('MONTH(activity_date) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabel = [];
        $bulanTotal = [];

        foreach ($bulanData as $row) {
            $bulanLabel[] = date(
                'F',
                mktime(0, 0, 0, $row->bulan, 1)
            );

            $bulanTotal[] = $row->total;
        }

        $calendarEvents = Activity::with([
            'category',
            'institution'
        ])
            ->orderBy('activity_date')
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'start' => \Carbon\Carbon::parse(
                        $activity->activity_date
                    )->format('Y-m-d'),
                    'allDay' => true,
                    'backgroundColor' => match ($activity->status) {
                        'Draft' => '#6c757d',
                        'Terjadwal' => '#0d6efd',
                        'Dipublikasikan' => '#198754',
                        'Selesai' => '#212529',
                        default => '#0d6efd',
                    },
                    'borderColor' => match ($activity->status) {
                        'Draft' => '#6c757d',
                        'Terjadwal' => '#0d6efd',
                        'Dipublikasikan' => '#198754',
                        'Selesai' => '#212529',
                        default => '#0d6efd',
                    },
                    'extendedProps' => [
                        'kategori' => $activity->category->name ?? '-',
                        'lokasi' => $activity->location ?? '-',
                        'status' => $activity->status ?? '-',
                        'instansi' => $activity->institution->name ?? '-',
                    ],
                ];
            })
            ->values();

        return view('admin.dashboard.index', compact(
            'totalKategori',
            'totalInstansi',
            'totalKegiatan',
            'totalDokumentasi',
            'totalLink',
            'kegiatanTerbaru',
            'statusLabels',
            'statusData',
            'bulanLabel',
            'bulanTotal',
            'calendarEvents'
        ));
    }
}
