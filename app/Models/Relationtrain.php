<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationtrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'line', 'ride', 'getoff', 'money', 'status', 'hantei', 'type', 'memo'
    ];

    public function realtrain()
    {
        return $this->belongsTo(Realtrain::class);
    }
}
