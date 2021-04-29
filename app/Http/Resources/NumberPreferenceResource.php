<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NumberPreferenceResource extends JsonResource {
    
    public function toArray($request) {
        return [
            'id'        => $this->id,
            'number'    => [
                'id'     => $this->number->id,
                'number' => $this->number->number
            ],
            'customer'  => [
                'name' => $this->number->customer->name
            ],
            'name'      => $this->name,
            'value'     => $this->value,
            'date'      => $this->created_at->format('d M Y H:m:i')
        ];
    }
}
