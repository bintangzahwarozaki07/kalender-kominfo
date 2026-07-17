<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityController extends Controller
{
    /**
     * Menampilkan daftar kegiatan + Search + Pagination
     */
    public function index(Request $request)
    {
        $query = Activity::with([
            'category',
            'institution'
        ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")

                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })

                    ->orWhereHas('institution', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });

            });
        }

        $activities = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.activities.index',
            compact('activities')
        );
    }

    /**
     * Data kalender (FullCalendar)
     */
    public function calendar()
    {
        $activities = Activity::with('category')->get();

        $events = [];

        foreach ($activities as $activity) {

            switch ($activity->status) {

                case 'Draft':
                    $color = '#6c757d';
                    break;

                case 'Terjadwal':
                    $color = '#0d6efd';
                    break;

                case 'Dipublikasikan':
                    $color = '#198754';
                    break;

                case 'Selesai':
                    $color = '#dc3545';
                    break;

                default:
                    $color = '#6c757d';
                    break;
            }

            $events[] = [

                'id' => $activity->id,

                'title' => $activity->title,

                'start' => $activity->activity_date,

                'color' => $color,

                'extendedProps' => [

                    'kategori' => optional($activity->category)->name,

                    'lokasi' => $activity->location,

                    'jam' => $activity->start_time . ' - ' . $activity->end_time,

                    'status' => $activity->status,

                    'pic' => $activity->person_in_charge,

                    'deskripsi' => $activity->description

                ]

            ];
        }

        return response()->json($events);
    }

    /**
     * Form tambah kegiatan
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        $institutions = Institution::orderBy('name')->get();

        return view(
            'admin.activities.create',
            compact(
                'categories',
                'institutions'
            )
        );
    }

    /**
     * Simpan kegiatan
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'institution_id' => 'required|exists:institutions,id',
            'title' => 'required|max:200',
            'activity_date' => 'required|date',
            'publish_date' => 'nullable|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|max:255',
            'person_in_charge' => 'required|max:255',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required'
        ]);

        $data = $request->all();

        $data['slug'] = Str::slug($request->title);

        if (Activity::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . time();
        }

        if ($request->hasFile('thumbnail')) {

            $file = $request->file('thumbnail');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('uploads/activities'),
                $filename
            );

            $data['thumbnail'] = $filename;
        }

        Activity::create($data);

        return redirect()
            ->route('activities.index')
            ->with(
                'success',
                'Kegiatan berhasil ditambahkan.'
            );
    }

    /**
     * Form edit kegiatan
     */
    public function edit(Activity $activity)
    {
        $categories = Category::orderBy('name')->get();

        $institutions = Institution::orderBy('name')->get();

        return view(
            'admin.activities.edit',
            compact(
                'activity',
                'categories',
                'institutions'
            )
        );
    }

    /**
     * Update kegiatan
     */
    public function update(Request $request, Activity $activity)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'institution_id' => 'required|exists:institutions,id',
            'title' => 'required|max:200',
            'activity_date' => 'required|date',
            'publish_date' => 'nullable|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|max:255',
            'person_in_charge' => 'required|max:255',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required'
        ]);

        $data = $request->all();

        $slug = Str::slug($request->title);

        if (
            Activity::where('slug', $slug)
                ->where('id', '!=', $activity->id)
                ->exists()
        ) {
            $slug .= '-' . time();
        }

        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {

            if (
                $activity->thumbnail &&
                file_exists(public_path('uploads/activities/' . $activity->thumbnail))
            ) {
                unlink(public_path('uploads/activities/' . $activity->thumbnail));
            }

            $file = $request->file('thumbnail');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('uploads/activities'),
                $filename
            );

            $data['thumbnail'] = $filename;
        }

        $activity->update($data);

        return redirect()
            ->route('activities.index')
            ->with(
                'success',
                'Kegiatan berhasil diperbarui.'
            );
    }

    /**
     * Hapus kegiatan
     */
    public function destroy(Activity $activity)
    {
        if (
            $activity->thumbnail &&
            file_exists(public_path('uploads/activities/' . $activity->thumbnail))
        ) {
            unlink(public_path('uploads/activities/' . $activity->thumbnail));
        }

        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with(
                'success',
                'Kegiatan berhasil dihapus.'
            );
    }

    /**
     * Export PDF
     */
    public function exportPdf()
    {
        $activities = Activity::with([
            'category',
            'institution'
        ])
        ->orderBy('activity_date')
        ->get();

        $pdf = Pdf::loadView(
            'admin.activities.pdf',
            compact('activities')
        );

        return $pdf->download('Data-Kegiatan.pdf');
    }
}