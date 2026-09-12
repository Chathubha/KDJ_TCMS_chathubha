<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['fee_id', 'student_id', 'amount_paid', 'payment_date', 'payment_method', 'receipt_number', 'remarks', 'received_by'];

    protected $casts = ['amount_paid' => 'decimal:2', 'payment_date' => 'date'];

    public function fee(): BelongsTo { return $this->belongsTo(Fee::class); }
    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function receiver(): BelongsTo { return $this->belongsTo(User::class, 'received_by'); }
}
