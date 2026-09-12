<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_id', 'classroom_id', 'date', 'max_marks', 'weight'];

    protected $casts = ['date' => 'date'];

    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function classroom(): BelongsTo { return $this->belongsTo(Classroom::class); }
    public function grades(): HasMany { return $this->hasMany(Grade::class); }
}
