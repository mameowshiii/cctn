<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['for_admin', 'client_id', 'title', 'message', 'link', 'is_read'];

    protected $casts = [
        'for_admin' => 'boolean',
        'is_read'   => 'boolean',
    ];

    public function scopeAdminUnread($query)
    {
        return $query->where('for_admin', true)->where('is_read', false);
    }

    public function scopeForAdmin($query)
    {
        return $query->where('for_admin', true)->latest()->limit(5);
    }
}
