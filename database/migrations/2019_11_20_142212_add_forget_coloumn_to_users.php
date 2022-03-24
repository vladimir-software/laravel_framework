<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForgetColoumnToUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->string('forget_hash')->nullable();
            $table->dateTime('forget_created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }

}
