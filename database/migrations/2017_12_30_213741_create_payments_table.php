<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->unique()->nullable();
            $table->integer('loan_id')->unsigned();
            $table->integer('agent')->unsigned();
            $table->float('amount',8,2);
            $table->string('payment_mode');
            $table->string('cheque_no')->nullable();
            $table->string('mpesa_no')->nullable();
            $table->string('slug')->unique();
            $table->boolean('approved')->nullable()->default(null);
            $table->text('description');

            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
