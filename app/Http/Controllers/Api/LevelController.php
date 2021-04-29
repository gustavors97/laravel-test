<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Http\Resources\LevelResource;
use App\Http\Requests\LevelRequest;
use Illuminate\Support\Facades\Gate;

class LevelController extends Controller {

    private $page     = 1;
    private $paginate = 10;
    private $cacheKey = 'levels-list';

    // Construct method
    public function __construct(Request $request) {
        $this->page     = ($request->page ?? 1);
        $this->paginate = ($request->paginate ?? 10);
    }

    // Get all levels paginated result
    public function index(Request $request) {
        $levels = Cache::remember("$this->cacheKey-$this->page-$this->paginate", env("CACHE_TIME", 5), function () {
            return Level::paginate($this->paginate);
        });

        return LevelResource::collection($levels);
    }
    
    // Get all levels
    public function getLevels(Request $request) {
        $levels = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () {
            return Level::all();
        });

        return LevelResource::collection($levels);
    }

    // Get an specific level
    public function getLevelByID($id) {
        $level = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () use ($id) {
            return Level::find($id);
        });

        return LevelResource::collection([$level]);
    }

    // Create a new level
    public function create(LevelRequest $request) {
        $level = Level::create($request->all());
        return $this->response($level, 'create');
    }

    // Update an exists level
    public function update(LevelRequest $request) {
        $level = Level::find($request->id)
                      ->update($request->all());

        return $this->response($level, 'update');
    }

    // Delete an exists level
    public function delete(Request $request) {
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            $level = Level::find($request->id)
                          ->delete();
        }

        return $this->response(($level ?? null), 'delete');
    }

    // Default response
    private function response($model, $method) {
        if ($model) {
            Cache::forget($this->cacheKey);
            Cache::forget("$this->cacheKey-$this->page-$this->paginate");

            return response()->json([
                'data' => [
                    'status'  => true,
                    'message' => 'Level '.$method.'d with success!'
                ]
            ]);

        } else {
            return response()->json([
                'data' => [
                    'status'  => false,
                    'message' => "Failed to $method level!"
                ]
            ]);
        }
    }
}
