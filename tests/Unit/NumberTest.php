<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Number;

class NumberTest extends TestCase {
    
    public function test_create_number() {
        $number = Number::factory()->make();

        if ($number)
            $this->assertTrue(true);
        else 
            $this->assertTrue(false);
    }
}
