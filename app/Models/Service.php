<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_name', 'speed', 'description', 'duration_minutes', 'price', 'installation_fee', 'status'];

    protected $casts = [
        'price'            => 'decimal:2',
        'installation_fee' => 'decimal:2',
        'duration_minutes' => 'integer',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
