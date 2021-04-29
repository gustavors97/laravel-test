<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    
    public function toArray($request) {
        $levels = [];

        foreach ($this->userLevels as $userLevel) {
            $levels[] = [
                'id'       => $userLevel->level->id,
                'type'     => $userLevel->level->type,
                'can_view' => $userLevel->level->can_view,
                'date'     => $userLevel->level->created_at->format('d M Y H:m:i')
            ];
        }

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'image'     => $this->image,
            'date'      => $this->created_at->format('d M Y H:m:i'),
            'levels'    => $levels
        ];
    }
}
