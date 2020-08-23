<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMaitreOuvrage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfps', function (Blueprint $table) {
          $table->unsignedBigInteger('maitreOuvrage')->after('id');
          $table->foreign('maitreOuvrage')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfps', function (Blueprint $table) {
          $table->dropForeign(['maitreOuvrage']);
          $table->dropColumn('maitreOuvrage')->onDelet('cascade')->onUpdate('cascade');

        });
    }
}
