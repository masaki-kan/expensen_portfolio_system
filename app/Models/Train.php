<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'date', 'image', 'subject', 'status', 'visit', 'reason', 'money', 'applicant_flag', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function realtrains()
    {
        return $this->hasMany(User::class);
    }
}
