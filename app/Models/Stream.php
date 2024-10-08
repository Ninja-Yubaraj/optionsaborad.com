<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        "label"
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
}
