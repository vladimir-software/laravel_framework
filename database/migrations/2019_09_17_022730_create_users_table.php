<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->nullable();
            $table->string('username', 100)->nullable();
            $table->string('fullname', 100)->nullable();
            $table->string('email')->unique();
            $table->string('mobile_number', 30)->nullable();
            $table->string('password');
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('approval')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
