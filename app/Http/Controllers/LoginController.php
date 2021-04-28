<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    
    public function index() {
        if (Auth::check()) {
            return redirect()->route('admin');
        } else {
            return view('login');
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
