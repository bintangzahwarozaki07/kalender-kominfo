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
     * Menampilkan daftar kegiatan.
     */
    public function index(Request $request)
    {
        $query = Activity::with(['category', 'institution'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('person_in_charge', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $activities = $query->paginate(10)->withQueryString();

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Menampilkan kalender kegiatan.
     */
    public function calendar()
    {
        $activities = Activity::with(['category', 'institution'])
            ->orderBy('activity_date')
            ->get();

        return view('admin.activities.calendar', compact('activities'));
    }

    /**
     * Menampilkan formulir tambah kegiatan.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();

        return view(
            'admin.activities.create',
            compact('categories', 'institutions')
        );
    }

    /**
     * Menyimpan kegiatan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'publish_date' => ['nullable', 'date'],
            'start_time' => ['nullable'],
            'end_time' => ['nullable'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'status' => [
                'required',
                'in:Draft,Terjadwal,Dipublikasikan,Selesai',
            ],
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['title']
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = uniqid() . '_' . time() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/activities'),
                $filename
            );

            $validated['thumbnail'] = $filename;
        }

        Activity::create($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kegiatan.
     */
    public function show(Activity $activity)
    {
        $activity->load([
            'category',
            'institution',
            'documentations',
            'links',
        ]);

        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Menampilkan formulir edit kegiatan.
     */
    public function edit(Activity $activity)
    {
        $categories = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();

        return view(
            'admin.activities.edit',
            compact('activity', 'categories', 'institutions')
        );
    }

    /**
     * Memperbarui kegiatan.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'publish_date' => ['nullable', 'date'],
            'start_time' => ['nullable'],
            'end_time' => ['nullable'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'status' => [
                'required',
                'in:Draft,Terjadwal,Dipublikasikan,Selesai',
            ],
        ]);

        if ($validated['title'] !== $activity->title) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['title'],
                $activity->id
            );
        }

        if ($request->hasFile('thumbnail')) {
            $directory = public_path('uploads/activities');

            if (
                $activity->thumbnail &&
                file_exists($directory . '/' . $activity->thumbnail)
            ) {
                unlink($directory . '/' . $activity->thumbnail);
            }

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $file = $request->file('thumbnail');
            $filename = uniqid() . '_' . time() . '.' .
                $file->getClientOriginalExtension();

            $file->move($directory, $filename);

            $validated['thumbnail'] = $filename;
        } else {
            unset($validated['thumbnail']);
        }

        $activity->update($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Menghapus kegiatan.
     */
    public function destroy(Activity $activity)
    {
        $thumbnailPath = public_path(
            'uploads/activities/' . $activity->thumbnail
        );

        if (
            $activity->thumbnail &&
            file_exists($thumbnailPath)
        ) {
            unlink($thumbnailPath);
        }

        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Mengunduh detail kegiatan dalam bentuk PDF.
     */
    public function exportPdf(Activity $activity)
    {
        $activity->load(['category', 'institution']);

        $pdf = Pdf::loadView(
            'admin.activities.pdf',
            compact('activity')
        );

        $pdf->setPaper('A4', 'portrait');

        $filename = 'Undangan-' .
            Str::slug($activity->title) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Membuat slug unik untuk kegiatan.
     */
    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'kegiatan';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Activity::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
