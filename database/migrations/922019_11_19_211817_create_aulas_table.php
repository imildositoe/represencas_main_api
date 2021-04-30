<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->increments('id_aula');
            $table->date('data');
            $table->integer('id_alocacao')->unsigned();
            $table->integer('id_tipo_aula')->unsigned();
            $table->integer('id_sala')->unsigned();
            $table->foreign('id_alocacao')->references('id_alocacao')->on('alocacaos');
            $table->foreign('id_tipo_aula')->references('id_tipo_aula')->on('tipo_aulas');
            $table->foreign('id_sala')->references('id_sala')->on('salas');
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
        Schema::dropIfExists('aulas');
    }
}
