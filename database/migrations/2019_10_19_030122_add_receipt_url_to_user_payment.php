<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceiptUrlToUserPayment extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('user_payments', function (Blueprint $table) {
            $table->string('receipt_url')->nullable()->after('stripe_payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('user_payments', function (Blueprint $table) {
            //
        });
    }

}
