<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\ActivitySubmission;
use App\Models\Category;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitySubmissionController extends Controller
{
    /**
     * Menampilkan daftar pengajuan milik Pemohon.
     */
    public function index()
    {
        $submissions = ActivitySubmission::with([
            'category',
            'institution',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pemohon.submissions.index', compact(
            'submissions'
        ));
    }

    /**
     * Menampilkan formulir pengajuan baru.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();

        return view('pemohon.submissions.create', compact(
            'categories',
            'institutions'
        ));
    }

    /**
     * Menyimpan pengajuan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if (
            !empty($validated['start_time']) &&
            !empty($validated['end_time']) &&
            $validated['end_time'] <= $validated['start_time']
        ) {
            return back()
                ->withErrors([
                    'end_time' => 'Waktu selesai harus lebih besar daripada waktu mulai.',
                ])
                ->withInput();
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Menunggu';

        ActivitySubmission::create($validated);

        return redirect()
            ->route('pemohon.submissions.index')
            ->with(
                'success',
                'Pengajuan kegiatan berhasil dikirim dan menunggu pemeriksaan Administrator.'
            );
    }

    /**
     * Menampilkan formulir edit pengajuan yang perlu revisi.
     */
    public function edit(ActivitySubmission $submission)
    {
        $submission = $this->findEditableSubmission($submission);

        $categories = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();

        return view('pemohon.submissions.edit', compact(
            'submission',
            'categories',
            'institutions'
        ));
    }

    /**
     * Memperbarui pengajuan setelah diperbaiki Pemohon.
     */
    public function update(Request $request, ActivitySubmission $submission)
    {
        $submission = $this->findEditableSubmission($submission);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if (
            !empty($validated['start_time']) &&
            !empty($validated['end_time']) &&
            $validated['end_time'] <= $validated['start_time']
        ) {
            return back()
                ->withErrors([
                    'end_time' => 'Waktu selesai harus lebih besar daripada waktu mulai.',
                ])
                ->withInput();
        }

        $validated['status'] = 'Menunggu';

        // Catatan revisi sebelumnya dibersihkan setelah Pemohon mengirim ulang.
        $validated['admin_note'] = null;

        $submission->update($validated);

        return redirect()
            ->route('pemohon.submissions.index')
            ->with(
                'success',
                'Perbaikan pengajuan berhasil dikirim ulang. Status pengajuan kembali menjadi Menunggu pemeriksaan Admin.'
            );
    }

    /**
     * Memastikan pengajuan milik Pemohon yang sedang login
     * dan hanya dapat diedit jika statusnya Perlu Revisi.
     */
    private function findEditableSubmission(ActivitySubmission $submission)
    {
        abort_unless(
            $submission->user_id === Auth::id(),
            403,
            'Anda tidak memiliki akses ke pengajuan ini.'
        );

        abort_unless(
            $submission->status === 'Perlu Revisi' &&
            is_null($submission->activity_id),
            403,
            'Pengajuan ini tidak dapat diedit karena statusnya bukan Perlu Revisi.'
        );

        return $submission;
    }
}
