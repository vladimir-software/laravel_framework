<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('stripe_charge')->nullable();
            $table->string('stripe_transaction')->nullable();
            $table->string('stripe_customer')->nullable();
            $table->string('amount')->nullable();
            $table->string('stripe_payment_status')->nullable();
            $table->string('country', 10)->nullable();
            $table->string('exp_month', 10)->nullable();
            $table->string('exp_year', 10)->nullable();
            $table->string('last4', 10)->nullable();
            $table->string('brand', 50)->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('status')->default('0')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_payments');
    }

}
