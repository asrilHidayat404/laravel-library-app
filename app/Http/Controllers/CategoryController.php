<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori
     */
    public function index()
    {
        $categories = Category::withCount('books')->latest()->get();
        return view('pages.admin.categories.index', compact('categories'));
    }


    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diupdate.' ]);
        }

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit kategori
     */
    public function edit(Category $category)
    {
        return view('pages.admin.categories.edit', compact('category'));
    }

    /**
     * Update kategori
     */

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        $category->update([
            'category_name' => $request->category_name,
        ]);
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diupdate.' ]);
        }

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori
     */
    public function destroy(Category $category)
    {
        $category->delete();
         if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.' ]);
        }

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

}
