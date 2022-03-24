<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->nullable();
            $table->string('fullname', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile_number', 30)->nullable();
            $table->string('profile_img')->nullable();
            $table->string('address')->nullable();
            $table->string('address1')->nullable();
            $table->string('location_city', 50)->nullable();
            $table->string('location_state', 50)->nullable();
            $table->string('location_zipcode', 20)->nullable();
            $table->string('location_country', 50)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('providers');
    }

}
