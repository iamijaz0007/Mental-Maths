<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worksheet_id',
        'section_id',
        'total_sections',
        'completed_sections',
        'total_worksheets',
        'completed_worksheets',
        'correct_questions',
        'incorrect_questions',
        'time_spent_on_sections',
        'total_time_spent_on_worksheets',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
