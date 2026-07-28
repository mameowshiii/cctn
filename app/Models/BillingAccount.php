<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillingAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'account_number', 'statement_period', 'amount_due',
        'penalty_amount', 'total_amount_due', 'status', 'due_date', 'notes', 'paid_at',
    ];

    protected $casts = [
        'due_date'        => 'date',
        'paid_at'         => 'datetime',
        'amount_due'      => 'decimal:2',
        'penalty_amount'  => 'decimal:2',
        'total_amount_due'=> 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'billing_id');
    }
}
