<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Number;
use App\Http\Resources\NumberResource;
use App\Http\Requests\NumberRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Api\NumberPreferenceController;

class NumberController extends Controller {

    private $page     = 1;
    private $paginate = 10;
    private $cacheKey = 'numbers-list';

    // Construct method
    public function __construct(Request $request) {
        $this->page     = ($request->page ?? 1);
        $this->paginate = ($request->paginate ?? 10);
    }

    // Get all numbers paginated result
    public function index(Request $request) {
        $numbers = Cache::remember("$this->cacheKey-$this->page-$this->paginate", env("CACHE_TIME", 5), function () {
            return Number::paginate($this->paginate);
        });

        return NumberResource::collection($numbers);
    }

    // Get all numbers
    public function getNumbers(Request $request) {
        $numbers = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () {
            return Number::all();
        });

        return NumberResource::collection($numbers);
    }

    // Get an specific number
    public function getNumberByID($id) {
        $number = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function ($id) {
            return Number::find($id);
        });

        return NumberResource::collection([$number]);
    }

    // Create a new number
    public function create(NumberRequest $request) {
        $number = Number::create($request->all());

        if ($number)
            $number_preferences = NumberPreferenceController::createDefaultPreferences($number);

        if ($number_preferences) 
            return $this->response($number, 'create');
        else 
            return $this->response(null, 'create');
    }

    // Update an exists number
    public function update(NumberRequest $request) {
        $number = Number::find($request->id)
                        ->update($request->all());

        return $this->response($number, 'update');
    }

    // Delete an exists number
    public function delete(Request $request) {
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            $number = Number::find($request->id)->delete();
            NumberPreferenceController::deleteByNumberID($request->id); // Delete Number Preference
        }

        return $this->response(($number ?? null), 'delete');
    }

    // Delete old values in number when customer is removed
    public static function deleteByCustumerID($customer_id) {
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            $numbers = Number::where('customer_id', $customer_id)->get();

            foreach ($numbers as $number) {
                NumberPreferenceController::deleteByNumberID($number->id);
                $number->delete();
            }
        }

        return false;
    }

    // Default response
    private function response($model, $method) {
        if ($model) {
            Cache::forget($this->cacheKey);
            Cache::forget("$this->cacheKey-$this->page-$this->paginate");

            return response()->json([
                'data' => [
                    'status'  => true,
                    'message' => 'Number '.$method.'d with success!'
                ]
            ]);

        } else {
            return response()->json([
                'data' => [
                    'status'  => false,
                    'message' => "Failed to $method number!"
                ]
            ]);
        }
    }
}
