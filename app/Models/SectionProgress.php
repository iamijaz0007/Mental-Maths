<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worksheet_id',
        'section_id',
        'completed',
        'time_taken',
    ];
}
