<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'date', 'ride', 'getoff', 'money'
    ];

    public function usee()
    {
        return $this->belongsTo(User::class);
    }
}
