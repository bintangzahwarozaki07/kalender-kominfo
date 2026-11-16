<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivitySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActivitySubmissionController extends Controller
{
    /**
     * Menampilkan seluruh pengajuan dari Pemohon.
     */
    public function index()
    {
        $submissions = ActivitySubmission::with([
            'user',
            'category',
            'institution',
        ])
            ->latest()
            ->paginate(15);

        return view('admin.submissions.index', compact(
            'submissions'
        ));
    }

    /**
     * Menampilkan detail pengajuan.
     */
    public function show(ActivitySubmission $submission)
    {
        $submission->load([
            'user',
            'category',
            'institution',
            'activity',
        ]);

        return view('admin.submissions.show', compact(
            'submission'
        ));
    }

    /**
     * Menyetujui pengajuan dan membuat kegiatan resmi.
     */
    public function approve(Request $request, ActivitySubmission $submission)
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($submission, $validated) {

            $submission = ActivitySubmission::whereKey($submission->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Jika sudah pernah dibuat menjadi kegiatan, jangan membuat duplikat.
            if ($submission->activity_id) {
                $submission->update([
                    'status' => 'Disetujui',
                    'admin_note' => $validated['admin_note'] ?? $submission->admin_note,
                ]);

                return;
            }

            if (!in_array($submission->status, ['Menunggu', 'Perlu Revisi'])) {
                abort(422, 'Pengajuan ini tidak dapat disetujui karena statusnya bukan Menunggu atau Perlu Revisi.');
            }

            $baseSlug = Str::slug($submission->title);

            if ($baseSlug === '') {
                $baseSlug = 'kegiatan';
            }

            $slug = $baseSlug;
            $counter = 1;

            while (Activity::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $activity = Activity::create([
                'category_id' => $submission->category_id,
                'institution_id' => $submission->institution_id,
                'title' => $submission->title,
                'slug' => $slug,
                'activity_date' => $submission->activity_date,
                'publish_date' => null,
                'start_time' => $submission->start_time,
                'end_time' => $submission->end_time,
                'location' => $submission->location,
                'person_in_charge' => $submission->person_in_charge,
                'description' => $submission->description,
                'status' => 'Terjadwal',
            ]);

            $submission->update([
                'status' => 'Disetujui',
                'admin_note' => $validated['admin_note'] ?? null,
                'activity_id' => $activity->id,
            ]);
        });

        return redirect()
            ->route('admin.submissions.show', $submission)
            ->with(
                'success',
                'Pengajuan berhasil disetujui dan telah dimasukkan ke data kegiatan.'
            );
    }

    /**
     * Menolak pengajuan.
     */
    public function reject(Request $request, ActivitySubmission $submission)
    {
        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:2000'],
        ], [
            'admin_note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($submission->activity_id) {
            return back()->withErrors([
                'admin_note' => 'Pengajuan ini sudah menjadi kegiatan resmi sehingga tidak dapat ditolak.',
            ]);
        }

        if (!in_array($submission->status, ['Menunggu', 'Perlu Revisi'])) {
            return back()->withErrors([
                'admin_note' => 'Pengajuan ini tidak dapat ditolak karena statusnya sudah diproses.',
            ]);
        }

        $submission->update([
            'status' => 'Ditolak',
            'admin_note' => $validated['admin_note'],
        ]);

        return redirect()
            ->route('admin.submissions.show', $submission)
            ->with('success', 'Pengajuan berhasil ditolak.');
    }

    /**
     * Meminta Pemohon melakukan revisi.
     */
    public function revision(Request $request, ActivitySubmission $submission)
    {
        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:2000'],
        ], [
            'admin_note.required' => 'Catatan revisi wajib diisi.',
        ]);

        if ($submission->activity_id) {
            return back()->withErrors([
                'admin_note' => 'Pengajuan ini sudah menjadi kegiatan resmi.',
            ]);
        }

        if (!in_array($submission->status, ['Menunggu', 'Perlu Revisi'])) {
            return back()->withErrors([
                'admin_note' => 'Pengajuan ini tidak dapat direvisi karena statusnya sudah diproses.',
            ]);
        }

        $submission->update([
            'status' => 'Perlu Revisi',
            'admin_note' => $validated['admin_note'],
        ]);

        return redirect()
            ->route('admin.submissions.show', $submission)
            ->with('success', 'Permintaan revisi berhasil dikirim kepada Pemohon.');
    }
}