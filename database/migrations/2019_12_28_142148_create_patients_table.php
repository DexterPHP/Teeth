<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            /*
             '','user_age','user_login','gender','','','shoug','','','notes','user_image'
             * */
            $table->bigIncrements('id')->autoIncrement();
            $table->string('username');
            $table->string('lastname');
            $table->date('birthday');
            $table->integer('user_age');
            $table->timestamp('user_login');
            $table->enum('gender',['ذكر', 'أنثى']);
            $table->string('user_mobile');
            $table->string('user_middel');
            $table->tinyInteger('shoug');
            $table->tinyInteger('depress');
            $table->tinyInteger('smoking');
            $table->mediumText('notes');
            $table->mediumText('medical_notes')->nullable();
            $table->string('uuid')->unique();
            $table->string('card_number')->nullable();
            $table->bigInteger('doctors_id')->unsigned();
            $table->string('user_image')->nullable();
            $table->integer('patient_box')->default(0);
            $table->timestamps();
            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
