<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Documentation;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DocumentationController extends Controller
{
    public function index(Request $request)
    {
        $query = Documentation::with([
            'activity',
            'links',
            'activity.links' => function ($q) {
                $q->whereNull('documentation_id');
            }
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('caption', 'like', "%{$search}%")
                    ->orWhereHas('activity', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('links', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('platform', 'like', "%{$search}%")
                            ->orWhere('url', 'like', "%{$search}%");
                    })
                    ->orWhereHas('activity.links', function ($q) use ($search) {
                        $q->whereNull('documentation_id')
                            ->where(function ($linkQuery) use ($search) {
                                $linkQuery->where('title', 'like', "%{$search}%")
                                    ->orWhere('platform', 'like', "%{$search}%")
                                    ->orWhere('url', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $documentations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Mengambil link lama yang belum terhubung langsung
        // dengan dokumentasi agar tetap bisa ditampilkan.
        $legacyLinks = Link::with('activity')
            ->whereNull('documentation_id')
            ->latest()
            ->get();

        return view(
            'admin.documentations.index',
            compact('documentations', 'legacyLinks')
        );
    }

    public function create()
    {
        $activities = Activity::orderBy('title')->get();

        return view('admin.documentations.create', compact('activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'caption' => 'nullable|string',
            'is_cover' => 'nullable',
            'link_title' => 'required_with:url|nullable|string|max:200',
            'platform' => [
                'required_with:url',
                'nullable',
                Rule::in([
                    'Website',
                    'Instagram',
                    'Facebook',
                    'YouTube',
                    'TikTok',
                    'Google Drive',
                    'Lainnya'
                ])
            ],
            'url' => 'nullable|required_with:link_title,platform|url|max:255',
        ]);

        $file = $request->file('photo');
        $filename = time().'_'.$file->getClientOriginalName();

        $file->move(
            public_path('uploads/documentations'),
            $filename
        );

        $documentation = Documentation::create([
            'activity_id' => $request->activity_id,
            'photo' => $filename,
            'caption' => $request->caption,
            'is_cover' => $request->has('is_cover')
        ]);

        // Simpan link hanya jika URL diisi.
        if ($request->filled('url')) {
            Link::create([
                'activity_id' => $documentation->activity_id,
                'documentation_id' => $documentation->id,
                'title' => $request->link_title,
                'platform' => $request->platform,
                'url' => $request->url
            ]);
        }

        return redirect()->route('documentations.index')
            ->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function edit(Documentation $documentation)
    {
        $activities = Activity::orderBy('title')->get();

        $documentation->load('links');

        return view(
            'admin.documentations.edit',
            compact('documentation', 'activities')
        );
    }

    public function update(Request $request, Documentation $documentation)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'caption' => 'nullable|string',
            'is_cover' => 'nullable',
            'link_title' => 'required_with:url|nullable|string|max:200',
            'platform' => [
                'required_with:url',
                'nullable',
                Rule::in([
                    'Website',
                    'Instagram',
                    'Facebook',
                    'YouTube',
                    'TikTok',
                    'Google Drive',
                    'Lainnya'
                ])
            ],
            'url' => 'nullable|required_with:link_title,platform|url|max:255',
        ]);

        $data = [
            'activity_id' => $request->activity_id,
            'caption' => $request->caption,
            'is_cover' => $request->has('is_cover')
        ];

        if ($request->hasFile('photo')) {
            if (
                $documentation->photo &&
                file_exists(public_path('uploads/documentations/'.$documentation->photo))
            ) {
                unlink(public_path('uploads/documentations/'.$documentation->photo));
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

        // Tambahkan link baru jika URL diisi.
        if ($request->filled('url')) {
            Link::create([
                'activity_id' => $documentation->activity_id,
                'documentation_id' => $documentation->id,
                'title' => $request->link_title,
                'platform' => $request->platform,
                'url' => $request->url
            ]);
        }

        return redirect()->route('documentations.index')
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(Documentation $documentation)
    {
        if (
            $documentation->photo &&
            file_exists(public_path('uploads/documentations/'.$documentation->photo))
        ) {
            unlink(public_path('uploads/documentations/'.$documentation->photo));
        }

        $documentation->delete();

        return redirect()->route('documentations.index')
            ->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
