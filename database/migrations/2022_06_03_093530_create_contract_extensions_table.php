<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_extensions', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->nullable();
            $table->date('renewal_date_start')->nullable();
            $table->date('renewal_date_finish')->nullable();
            $table->float('salary_factor')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_extensions');
    }
}
