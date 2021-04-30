<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcacaos', function (Blueprint $table) {
            $table->increments('id_marcacao');
            $table->boolean('is_presente');
            $table->integer('id_inscricao')->unsigned();
            $table->integer('id_aula')->unsigned();
            $table->foreign('id_inscricao')->references('id_inscricao')->on('inscricaos');
            $table->foreign('id_aula')->references('id_aula')->on('aulas');
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
        Schema::dropIfExists('marcacaos');
    }
}
