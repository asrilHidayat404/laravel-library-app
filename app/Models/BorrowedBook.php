<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;
    protected $primaryKey =  'id_borrowed_book';
    protected $fillable = [
        "book_id",
        'member_id',
        'borrowed_date',
        'due_date',
        'returned_date',
        'status',
    ];

        // 🧠 Tambahkan ini agar tanggal otomatis jadi Carbon instance
    protected $casts = [
        'borrowed_date' => 'datetime',
        'due_date' => 'datetime',
        'returned_date' => 'datetime',
    ];


    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id_book');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id_member');
    }
}
