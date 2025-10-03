<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $categories = [
            'Fiction',
            'Non-Fiction',
            'Science',
            'Technology',
            'History',
        ];

        foreach ($categories as $name) {
            Category::create([
                'category_name' => $name
            ]);
        }
    }
}
