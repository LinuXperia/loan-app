<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoanTypeColumnToLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('car_track');
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->string('car_track_installation');
            $table->string('loan_type')->after('agent');
            $table->string('legal_fee')->after('interest_rate');
            $table->string('car_track_maintenance')->after('kra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('loan_type');
            $table->dropColumn('legal_fee');
            $table->dropColumn('car_track_maintenance');
        });
    }
}
