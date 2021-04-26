<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerModel;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller {
    
    public function getCustomers() {
        $customers = CustomerModel::all();
        return CustomerResource::collection($customers);
    }
}
