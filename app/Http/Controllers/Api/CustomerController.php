<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller {
    
    public function getCustomers(Request $request) {
        $customers = Customer::paginate($request->paginate ?? 10);
        return CustomerResource::collection($customers);
    }
}
