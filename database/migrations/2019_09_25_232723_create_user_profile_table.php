<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('user_id')->nullable();
            $table->text('location_address1')->nullable();
            $table->text('location_address2')->nullable();
            $table->string('location_city', 50)->nullable();
            $table->string('location_state', 50)->nullable();
            $table->string('location_zipcode', 20)->nullable();
            $table->string('location_country', 50)->nullable();
            $table->string('location_lat', 100)->nullable();
            $table->string('location_lng', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_profile');
    }

}
