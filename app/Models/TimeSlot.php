<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['slot_time', 'is_available'];

    protected $casts = ['is_available' => 'boolean'];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->orderBy('slot_time');
    }
}
