<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class NumberPreferenceRequest extends FormRequest {
    
    public function authorize() {
        // Authorized only admin users
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            return true;
        }

        return false;
    }

    public function rules() {
        return [
            'number_id' => 'bail|required|numeric',
            'name'      => 'bail|required|max:255',
            'value'     => 'bail|required|max:255'
        ];
    }

    public function messages() {
        return [
            'number_id.required'  => 'The number_id field is required!',
            'number_id.numeric'   => 'The number_id field must be of the numeric type!',

            'name.required'     => 'The name field is required!',
            'name.max'          => 'The content of the name field is too large!',

            'document.required' => 'The document field is required!',
            'document.max'      => 'The content of the document field is too large!'
        ];        
    }
}
