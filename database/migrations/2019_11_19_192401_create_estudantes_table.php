<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudantes', function (Blueprint $table) {
            $table->increments('id_estudante');
            $table->string('apelido');
            $table->string('nome');
            $table->string('nr_estudante');
            $table->string('url_foto');
            $table->string('email');
            $table->string('senha');

//            $table->integer('id_user')->unsigned();
//            $table->integer('id_area_cientifica')->unsigned();
//            $table->foreign('id_area_cientifica')->references('id_area_cientifica')->on('areas_cientificas');
//            $table->foreign('id_user')->references('id')->on('users');

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
        Schema::dropIfExists('estudantes');
    }
}
