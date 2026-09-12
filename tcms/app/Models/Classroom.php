<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'section', 'capacity', 'academic_year', 'class_teacher_id'];

    public function classTeacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_class')
            ->withPivot('academic_year', 'enrolled_at')
            ->withTimestamps();
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . '-' . $this->section;
    }
}
