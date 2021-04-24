<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NumbersRequest extends FormRequest {
        
    public function authorize() {
        // TODO: Verify this line:
        return true;
    }

    public function rules() {
        return [
            'customer_id'   => 'bail|required|numeric',
            'number'        => 'bail|required|min:8|max:14',
            'status'        => 'bail|required'
        ];
    }

    public function messages() {
        return [
            'customer_id.required'  => 'The customer_id field is required!',
            'customer_id.numeric'   => 'The customer_id field must be of the numeric type!',

            'number.required'       => 'The number field is required!',
            'number.min'            => 'The content of the number field does not have the minimum number of characters required!',
            'number.max'            => 'The content of the number field is too large!',

            'status.required'       => 'The status field is required!'
        ];
    }
}
