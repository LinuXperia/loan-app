<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('agent')->unsigned();
            $table->float('amount_borrowed', 8, 2);
            $table->float('amount_to_pay', 8, 2);
            $table->integer('duration');
            $table->float('interest_rate');
            $table->float('processing_fee', 8, 2)->default(0.00);
            $table->float('car_track', 8, 2);
            $table->float('kra', 8, 2)->default(0.00);
            $table->float('logistics', 8, 2)->default(0.00);
            $table->float('mv', 8, 2)->default(0.00);
            $table->float('discharge_fee', 8, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->boolean('approved')->nullable()->default(null);
            $table->enum('status', ['paid','unpaid','partial'])->default('unpaid');
            $table->dateTime('approved_date')->nullable();
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
