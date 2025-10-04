<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Jalankan seeder buku.
     */
    public function run(): void
    {
        // Pastikan sudah ada kategori di database
        if (Category::count() === 0) {
            $categories = ['Novel', 'Fiksi', 'Teknologi', 'Sejarah', 'Bisnis', 'Pendidikan'];
            foreach ($categories as $name) {
                Category::create(['category_name' => $name]);
            }
        }

        $categoryIds = Category::pluck('id_category')->toArray();

        // Buat 20 buku dan attach kategori secara acak
        for ($i = 1; $i <= 20; $i++) {
            $book = Book::create([
                'title'          => "Book $i",
                'author'         => "Author $i",
                'published_year' => rand(1990, 2023),
            ]);

            // Pilih 1–3 kategori acak untuk tiap buku
            $randomCategories = collect($categoryIds)->random(rand(1, 3))->toArray();
            $book->categories()->attach($randomCategories);
        }
    }
}
