<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Amount'); // المبلغ
            $table->string('Type')->default('1');
            $table->bigInteger('center_id')->unsigned()->nullable();
            $table->bigInteger('doctor_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('patients_id')->unsigned()->nullable();
            $table->string('Opeartion');
            $table->string('notes');
            $table->string('uuid')->unique();
            $table->date('created_date');
            $table->foreign('center_id')->references('id')->on('centers');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('patients_id')->references('id')->on('patients')->onDelete(null);
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
        Schema::dropIfExists('transitions');
    }
}
