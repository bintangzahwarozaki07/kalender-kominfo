<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Menampilkan daftar instansi
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $institutions = Institution::when($search, function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('website', 'like', "%{$search}%");

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.institutions.index', compact(
            'institutions',
            'search'
        ));
    }

    /**
     * Form tambah instansi
     */
    public function create()
    {
        return view('admin.institutions.create');
    }

    /**
     * Simpan instansi
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150|unique:institutions,name',
            'address' => 'nullable|max:255',
            'website' => 'nullable|max:255',
            'logo' => 'nullable|max:255'
        ]);

        Institution::create([
            'name' => $request->name,
            'address' => $request->address,
            'website' => $request->website,
            'logo' => $request->logo
        ]);

        return redirect()
            ->route('institutions.index')
            ->with('success', 'Instansi berhasil ditambahkan.');
    }

    /**
     * Form edit instansi
     */
    public function edit(Institution $institution)
    {
        return view('admin.institutions.edit', compact('institution'));
    }

    /**
     * Update instansi
     */
    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name' => 'required|max:150|unique:institutions,name,' . $institution->id,
            'address' => 'nullable|max:255',
            'website' => 'nullable|max:255',
            'logo' => 'nullable|max:255'
        ]);

        $institution->update([
            'name' => $request->name,
            'address' => $request->address,
            'website' => $request->website,
            'logo' => $request->logo
        ]);

        return redirect()
            ->route('institutions.index')
            ->with('success', 'Instansi berhasil diperbarui.');
    }

    /**
     * Hapus instansi
     */
    public function destroy(Institution $institution)
    {
        $institution->delete();

        return redirect()
            ->route('institutions.index')
            ->with('success', 'Instansi berhasil dihapus.');
    }
}