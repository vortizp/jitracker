<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'nick_name',
        'email',
    ];

    protected static function booted()
    {
        static::created(function ($student) {
            // Attach this student to all existing activities
            $activityIds = Activity::pluck('id');
            $student->activities()->attach($activityIds, [
                'completed' => false,
                'completed_at' => null,
            ]);
        });
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'student_activity')
            ->withPivot('completed', 'completed_at')
            ->withTimestamps();
    }
}
