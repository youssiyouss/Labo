<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titre')->unique()->required();
            $table->string('type')->required();
            $table->text('resumer',600)->required();
            $table->Date('dateAppel')->required();
            $table->Date('dateEcheance')->required();
            $table->time('heureAppel')->nullable()->required();
            $table->time('heureEcheance')->required();
            $table->string('sourceAppel')->required();
            $table->string('fichier')->unique()->nullable();
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
        Schema::dropIfExists('rfps');
    }
}
