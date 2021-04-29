<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserRequest extends FormRequest {

    public function authorize() {
        // Authorized only admin users
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            return true;
        }

        return false;
    }

    public function rules() {
        return [
            'name'     => 'bail|required',
            'email'    => 'bail|required|unique',
            'password' => 'bail|required',
            'image'     => 'bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048'
        ];
    }

    public function messages() {
        return [
            'name.required'     => 'The name field is required!',

            'email.required'    => 'The password field is required!',
            'email.unique'      => 'Email must be a unique, try another email!',

            'password.required' => 'The password field is required!',

            'image.image'       => 'Please, select an image file for send!',
            'imagem.mimes'      => 'Select an image in format: .jpg, .jpeg, .png or .gif!',
            'imagem.max'        => 'The image is too large! Max size is 2MB.'
        ];
    }
}
