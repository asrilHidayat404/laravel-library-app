<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_role';
    protected $fillable = [
        'role_name',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id_role');
    }
}
