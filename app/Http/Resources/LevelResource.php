<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource {
    
    public function toArray($request) {
        return [
            'id'       => $this->id,
            'type'     => $this->type,
            'can_view' => explode(',', $this->can_view),
            'date'     => $this->created_at->format('d M Y H:m:i')
        ];
    }
}
