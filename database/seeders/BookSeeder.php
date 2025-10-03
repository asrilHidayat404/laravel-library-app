<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // Seeder Buku (20 buku)
        for ($i = 1; $i <= 20; $i++) {
            Book::create([
                'title'          => "Book $i",
                'author'         => "Author $i",
                'published_year' => rand(1990, 2023),
            ]);
        }
    }
}
