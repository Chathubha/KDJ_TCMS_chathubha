<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_time', 'end_time', 'order'];

    protected $casts = ['start_time' => 'datetime:H:i', 'end_time' => 'datetime:H:i'];

    public function schedules() { return $this->hasMany(Schedule::class); }
}
