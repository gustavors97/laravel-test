<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource {
    
    // Format the API response
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
