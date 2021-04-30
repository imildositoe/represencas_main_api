<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscricaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscricaos', function (Blueprint $table) {
            $table->increments('id_inscricao');
            $table->integer('ano');
            $table->integer('id_estudante')->unsigned();
            $table->integer('id_regime')->unsigned();
            $table->integer('id_disciplina_curso')->unsigned();
            $table->foreign('id_estudante')->references('id_estudante')->on('estudantes');
            $table->foreign('id_regime')->references('id_regime')->on('regimes');
            $table->foreign('id_disciplina_curso')->references('id_disciplina_curso')->on('disciplina_cursos');
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
        Schema::dropIfExists('inscricaos');
    }
}
