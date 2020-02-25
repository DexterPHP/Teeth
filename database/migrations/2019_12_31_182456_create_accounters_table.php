<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accounter_fname');
            $table->timestamp('accounter_login');
            $table->string('accounter_pass');
            $table->string('accounter_phone')->nullable();
            $table->string('uuid')->unique();
            $table->timestamps();
            $table->bigInteger('center_id')->unsigned();
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounters');
    }
}
