<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller {

    private $page     = 1;
    private $paginate = 10;
    private $cacheKey = 'users-list';

    // Construct method
    public function __construct(Request $request) {
        $this->page     = ($request->page ?? 1);
        $this->paginate = ($request->paginate ?? 10);
    }

    // Get all users paginated result
    public function index(Request $request) {
        $users = Cache::remember("$this->cacheKey-$this->page-$this->paginate", env("CACHE_TIME", 5), function () {
            return User::paginate($this->paginate);
        });

        return UserResource::collection($users);
    }
    
    // Get all users
    public function getUsers(Request $request) {
        $users = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () {
            return User::all();
        });

        return UserResource::collection($users);
    }

    // Get an specific user
    public function getUserByID($id) {
        $user = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () use ($id) {
            return User::find($id);
        });

        return UserResource::collection([$user]);
    }

    // Create a new user
    public function create(UserRequest $request) {
        $user = User::create($request->all());
        return $this->response($user, 'create');
    }

    // Update an exists user
    public function update(UserRequest $request) {
        $user = User::find($request->id)
                    ->update($request->all());

        return $this->response($user, 'update');
    }

    public function delete(Request $request) {
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            $user = User::find($request->id)
                        ->delete();
        }

        return $this->response(($user ?? null), 'delete');
    }

    // Default response
    private function response($model, $method) {
        if ($model) {
            Cache::forget($this->cacheKey);
            Cache::forget("$this->cacheKey-$this->page-$this->paginate");

            return response()->json([
                'data' => [
                    'status'  => true,
                    'message' => 'User '.$method.'d with success!'
                ]
            ]);

        } else {
            return response()->json([
                'data' => [
                    'status'  => false,
                    'message' => "Failed to $method user!"
                ]
            ]);
        }
    }
}
