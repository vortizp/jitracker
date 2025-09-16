<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'milestone_id',
        'name',
        'order',
        'description',
    ];

    protected static function booted()
    {
        static::created(function ($activity) {
            // Attach this activity to all existing students
            $studentIds = Student::pluck('id');
            $activity->students()->attach($studentIds, [
                'completed' => false,
                'completed_at' => null,
            ]);
        });
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_activity')
            ->withPivot('completed', 'completed_at')
            ->withTimestamps();
    }
    
}
