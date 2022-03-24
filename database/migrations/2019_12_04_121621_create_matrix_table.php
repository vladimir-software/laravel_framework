<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrixTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('matrix', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('match_category')->nullable();
            $table->string('match_sub_category')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('matrix');
    }

}
