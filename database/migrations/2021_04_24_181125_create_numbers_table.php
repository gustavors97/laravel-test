<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumbersTable extends Migration {
    
    public function up() {
        Schema::create('numbers', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInt('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('number', 14);
            $table->enum('status', ['active', 'inactive', 'cancelled'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('numbers');
    }
}
