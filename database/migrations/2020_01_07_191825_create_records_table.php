<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'id','patient_id','doctor_id','set_total','set_payment','teeth_lab','set_note','teeth_work_name','working_teeth'
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('doctor_id')->unsigned();
            $table->integer('set_total')->nullable();
            $table->integer('set_payment')->nullable();
            $table->bigInteger('teeth_lab')->unsigned()->nullable();
            $table->text('set_note')->nullable();
            $table->string('teeth_work_name')->nullable();
            $table->string('working_teeth')->nullable();
            $table->string('uuid')->unique();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('teeth_lab')->references('id')->on('labs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
