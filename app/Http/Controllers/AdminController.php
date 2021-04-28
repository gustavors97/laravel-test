<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth');

        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }
    
    public function customers() {
        return view('admin.customers', ['title' => 'Customers', 'link' => 'customers']);
    }

    public function numbers() {
        return view('admin.numbers', ['title' => 'Numbers', 'link' => 'numbers']);
    }

    public function numbersPreferences() {
        return view('admin.preferences', ['title' => 'Numbers Preferences', 'link' => 'numbers_preferences']);
    }

    public function users() {
        return view('admin.users', ['title' => 'Users', 'link' => 'users']);
    }

    public function levels() {
        return view('admin.levels', ['title' => 'Levels', 'link' => 'levels']);
    }

    public function logs() {
        return view('admin.logs', ['title' => 'Logs', 'link' => 'logs']);
    }
}
