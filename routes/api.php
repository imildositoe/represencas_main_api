<?php

/**
 * @author Imildo Sitoe
 * @copyright
*/

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentication Routes
Route::post('/register_user','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');


//<<PROFESSOR>>
//Get Routes
Route::get('/get_all_estudantes','EstudanteController@index');
Route::get('/get_estudantes','EstudanteController@getEstudantes');
Route::get('/get_id_estudante','EstudanteController@getIdStudent');
Route::get('/get_turmas','EstudanteController@getTurmas');
Route::get('/get_turmas_completas','EstudanteController@getTurmasCompletas');
Route::get('/get_turmas_arquivo','EstudanteController@getTurmasArquivo');
Route::get('/get_docente','DocenteController@getDocente');
Route::get('/get_count_cursos','CursoController@getCountCursos');
Route::get('/get_count_turmas','CursoController@getCountTurmas');
Route::get('/get_cursos','CursoController@getCursos');
Route::get('/get_disciplinas','AlocacaoController@getDisciplinas');
Route::get('/get_id_disciplina_curso','DisciplinaCursoController@getIdDisciplinaCurso');
Route::get('/get_turmas_estatisticas','AlocacaoController@getTurmasEstatisticas');
Route::get('/get_aulas','AulaController@getAula');
Route::get('/get_presencas','AulaController@getPresencas');
Route::get('/get_datas','DataHistoricaController@index');
Route::get('/get_datas_2','DataHistoricaController@getDatas2');
Route::get('/get_datas_da_turma','DataHistoricaController@index');
Route::get('/get_id_alocacao','AlocacaoController@getIdAlocacao');
Route::get('/doughnut_chart_faltas','MarcacaoController@doughnutChartFaltas');
Route::get('/get_nr_estudantes','InscricaoController@getNrEstudantes');
Route::get('/get_nr_excluidos','InscricaoController@getNrExcluidos');
Route::get('/get_nr_genero','InscricaoController@getNrGenero');
Route::get('/get_nr_excluidos_por_genero','InscricaoController@getNrExcluidosPorGenero');
Route::get('/get_nr_excluidos_faixa','InscricaoController@getNrExcluidosFaixa');
Route::get('/get_nr_faixa','InscricaoController@getNrFaixa');
Route::get('/get_inscricoes','MarcacaoController@getInscricoes');
Route::get('/get_inscricoes_marcacoes','MarcacaoController@getInscricoesMarcacoes');
Route::get('/get_marcacoes','MarcacaoController@index');
Route::get('/get_carga_horaria_reduzida','AlocacaoController@getCargaHorariaReduzida');
Route::get('/get_id_sessao','SessaoController@getIdSessao');
Route::get('/get_id_inscricao','SessaoController@getIdInscricao');
Route::get('/get_total_faltas_arquivo','AlocacaoController@getTotalFaltasArquivo');
Route::get('/get_estudantes_arquivo','EstudanteController@getEstudantesArquivo');
Route::get('/get_estudantes_faltas','MarcacaoController@getEstudantesFaltas');
Route::get('/get_nr_excluidos_arquivo','MarcacaoController@getNrExcluidosArquivo');
Route::get('/get_faltas_bar_1','MarcacaoController@getFaltasBarChart1');
Route::get('/get_faltas_bar_2','MarcacaoController@getFaltasBarChart2');


//Post Routes
Route::post('/save_students','EstudanteController@store');
Route::post('/save_enrollments','InscricaoController@store');
Route::post('/save_disciplina_curso','DisciplinaCursoController@store');
Route::post('/save_turma','AlocacaoController@store');
Route::post('/save_aula','AulaController@store');
Route::post('/save_data','DataHistoricaController@store');
Route::post('/save_data_da_turma','DataDaTurmaController@store');
Route::post('/save_marcacao','MarcacaoController@store');


//Patch Routes
Route::post('/abrir_sessao','SessaoController@abrirSessao');
Route::post('/fechar_sessao','SessaoController@fecharSessao');
Route::post('/excluir_estudante','InscricaoController@excluirEstudante');


//<< ESTUDANTE>>
//Get Routes
Route::get('/get_turmas_estudante', 'EstudanteController@getTurmasEstudante');
Route::get('/get_notificacoes', 'NotificacaoController@getNotificacoes');

