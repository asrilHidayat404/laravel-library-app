<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\BorrowedBook;

class SendBorrowEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $borrowedBook;

    public function __construct(BorrowedBook $borrowedBook)
    {
        $this->borrowedBook = $borrowedBook;
    }

    public function handle(): void
    {
        $user = $this->borrowedBook->member->user;

        Mail::raw(
            "Halo {$user->name}, kamu baru saja meminjam buku '{$this->borrowedBook->book->title}'.\nTanggal pengembalian: {$this->borrowedBook->due_date->format('d M Y')}.",
            function ($msg) use ($user) {
                $msg->to($user->email)
                    ->subject('Notifikasi Peminjaman Buku');
            }
        );
    }
}
