<?php

namespace Database\Factories;

use App\Models\Number;
use Illuminate\Database\Eloquent\Factories\Factory;

class NumberFactory extends Factory {
    
    protected $model = Number::class;

    public function definition() {
        return [
            'customer_id' => 1,
            'number'      => $this->faker->numerify('##############'),
            'status'      => 'active'
        ];
    }
}
