<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class LevelRequest extends FormRequest {
    
    public function authorize() {
        // Authorized only admin users
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            return true;
        }

        return false;
    }

    public function rules() {
        return [
            'type'  => 'bail|required|max:255',
            'level' => 'bail|required|max:255'
        ];
    }

    public function messages() {
        return [
            'type.required' => 'The type field is required!',
            'type.max'      => 'The content of the type field is too large!',

            'can_view.required' => 'The can_view field is required!',
            'can_vide.max'      => 'The content of the can_view field is too large!',
        ];
    }
}
