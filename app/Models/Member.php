<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_member';
    protected $fillable = [
        'phone_number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class, 'member_id', 'id_member');
    }
}
