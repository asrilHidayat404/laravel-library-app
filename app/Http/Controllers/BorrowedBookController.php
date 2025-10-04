<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use App\Jobs\SendBorrowEmail;
use Illuminate\Support\Facades\Mail;
use App\Exports\BorrowerExport;
use Maatwebsite\Excel\Facades\Excel;



class BorrowedBookController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax()) {
            $search = $request->input('str', '');

            $query = BorrowedBook::with(['book', 'member.user'])
                ->whereHas('book', function($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%");
                });

            // Jika member, batasi hanya data miliknya
            if ($user->role->role_name === 'member') {
                $query->whereHas('member', function($q) use ($user) {
                    $q->where('user_id', $user->id_user);
                });
            }

            $borrowedBooks = $query->get();

            return response()->json(['borrowedBooks' => $borrowedBooks]);
        }

        $query = BorrowedBook::with(['book', 'member.user']);

        if ($user->role->role_name === 'member') {
            $query->whereHas('member', function($q) use ($user) {
                $q->where('user_id', $user->id_user);
            });
        }

        $borrowedBook = $query->paginate(10);

        return view('pages.borrowedBook.index', compact('borrowedBook'));
    }

    public function store(Book $book)
    {
        $borrowedBook = BorrowedBook::create([
            'book_id' => $book->id_book,
            'member_id' => auth()->user()->member->id_member,
            'borrowed_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'borrowed',
        ]);
         $user = auth()->user();
        Mail::raw("Halo {$user->name}, kamu baru saja meminjam buku '{$book->title}'.\nTanggal pengembalian: {$borrowedBook->due_date->format('d M Y')}.", function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject('Notifikasi Peminjaman Buku');
        });
        // SendBorrowEmail::dispatch($borrowedBook);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Berhasil meminjam buku.']);
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:borrowed,returned',
        ]);

        $borrowed = BorrowedBook::findOrFail($id);
        $borrowed->status = $request->status;
        $borrowed->save();

        return response()->json([
            'success' => true,
            'status' => $borrowed->status,
            'message' => 'Status berhasil diupdate'
        ]);
    }

    public function destroy(BorrowedBook $borrowedBook)
    {
        $borrowedBook->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }
    }

    // export

    public function export()
    {
        return Excel::download(new BorrowerExport, 'data_peminjaman.xlsx');
    }

    // api
    public function apiStore(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id_book',
                'member_id' => 'required|exists:members,id_member',
            ]);

            $borrowed = BorrowedBook::create([
                'book_id' => $request->book_id,
                'member_id' => $request->member_id,
                'borrowed_date' => now(),
                'due_date' => now()->addDays(7),
                'status' => 'borrowed',
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Peminjaman berhasil dibuat',
                'data' => $borrowed
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
            'status' => 500,
            'message' => 'Somtehing went wrong'
           ]);
        }
    }

    public function apiShow($id)
    {
        try {
            $borrowed = BorrowedBook::with(['book', 'member.user'])->findOrFail($id);

            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $borrowed->id_borrowed_book,
                    'book_title' => $borrowed->book->title,
                    'borrower_name' => $borrowed->member->user->username,
                    'borrowed_date' => $borrowed->borrowed_date,
                    'due_date' => $borrowed->due_date,
                    'status' => $borrowed->status,
                ]
            ]);
        } catch (\Throwable $th) {
           return response()->json([
            'status' => 500,
            'message' => 'Something went wrong'
           ]);
        }

    }

}
