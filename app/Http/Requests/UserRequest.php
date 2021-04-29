<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {

    public function authorize() {
        // Authorized only admin users
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            return true;
        }

        return false;
    }

    public function rules() {
        if ($this->getMethod() == 'POST') { // CREATE
            return [
                'name'     => 'bail|required',
                'email'    => 'bail|required|unique:users,email',
                'password' => 'bail|required',
                'image'    => 'bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048'
            ];

        } else {    // UPDATE (not require password)
            return [
                'name'  => 'bail|required',
                'image' => 'bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048'
            ];
        }
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
