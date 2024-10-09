<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'worksheet_id', 'question_id', 'answer', 'is_correct'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
