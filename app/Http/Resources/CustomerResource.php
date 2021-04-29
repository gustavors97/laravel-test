<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource {
    
    // Format the API response
    public function toArray($request) {
        $numbers = [];
        
        foreach ($this->numbers as $number) {
            $numberPreferences = [];

            foreach ($number->numberPreferences as $preferences) {
                $numberPreferences[] = [
                    'id'    => $preferences->id,
                    'name'  => $preferences->name,
                    'value' => $preferences->value
                ];
            }

            $numbers[] = [
                'id' => $number->id,
                'number' => $number->number,
                'status' => $number->status,
                'numberPreferences' => $numberPreferences
            ];
        }

        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'document' => $this->document,
            'status'   => $this->status,
            'date'     => $this->created_at->format('d M Y H:m:i'),
            'user'     => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
                'image' => $this->user->image,
            ],
            'numbers'   => $numbers
        ];
    }
}
