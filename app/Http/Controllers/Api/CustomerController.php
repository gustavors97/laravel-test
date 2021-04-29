<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller {

    private $page     = 1;
    private $paginate = 10;
    private $cacheKey = 'customers-list';

    // Construct method
    public function __construct(Request $request) {
        $this->page     = ($request->page ?? 1);
        $this->paginate = ($request->paginate ?? 10);
    }
    
    // Get all customers paginated result
    public function index(Request $request) {
        $customers = Cache::remember("$this->cacheKey-$this->page-$this->paginate", env("CACHE_TIME", 5), function () {
            return Customer::paginate($this->paginate);
        });

        return CustomerResource::collection($customers);
    }

    // Get all customers
    public function getCustomers(Request $request) {
        $customers = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () {
            return Customer::all();
        });

        return CustomerResource::collection($customers);
    }

    // Get an specific customer
    public function getCustomerByID($id) {
        $customer = Cache::remember($this->cacheKey, env("CACHE_TIME", 5), function () use ($id) {
            return Customer::find($id);
        });

        return CustomerResource::collection([$customer]);
    }

    // Create a new customer
    public function create(CustomerRequest $request) {
        dd($request->all());

        $customer = Customer::create($request->all());
        return $this->response($customer, 'create');
    }

    // Update an exists customer
    public function update(CustomerRequest $request) {
        $customer = Customer::find($request->id)
                            ->update($request->all());

        return $this->response($customer, 'update');
    }

    // Delete an exists customer
    public function delete(Request $request) {
        if (auth()->check() && Gate::allows('access-admin', auth()->user())) {
            $customer = Customer::find($request->id)
                                ->delete();
        }

        return $this->response(($customer ?? null), 'delete');
    }

    // Default response
    private function response($model, $method) {
        if ($model) {
            Cache::forget($this->cacheKey);
            Cache::forget("$this->cacheKey-$this->page-$this->paginate");

            return response()->json([
                'data' => [
                    'status'  => true,
                    'message' => 'Customer '.$method.'d with success!'
                ]
            ]);

        } else {
            return response()->json([
                'data' => [
                    'status'  => false,
                    'message' => "Failed to $method customer!"
                ]
            ]);
        }
    }
}
