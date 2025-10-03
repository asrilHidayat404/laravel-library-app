<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_category';

    protected $fillable = [
        'category_name'
    ];

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'book_category',   // nama tabel pivot
            'category_id',     // FK di pivot yang mengacu ke categories
            'book_id'          // FK di pivot yang mengacu ke books
        );
    }
}
