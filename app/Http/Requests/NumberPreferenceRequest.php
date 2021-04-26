<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NumberPreferenceRequest extends FormRequest {
    
    public function authorize() {
        // TODO: Verify this line:
        return true;
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
