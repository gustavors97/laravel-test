<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

            $levels   = '';
            $can_view = '';

            foreach ($user->userLevels as $userLevel) {
                if ($userLevel->level->type) {
                    $levels .= $userLevel->level->type.',';
                }

                if ($userLevel->level->can_view) {
                    $can_view .= $userLevel->level->can_view.',';
                }
            }

            return response()->json([
                'status' => true,
                'user'   => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'image'    => $user->image,
                    'levels'   => array_unique(array_filter(explode(',', $levels))),
                    'can_view' => array_unique(array_filter(explode(',', $can_view)))
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
