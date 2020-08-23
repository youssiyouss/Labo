<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdProjet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taches', function (Blueprint $table) {
          $table->unsignedBigInteger('ID_projet')->after('id');
          $table->foreign('ID_projet')->references('id')->on('taches')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taches', function (Blueprint $table) {
          $table->dropForeign(['ID_projet']);
          $table->dropColumn('ID_projet')->onDelet('cascade')->onUpdate('cascade');
        });
    }
}
