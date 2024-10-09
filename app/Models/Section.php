<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['worksheet_id', 'subject', 'difficulty_level', 'questions_count'];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'section_student');
    }

    public function sectionProgress()
    {
        return $this->hasMany(SectionProgress::class, 'section_id');
    }

}
