<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NumberModel;

class NumberController extends Controller {
    
    public function getNumbers() {
        return NumberModel::all();
    }
}
