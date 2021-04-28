<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email'    => 'bail|required',
            'password' => 'bail|required'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'The email field is required!',
            'password.required' => 'The password field is required!'
        ];
    }
}
