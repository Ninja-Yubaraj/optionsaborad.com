<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json',
    ];
}
