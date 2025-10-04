<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_book';

    protected $fillable = [
        'title',
        'author',
        'published_year',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,      // model tujuan
            'book_category',      // nama tabel pivot
            'book_id',            // FK di pivot yang mengacu ke books
            'category_id'         // FK di pivot yang mengacu ke categories
        );
    }
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class, 'book_id', 'id_book');
    }
}
