<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\carbon;

class CreateTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titreTache')->required();
            $table->text('description')->required();
            $table->string('priorite');
            $table->Date('dateDebut')->default(date("Y-m-d H:i:s"))->nullable();
            $table->Date('dateFin')->required();
            $table->string('fichierDetail')->nullable();
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
        Schema::dropIfExists('taches');
    }
}
