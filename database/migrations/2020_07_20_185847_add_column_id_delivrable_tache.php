<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdDelivrableTache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivrables', function (Blueprint $table) {

          $table->unsignedBigInteger('id_respo');

          $table->foreign('id_respo')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');

          $table->unsignedBigInteger('id_tache');

          $table->foreign('id_tache')
                      ->references('id')
                      ->on('taches')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');

          $table->unique(['id_respo','id_tache']);
          $table->primary(['id_respo','id_tache']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivrables', function (Blueprint $table) {
            $table->dropForeign(['id_respo']);
            $table->dropForeign(['id_tache']);
            $table->dropColumn('id_respo')->onDelet('cascade')->onUpdate('cascade');
            $table->dropColumn('id_tache')->onDelet('cascade')->onUpdate('cascade');

        });
    }
}
