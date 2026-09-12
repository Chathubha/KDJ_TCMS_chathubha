<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'exam_id', 'marks_obtained', 'remarks'];

    protected $casts = ['marks_obtained' => 'decimal:2'];

    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function exam(): BelongsTo { return $this->belongsTo(Exam::class); }
}
