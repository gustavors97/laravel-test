<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CustomerRequest extends FormRequest {

    public function authorize() {
        // Authorized only admin users
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            return true;
        }

        return false;
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

            'image.image'       => 'Please, select an image file for send!',
            'imagem.mimes'      => 'Select an image in format: .jpg, .jpeg, .png or .gif!',
            'imagem.max'        => 'The image is too large! Max size is 2MB.',

            'status.required'   => 'The status field is required!'
        ];        
    }
}