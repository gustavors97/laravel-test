<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource {
    
    // Format the API response
    public function toArray($request) {
        return [
            'id'       => $this->id,
            'user'     => $this->user,
            'name'     => $this->name,
            'document' => $this->document,
            'status'   => $this->status
        ];
    }
}
