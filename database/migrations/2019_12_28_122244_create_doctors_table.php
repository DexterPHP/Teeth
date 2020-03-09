<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('doctor_fname');
            $table->string('doctor_username');
            $table->string('doctor_pass')->nullable();
            $table->string('doctor_spicalest')->nullable();
            $table->string('doctor_mobile')->nullable();
            $table->string('doctoe_accounter')->nullable();
            $table->enum('Type',['Cash','Percent'])->default('Cash');
            $table->integer('cash_percent')->default('0');
            $table->integer('moneybox')->default('0');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('uuid')->unique();
            $table->bigInteger('center_id')->unsigned();
            $table->timestamps();
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
