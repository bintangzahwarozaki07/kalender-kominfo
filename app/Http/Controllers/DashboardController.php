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
        // ==========================
        // Statistik
        // ==========================

        $totalKategori      = Category::count();
        $totalInstansi      = Institution::count();
        $totalKegiatan      = Activity::count();
        $totalDokumentasi   = Documentation::count();
        $totalLink          = Link::count();

        // ==========================
        // 5 kegiatan terbaru
        // ==========================

        $kegiatanTerbaru = Activity::with([
                'category',
                'institution'
            ])
            ->latest()
            ->take(5)
            ->get();

        // ==========================
        // Grafik Status
        // ==========================

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

        // ==========================
        // Grafik Bulanan
        // ==========================

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
                mktime(0,0,0,$row->bulan,1)
            );

            $bulanTotal[] = $row->total;

        }

        $calendarEvents = Activity::select(
         'id',
         'title',
         'activity_date'
          )->get()->map(function ($item) 
        { return [
            'title' => $item->title,
            'start' => $item->activity_date,
          ];
        });

        return view('admin.dashboard.index',
         compact(
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