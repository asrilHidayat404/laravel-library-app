<?php

namespace Database\Seeders;

use App\Models\BorrowedBook;
use Illuminate\Database\Seeder;


class BorrowedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // Book Loans (random member & book)
        for ($i = 1; $i <= 30; $i++) {
            $isReturned = rand(0, 1); // 0 = belum dikembalikan, 1 = sudah

            $borrowedDate = now()->subDays(rand(1, 10));
            $dueDate = $borrowedDate->copy()->addDays(7); // misal tempo 7 hari

            $returnedDate = $isReturned ? $borrowedDate->copy()->addDays(rand(1, 7)) : null;

            BorrowedBook::create([
                'member_id'     => rand(1, 10),
                'book_id'       => rand(1, 20),
                'borrowed_date' => $borrowedDate,
                'due_date'      => $dueDate,
                'returned_date' => $returnedDate,
                'status'        => $isReturned ? 'returned' : 'borrowed',
            ]);
        }
    }
}
