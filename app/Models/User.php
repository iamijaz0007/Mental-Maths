<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'date_of_birth',
        'profile_pic',
        'role',
        'phone',
        'occupation',
        'child_id',
        'school_id',
        'parent_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getEmailSingle($email)
    {
        return self::where('email', '=', $email)->first();
    }


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function worksheetProgress()
    {
        return $this->hasMany(StudentWorksheetProgress::class, 'user_id');
    }

    public function errorReports()
    {
        return $this->hasMany(ErrorReport::class, 'user_id');
    }

    public function worksheets()
    {
        return $this->belongsToMany(Worksheet::class, 'student_worksheet', 'user_id', 'worksheet_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_student');
    }


}
