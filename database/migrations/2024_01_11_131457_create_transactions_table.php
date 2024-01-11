<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');


            $table->string('email', 30)->nullable();
            $table->string('name', 30)->nullable();
            $table->string('phone', 30)->nullable();
            
            $table->string('payment_description', 100)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('currency', 30)->nullable();
            $table->string('payment_name', 50)->nullable();
            $table->int('qty')->nullable()->default(0);

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
        Schema::dropIfExists('transactions');
    }
}
