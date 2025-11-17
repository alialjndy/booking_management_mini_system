<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'customer_name' => $this->customer_name ,
            'phone_number' => $this->phone_number ,
            'booking_date' => $this->booking_date ,
            'service_type_id' => $this->service_type_id ,
            'notes' => $this->notes ,
            'status' => $this->status ,
            'service' => new ServiceResource($this->whenLoaded('service'))
        ];
    }
}
