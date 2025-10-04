<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('str', '');
            $books = Book::where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')->with(['categories', 'borrowedBooks'])->get();

            return response()->json(['books' => $books]);
        }

        $books = Book::with(['categories', 'borrowedBooks'])->paginate(9);
        return view('pages.books.index', compact('books'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('pages.books.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "title" => "required|string",
            "author" => "required|string",
            'published_year'   => 'required|max:50',
            "categories" => "required|array", // menerima array kategori
        "categories.*" => "exists:categories,id_category", // pastikan kategori valid
        ]);



        $book = Book::create($validatedData);
        // relasikan dengan kategori yang dipilih
        $book->categories()->attach($validatedData["categories"]);


        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil ditambah.']);
        }
    }

    public function edit(Book $book)
    {
        $categories = Category::all();

        return view('pages.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title'   => 'required|string|max:20',
            'author'   => 'required|string|max:50',
            'published_year'   => 'required|max:50',
            "categories" => "required|array", // menerima array kategori
            "categories.*" => "exists:categories,id_category", // pastikan kategori valid
        ]);

        $book->update($validatedData);
                // relasikan dengan kategori yang dipilih
        $book->categories()->sync($validatedData["categories"]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diupdate.', 'data' => $book]);
        }

    }

    public function destroy(Book $book)
    {
        $book->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }
    }

    // api
    public function apiIndex()
    {
        try {
            $books = Book::select('id_book', 'title', 'author')->get();

            return response()->json([
                'status' => 200,
                'data' => $books
            ]);
        } catch (\Throwable $th) {
           return response()->json([
            'status' => 500,
            'message' => 'Something went wrong'
           ]);
        }
    }
}
