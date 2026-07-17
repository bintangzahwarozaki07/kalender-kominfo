<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Daftar Link Publikasi
     */
    public function index(Request $request)
    {
        $query = Link::with('activity');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")

                    ->orWhere('platform', 'like', "%{$search}%")

                    ->orWhere('url', 'like', "%{$search}%")

                    ->orWhereHas('activity', function ($q) use ($search) {

                        $q->where('title', 'like', "%{$search}%");

                    });

            });

        }

        $links = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.links.index',
            compact('links')
        );
    }

    /**
     * Form tambah link
     */
    public function create()
    {
        $activities = Activity::orderBy('title')->get();

        return view(
            'admin.links.create',
            compact('activities')
        );
    }

    /**
     * Simpan link
     */
    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'title'       => 'required|max:200',
            'url'         => 'required|url|max:255',
            'platform'    => 'required|max:100',
        ]);

        Link::create($request->all());

        return redirect()
            ->route('links.index')
            ->with(
                'success',
                'Link publikasi berhasil ditambahkan.'
            );
    }

    /**
     * Form edit
     */
    public function edit(Link $link)
    {
        $activities = Activity::orderBy('title')->get();

        return view(
            'admin.links.edit',
            compact(
                'link',
                'activities'
            )
        );
    }

    /**
     * Update link
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'title'       => 'required|max:200',
            'url'         => 'required|url|max:255',
            'platform'    => 'required|max:100',
        ]);

        $link->update($request->all());

        return redirect()
            ->route('links.index')
            ->with(
                'success',
                'Link berhasil diperbarui.'
            );
    }

    /**
     * Hapus link
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()
            ->route('links.index')
            ->with(
                'success',
                'Link berhasil dihapus.'
            );
    }
}