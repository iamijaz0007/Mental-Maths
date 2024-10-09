<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    use HasFactory;



    protected $fillable = ['name', 'created_by', 'status', 'total_duration', 'user_id'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }


    // Define the relationship with Question, if applicable
    public function questions()
    {
        return $this->hasManyThrough(Question::class, Section::class, 'worksheet_id', 'section_id', 'id', 'id');
    }

    public function errors()
    {
        return $this->hasMany(ErrorReport::class);
    }

    public function correctionWorksheets()
    {
        return $this->hasMany(CorrectionWorksheet::class, 'original_worksheet_id');
    }

    public function errorReports()
{
    return $this->hasMany(ErrorReport::class);
}

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_worksheet', 'worksheet_id', 'user_id');
    }


}
