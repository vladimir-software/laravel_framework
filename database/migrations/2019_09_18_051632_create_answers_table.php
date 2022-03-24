<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('question_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('question_type_id')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('answers');
    }

}
