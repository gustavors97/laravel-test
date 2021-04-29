<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NumberResource extends JsonResource {

    public function toArray($request) {
        return [
            'id'          => $this->id,
            'customer_id' => $this->customer_id,
            'customer'    => $this->customer->name,
            'number'      => $this->number,
            'status'      => $this->status,
            'date'        => $this->created_at->format('d M Y H:m:i')
        ];
    }
}
