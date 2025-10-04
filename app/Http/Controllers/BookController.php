<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

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
        return view('pages.books.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "title" => "required|string",
            "author" => "required|string",
            'published_year'   => 'required|max:50',
        ]);

        Book::create($validatedData);
               if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data berhasil ditambah.']);
        }
    }

    public function edit(Book $book)
    {
        return view('pages.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title'   => 'required|string|max:20',
            'author'   => 'required|string|max:50',
            'published_year'   => 'required|max:50',
        ]);


        $book->update($validatedData);


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
}
