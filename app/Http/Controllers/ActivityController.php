<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    /**
     * Menampilkan daftar kegiatan.
     */
    public function index(Request $request)
    {
        $query = Activity::with(['category', 'institution'])->latest();

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
     * Menyediakan data JSON untuk FullCalendar.
     */
    public function calendar(Request $request)
    {
        $query = Activity::with(['category', 'institution']);

        if ($request->filled('start')) {
            $query->whereDate(
                'activity_date',
                '>=',
                Carbon::parse($request->start)->toDateString()
            );
        }

        if ($request->filled('end')) {
            // Tanggal akhir FullCalendar bersifat eksklusif.
            $endDate = Carbon::parse($request->end)
                ->subDay()
                ->toDateString();

            $query->whereDate('activity_date', '<=', $endDate);
        }

        $colors = [
            'Draft' => '#6c757d',
            'Terjadwal' => '#0d6efd',
            'Dipublikasikan' => '#198754',
            'Selesai' => '#212529',
        ];

        $events = $query->orderBy('activity_date')->get()
            ->map(function ($activity) use ($colors) {
                $date = Carbon::parse($activity->activity_date)
                    ->format('Y-m-d');

                $hasTime = !empty($activity->start_time);

                $start = $hasTime
                    ? Carbon::parse(
                        $date . ' ' . $activity->start_time
                    )->toIso8601String()
                    : $date;

                $color = $colors[$activity->status] ?? '#0d6efd';

                return [
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'start' => $start,
                    'allDay' => !$hasTime,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'extendedProps' => [
                        'kategori' => $activity->category->name ?? '-',
                        'jam' => $hasTime
                            ? substr((string) $activity->start_time, 0, 5)
                            : '-',
                        'lokasi' => $activity->location ?? '-',
                        'pic' => $activity->person_in_charge ?? '-',
                        'status' => $activity->status ?? '-',
                        'deskripsi' => $activity->description ?? '-',
                        'instansi' => $activity->institution->name ?? '-',
                    ],
                ];
            });

        return response()->json($events);
    }

    /**
     * Form tambah kegiatan.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();

        return view('admin.activities.create', compact(
            'categories',
            'institutions'
        ));
    }

    /**
     * Aturan validasi kegiatan.
     */
    private function validateActivity(Request $request): array
    {
        return $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'institution_id' => [
                'required',
                'exists:institutions,id',
            ],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'publish_date' => ['nullable', 'date'],
            'start_time' => ['nullable'],
            'end_time' => ['nullable'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'status' => [
                'required',
                Rule::in([
                    'Draft',
                    'Terjadwal',
                    'Dipublikasikan',
                    'Selesai',
                ]),
            ],

            'letter_number' => ['nullable', 'string', 'max:255'],
            'letter_attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
            'letter_recipient' => ['nullable', 'string', 'max:255'],
            'letter_date' => ['nullable', 'date'],
            'signatory_position' => ['nullable', 'string', 'max:255'],
            'signatory_name' => ['nullable', 'string', 'max:255'],
            'signatory_nip' => ['nullable', 'string', 'max:50'],
        ]);
    }

    /**
     * Menyimpan kegiatan baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateActivity($request);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['title']
        );

        $directory = public_path('uploads/activities');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            $filename = uniqid() . '_' . time() . '.' .
                $file->getClientOriginalExtension();

            $file->move($directory, $filename);
            $validated['thumbnail'] = $filename;
        }

        if ($request->hasFile('letter_attachment')) {
            $validated['letter_attachment'] = $request
                ->file('letter_attachment')
                ->store('letter-attachments', 'public');
        }

        Activity::create($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Detail kegiatan.
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
     * Form edit kegiatan.
     */
    public function edit(Activity $activity)
    {
        $categories = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();

        return view('admin.activities.edit', compact(
            'activity',
            'categories',
            'institutions'
        ));
    }

    /**
     * Memperbarui kegiatan.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $this->validateActivity($request);

        if ($validated['title'] !== $activity->title) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['title'],
                $activity->id
            );
        }

        $directory = public_path('uploads/activities');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if ($request->hasFile('thumbnail')) {
            if (
                $activity->thumbnail &&
                file_exists($directory . '/' . $activity->thumbnail)
            ) {
                unlink($directory . '/' . $activity->thumbnail);
            }

            $file = $request->file('thumbnail');

            $filename = uniqid() . '_' . time() . '.' .
                $file->getClientOriginalExtension();

            $file->move($directory, $filename);
            $validated['thumbnail'] = $filename;
        } else {
            unset($validated['thumbnail']);
        }

        if ($request->hasFile('letter_attachment')) {
            if (
                $activity->letter_attachment &&
                Storage::disk('public')->exists(
                    $activity->letter_attachment
                )
            ) {
                Storage::disk('public')->delete(
                    $activity->letter_attachment
                );
            }

            $validated['letter_attachment'] = $request
                ->file('letter_attachment')
                ->store('letter-attachments', 'public');
        } else {
            unset($validated['letter_attachment']);
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

        if (
            $activity->letter_attachment &&
            Storage::disk('public')->exists(
                $activity->letter_attachment
            )
        ) {
            Storage::disk('public')->delete(
                $activity->letter_attachment
            );
        }

        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Mengekspor kegiatan ke PDF.
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
     * Menghasilkan slug unik.
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
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
