<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'city_id',
        'institute_id',
        'campus_id',
        'app_fees_cad',
        'program_code',
        'program_name',
        'program_level_id',
        'duration_id',
        'intake_id',
        'conditional',
        'co_op',
        'co_op_duration',
        'fees',
        'ave_tat_bucket_in_days',
        // 'degree_id',
        // 'stream_id',
        'cgpa_bucket',
        'percentage_bucket',
        'study_gap',
        'backlogs',
        'moi_accepted',
        'exam',
        'special_requirements',
        'program_link',
        'user_id',
    ];

    protected $casts = [
        'app_fees_cad' => 'decimal:2',
        'conditional' => 'boolean',
        'co_op' => 'boolean',
        'fees' => 'decimal:2',
        'moi_accepted' => 'boolean',
        'exam' => 'array',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    // public function degree()
    // {
    //     return $this->belongsTo(Degree::class);
    // }

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }

    // public function stream()
    // {
    //     return $this->belongsTo(Stream::class);
    // }

    public function degrees()
    {
        return $this->belongsToMany(Degree::class, 'program_degree');
    }

    public function streams()
    {
        return $this->belongsToMany(Stream::class, 'program_stream');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(ProgramLevel::class, "program_level_id");
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class);
    }
}
