<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectColoumnToUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('reject')->default(0)->after('approval');
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
