<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('title', 150)->nullable();
            $table->string('location')->nullable();
            $table->string('location1')->nullable();
            $table->string('location_city', 50)->nullable();
            $table->string('location_state', 50)->nullable();
            $table->string('location_zipcode', 20)->nullable();
            $table->string('location_country', 50)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('services');
    }

}
