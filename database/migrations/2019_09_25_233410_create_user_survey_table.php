<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_survey', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('user_id')->nullable();
            $table->string('page_id',50)->nullable();
            $table->tinyInteger('skip')->default(0);
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_survey');
    }
}
