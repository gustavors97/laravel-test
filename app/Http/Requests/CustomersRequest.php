<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest {

    public function authorize() {
        // TODO: Verify this line:
        return true;
    }

    public function rules() {
        return [
            'user_id'   => 'bail|required|numeric',
            'name'      => 'bail|required|max:255',
            'document'  => 'bail|required|min:6|max:12',
            'status'    => 'bail|required'
        ];
    }

    public function messages() {
        return [
            'user_id.required'  => 'The user_id field is required!',
            'user_id.numeric'   => 'The user_id field must be of the numeric type!',

            'name.required'     => 'The name field is required!',
            'name.max'          => 'The content of the name field is too large!',

            'document.required' => 'The document field is required!',
            'document.min'      => 'The content of the document field does not have the minimum number of characters required!',
            'document.max'      => 'The content of the document field is too large!',

            'status.required'   => 'The status field is required!'
        ];        
    }
}