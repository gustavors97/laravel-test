<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration {
    
    // Structure of the table LEVELS
    public function up() {
        Schema::create('levels', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('levels');
    }
}
