<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;

class CustomerTest extends TestCase {
    
    public function test_create_customer() {
        $customer = Customer::factory()->make();
        
        if ($customer) 
            $this->assertTrue(true);
        else
            $this->assertTrue(false);
    }
}
