<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'service_name'     => $this->service_name,
            'description'      => $this->description,
            'price'            => (float) $this->price,
            'duration_minutes' => $this->duration_minutes,
            'status'           => $this->status,
        ];
    }
}
