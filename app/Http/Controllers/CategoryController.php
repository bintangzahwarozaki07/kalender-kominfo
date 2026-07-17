<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Daftar kategori
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%");

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact(
            'categories',
            'search'
        ));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:150|unique:categories,name',

            'description' => 'nullable'

        ]);

        Category::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description

        ]);

        return redirect()
            ->route('categories.index')
            ->with('success','Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([

            'name' => 'required|max:150|unique:categories,name,'.$category->id,

            'description' => 'nullable'

        ]);

        $slug = Str::slug($request->name);

        if (
            Category::where('slug',$slug)
                ->where('id','!=',$category->id)
                ->exists()
        ) {
            $slug .= '-'.time();
        }

        $category->update([

            'name'=>$request->name,

            'slug'=>$slug,

            'description'=>$request->description

        ]);

        return redirect()
            ->route('categories.index')
            ->with('success','Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success','Kategori berhasil dihapus.');
    }
}