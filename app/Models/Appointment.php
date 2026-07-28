<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'service_id', 'preferred_date', 'preferred_time',
        'message', 'status', 'admin_notes', 'proof_of_address', 'valid_id', 'payment_proof',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime:H:i:s',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public static function hasConflict(string $date, string $time, int $excludeId = 0): bool
    {
        $query = self::where('preferred_date', $date)
            ->where('preferred_time', $time)
            ->where('status', '!=', 'cancelled');

        if ($excludeId > 0) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
