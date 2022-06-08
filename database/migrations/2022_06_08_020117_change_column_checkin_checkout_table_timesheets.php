<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnCheckinCheckoutTableTimesheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->string('in_hour')->nullable()->change();
        });
        Schema::table('timesheets', function (Blueprint $table) {
            $table->string('out_hour')->nullable()->change();
        });
        Schema::table('timesheets', function (Blueprint $table) {
            $table->string('date')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
