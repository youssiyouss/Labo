<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tag');
            $table->string('subject');
            $table->longText('message');
            $table->DateTime('read_at');
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
        Schema::dropIfExists('emails');
    }
}
