<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinaCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplina_cursos', function (Blueprint $table) {
            $table->increments('id_disciplina_curso');
            $table->integer('id_curso')->unsigned();
            $table->integer('id_disciplina')->unsigned();
            $table->integer('id_nivel')->unsigned();
            $table->foreign('id_curso')->references('id_curso')->on('cursos');
            $table->foreign('id_disciplina')->references('id_disciplina')->on('disciplinas');
            $table->foreign('id_nivel')->references('id_nivel')->on('nivels');
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
        Schema::dropIfExists('disciplina_cursos');
    }
}
