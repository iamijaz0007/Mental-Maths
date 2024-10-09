<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];


    public function principal()
    {
        return $this->hasOne(User::class)->where('role', 'principal');
    }
}
