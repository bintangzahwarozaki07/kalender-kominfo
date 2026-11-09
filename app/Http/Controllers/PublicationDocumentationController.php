<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class PublicationDocumentationController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with([
            'links',
            'documentations'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")

                    ->orWhereHas('links', function ($linkQuery) use ($search) {
                        $linkQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('platform', 'like', "%{$search}%")
                            ->orWhere('url', 'like', "%{$search}%");
                    })

                    ->orWhereHas('documentations', function ($docQuery) use ($search) {
                        $docQuery->where('caption', 'like', "%{$search}%");
                    });
            });
        }

        $activities = $query
            ->orderByDesc('activity_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.publication-documentations.index',
            compact('activities')
        );
    }
}
