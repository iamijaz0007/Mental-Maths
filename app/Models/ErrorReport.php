<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorReport extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'worksheet_id', 'error_message', 'status', 'admin_response'];

    public function student()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function worksheet()
{
    return $this->belongsTo(Worksheet::class);
}

}
