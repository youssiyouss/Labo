<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjetGere extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->unsignedBigInteger('projetGere')->nullable();
          $table->foreign('projetGere')->references('id')->on('projets')->onDelete('cascade')->onUpdate('cascade');
          $table->unique( array('email','projetGere') );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropForeign(['projetGere']);
          $table->dropColumn('projetGere')->onDelet('cascade')->onUpdate('cascade');
        });
    }
}
