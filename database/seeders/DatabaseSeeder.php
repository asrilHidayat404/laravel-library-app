<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MemberSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            BorrowedBookSeeder::class,
        ]);
    }
}
