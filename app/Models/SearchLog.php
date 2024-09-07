<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'backlogs',
        'study_gap',
        'exam',
        'listening',
        'speaking',
        'reading',
        'writing',
        'percentage',
        'user_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
