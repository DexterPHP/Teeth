<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->timestamp('what_date')->default(null);
            $table->time('start_time');
            $table->time('left_time');
            $table->string('priority')->default('#28a745');
            $table->bigInteger('doctor_id')->unsigned();
            $table->bigInteger('patients_id')->unsigned()->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('patients_id')->references('id')->on('patients');
            $table->string('uuid')->unique();
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
        Schema::dropIfExists('dates');
    }
}
