<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(LoginRequest $request) {
        $user = User::where('email', $request->email)
                        ->with('userLevels.level')
                        ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return response()->json([
                'status' => true,
                'user'   => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'image' => $user->image,
                    'level' => $user->userLevels[0]->level->type
                ],
                'url' => route('admin')
            ]);

        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Failed, try again!'
            ]);
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();

        return redirect()->route('home');
    }
}
