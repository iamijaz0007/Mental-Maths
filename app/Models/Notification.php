<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Allow mass assignment for this field
        'message',  // Include other fields that are mass assignable
        'is_read',  // For example, whether the notification has been read
        'created_at', // Add any other necessary fields
        'updated_at'
    ];
}
