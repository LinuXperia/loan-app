<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatecustomerWorkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_work_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('employer')->nullable();
            $table->string('years');
            $table->string('address');
            $table->string('phone');
            $table->string('occupation')->nullable();
            $table->string('tenure')->nullable();
            $table->string('previous_employer')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_work_details');
    }
}
