<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'account_number'   => $this->account_number,
            'statement_period' => $this->statement_period,
            'amount_due'       => (float) $this->amount_due,
            'penalty_amount'   => (float) $this->penalty_amount,
            'total_amount_due' => (float) $this->total_amount_due,
            'status'           => $this->status,
            'due_date'         => $this->due_date?->format('Y-m-d'),
            'paid_at'          => $this->paid_at?->toIso8601String(),
            'notes'            => $this->notes,
        ];
    }
}
