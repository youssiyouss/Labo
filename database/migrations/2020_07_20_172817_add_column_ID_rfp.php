<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdRfp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
          $table->unsignedBigInteger('ID_rfp')->after('id');
          $table->foreign('ID_rfp')->references('id')->on('rfps')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
          $table->dropForeign(['ID_chercheur']);
          $table->dropColumn('ID_chercheur')->onDelet('cascade')->onUpdate('cascade');

        });
    }
}
