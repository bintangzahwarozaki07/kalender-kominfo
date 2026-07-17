<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Documentation;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    /**
     * Menampilkan daftar dokumentasi
     */
    public function index(Request $request)
    {
        $query = Documentation::with('activity');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('caption', 'like', "%{$search}%")

                  ->orWhereHas('activity', function ($q) use ($search) {

                        $q->where('title', 'like', "%{$search}%");

                  });

            });

        }

        $documentations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.documentations.index',
            compact('documentations')
        );
    }

    /**
     * Form tambah dokumentasi
     */
    public function create()
    {
        $activities = Activity::orderBy('title')->get();

        return view(
            'admin.documentations.create',
            compact('activities')
        );
    }

    /**
     * Simpan dokumentasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'caption' => 'nullable',
            'is_cover' => 'nullable'
        ]);

        $filename = null;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/documentations'),
                $filename
            );
        }

        Documentation::create([

            'activity_id' => $request->activity_id,

            'photo' => $filename,

            'caption' => $request->caption,

            'is_cover' => $request->has('is_cover')

        ]);

        return redirect()
            ->route('documentations.index')
            ->with(
                'success',
                'Dokumentasi berhasil ditambahkan.'
            );
    }

    /**
     * Form edit dokumentasi
     */
    public function edit(Documentation $documentation)
    {
        $activities = Activity::orderBy('title')->get();

        return view(
            'admin.documentations.edit',
            compact(
                'documentation',
                'activities'
            )
        );
    }

    /**
     * Update dokumentasi
     */
    public function update(Request $request, Documentation $documentation)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'caption' => 'nullable',
            'is_cover' => 'nullable'
        ]);

        $data = [

            'activity_id' => $request->activity_id,

            'caption' => $request->caption,

            'is_cover' => $request->has('is_cover')

        ];

        if ($request->hasFile('photo')) {

            if (
                $documentation->photo &&
                file_exists(
                    public_path(
                        'uploads/documentations/'.$documentation->photo
                    )
                )
            ) {

                unlink(
                    public_path(
                        'uploads/documentations/'.$documentation->photo
                    )
                );

            }

            $file = $request->file('photo');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/documentations'),
                $filename
            );

            $data['photo'] = $filename;

        }

        $documentation->update($data);

        return redirect()
            ->route('documentations.index')
            ->with(
                'success',
                'Dokumentasi berhasil diperbarui.'
            );
    }

    /**
     * Hapus dokumentasi
     */
    public function destroy(Documentation $documentation)
    {
        if (
            $documentation->photo &&
            file_exists(
                public_path(
                    'uploads/documentations/'.$documentation->photo
                )
            )
        ) {

            unlink(
                public_path(
                    'uploads/documentations/'.$documentation->photo
                )
            );

        }

        $documentation->delete();

        return redirect()
            ->route('documentations.index')
            ->with(
                'success',
                'Dokumentasi berhasil dihapus.'
            );
    }
}