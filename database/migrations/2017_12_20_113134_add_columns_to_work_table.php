<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_work_details', function (Blueprint $table) {
            $table->string('employment_type');
            $table->string('business_name')->nullable();
            $table->string('business_physical_address')->nullable();
            $table->string('business_gross')->nullable();
            $table->text('business_nature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_work_details', function (Blueprint $table) {
            $table->dropColumn(['employment_type','business_name','business_physical_address','business_gross','business_nature']);
        });
    }
}
