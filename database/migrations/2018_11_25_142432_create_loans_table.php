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
            $table->decimal('amount',10,2)->unsigned();
            $table->integer('duration')->unsigned();
            $table->decimal('interest_rate',10,2)->unsigned();
            $table->decimal('arrangement_fee',10,2)->unsigned();
            $table->integer('repayment_frequency')->unsigned();
            $table->decimal('total_amount',10,2)->unsigned()->nullable();
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
        Schema::dropIfExists('loans');
    }
}
