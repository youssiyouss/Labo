<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\carbon;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('nom')->unique();
          $table->string('fichierDoffre')->required();
          $table->text('plateForme');
          $table->string('reponse')->nullable();
          $table->string('lettreReponse')->nullable();
          $table->integer('nmbrParticipants')->nullable();
          $table->Date('lancement')->nullable();
          $table->Date('cloture')->nullable();
          $table->string('rapportFinal')->nullable();
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
        Schema::dropIfExists('projets');
    }
}
