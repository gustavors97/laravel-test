<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Number;
use App\Models\NumberPreference;
use App\Http\Resources\NumberPreferenceResource;
use App\Http\Requests\NumberPreferenceRequest;
use Illuminate\Support\Facades\Gate;

class NumberPreferenceController extends Controller {

    private $page     = 1;
    private $paginate = 10;
    private $cacheKey = 'numbers-preferences-list';

    // Construct method
    public function __construct(Request $request) {
        $this->page     = ($request->page ?? 1);
        $this->paginate = ($request->paginate ?? 10);
    }

    // Get all numbers preferences paginated result
    public function index(Request $request) {
        $numbersPreferences = Cache::remember("$this->cacheKey-$this->page-$this->paginate", env("CACHE_TIME", 5), function () {
            return NumberPreference::paginate($this->paginate);
        });

        return NumberPreferenceResource::collection($numbersPreferences);
    }
    
    // Get all numbers preferences
    public function getNumbersPreferences(Request $request) {
        $numbersPreferences = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () {
            return NumberPreference::all();
        });

        return NumberPreferenceResource::collection($numbersPreferences);
    }

    // Get an specific number preference
    public function getNumberByID($id) {
        $numberPreference = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () use ($id) {
            return NumberPreference::find($id);
        });

        return NumberPreferenceResource::collection([$numberPreference]);
    }

    // Create a new number preference
    public function create(NumberPreferenceRequest $request) {
        $numberPreference = NumberPreference::create($request->all());
        return $this->response($numberPreference, 'create');
    }

    // TODO: Test
    public static function createDefaultPreferences(Number $number) {
        $numbersPreferences = NumberPreference::insert(
            [
                'number_id' => $number->id,
                'name'      => 'auto_attendant',
                'value'     => '1'
            ],
            [
                'number_id' => $number->id,
                'name'      => 'voicemail_enabled',
                'value'     => '1'
            ]
        );

        return $numbersPreferences;
    }

    // Update an exists number preference
    public function update(NumberPreferenceRequest $request) {
        $numberPreference = NumberPreference::find($request->id)
                                            ->update($request->all());

        return $this->response($numberPreference, 'update');
    }

    // Delete an exists number preference
    public function delete(Request $request) {
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            $numberPreference = NumberPreference::find($request->id)
                                                ->delete();
        }

        return $this->response(($numberPreference ?? null), 'delete');
    }

    // Default response
    private function response($model, $method) {
        if ($model) {
            Cache::forget($this->cacheKey);
            Cache::forget("$this->cacheKey-$this->page-$this->paginate");

            return response()->json([
                'data' => [
                    'status'  => true,
                    'message' => 'Number preference '.$method.'d with success!'
                ]
            ]);

        } else {
            return response()->json([
                'data' => [
                    'status'  => false,
                    'message' => "Failed to $method number preference!"
                ]
            ]);
        }
    }
}
