<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumbersPreferencesTable extends Migration {
    
    public function up() {
        Schema::create('numbers_preferences', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('number_id');
            $table->foreign('number_id')->references('id')->on('numbers');
            $table->string('name', 255);
            $table->string('value', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('numbers_preferences');
    }
}
