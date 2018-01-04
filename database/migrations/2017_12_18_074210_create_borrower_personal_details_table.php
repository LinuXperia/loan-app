<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowerPersonalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrower_personal_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('fname');
            $table->string('sname');
            $table->string('lname')->nullable;
            $table->string('nationality');
            $table->string('idNumber');
            $table->string('pin');
            $table->string('mobile');
            $table->string('telephone')->nullable;
            $table->date('dob');
            $table->string('address');
            $table->string('office')->nullable;
            $table->string('home')->nullable;
            $table->string('marital');
            $table->string('education');
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
        Schema::dropIfExists('borrower_personal_details');
    }
}
