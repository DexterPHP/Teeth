<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'id','lab_name','lab_spi','lab_phone','lab_location'd
        Schema::create('labs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lab_name');
            $table->string('lab_spi');
            $table->string('lab_phone');
            $table->string('lab_location');
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
        Schema::dropIfExists('labs');
    }
}
