<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdChercheurTaches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taches', function (Blueprint $table) {
          $table->unsignedBigInteger('ID_chercheur')->after('id');
          $table->foreign('ID_chercheur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
          $table->dropForeign(['ID_chercheur']);
          $table->dropColumn('ID_chercheur')->onDelet('cascade')->onUpdate('cascade');
        });
    }
}
