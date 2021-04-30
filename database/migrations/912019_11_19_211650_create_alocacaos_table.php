<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlocacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alocacaos', function (Blueprint $table) {
            $table->increments('id_alocacao');
            $table->double('carga_horaria');
            $table->integer('ano');
            $table->integer('semestre');
            $table->integer('id_docente')->unsigned();
            $table->integer('id_regime')->unsigned();
            $table->integer('id_disciplina_curso')->unsigned();
            $table->foreign('id_docente')->references('id_docente')->on('docentes');
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
        Schema::dropIfExists('alocacaos');
    }
}
