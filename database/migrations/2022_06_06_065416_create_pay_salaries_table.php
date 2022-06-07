<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaySalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_salaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('salary_id')->nullable();
            $table->float('working_day')->nullable();
            $table->float('salary')->nullable();
            $table->float('allowance')->nullable();
            $table->float('total')->nullable();
            $table->float('advance')->nullable();
            $table->float('actual_salary')->nullable();
            $table->string("month")->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('pay_salaries');
    }
}
