<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'amount', 'classroom_id', 'academic_year', 'type', 'due_date'];

    protected $casts = ['amount' => 'decimal:2', 'due_date' => 'date'];

    public function classroom(): BelongsTo { return $this->belongsTo(Classroom::class); }
    public function payments(): HasMany { return $this->hasMany(Payment::class); }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments->sum('amount_paid');
    }

    public function getBalanceAttribute(): float
    {
        return (float) $this->amount - $this->total_paid;
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->total_paid >= $this->amount;
    }

    public function getPaidPercentageAttribute(): float
    {
        return $this->amount > 0 ? round($this->total_paid / $this->amount * 100, 1) : 0;
    }
}
