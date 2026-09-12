<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['classroom_id', 'subject_id', 'teacher_id', 'period_id', 'day'];

    public function classroom(): BelongsTo { return $this->belongsTo(Classroom::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function teacher(): BelongsTo { return $this->belongsTo(Teacher::class); }
    public function period(): BelongsTo { return $this->belongsTo(Period::class); }
}
