<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NumberResource extends JsonResource {

    public function toArray($request) {
        return [
            'id'          => $this->id,
            'customer'    => [
                'id'   => $this->customer->id,
                'name' => $this->customer->name
            ],
            'number'      => $this->number,
            'status'      => $this->status,
            'date'        => $this->created_at->format('d M Y H:m:i')
        ];
    }
}
