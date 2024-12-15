<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff_provinces extends Model
{
   
    protected $fillable = [
        'user_id',
        'province',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
