<?php

namespace App\Http\Controllers;

use App\Marcacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $marcacoes = DB::select("SELECT id_inscricao, COUNT(is_presente) AS faltas FROM marcacaos WHERE is_presente = 0 GROUP BY id_inscricao;");
        return response()->json(['marcacoes' => $marcacoes], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function doughnutChartFaltas(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $id_inscricao = $request->get('id_inscricao');
        $doughnut_chart_faltas = DB::select("SELECT ((SELECT carga_horaria FROM alocacaos WHERE id_alocacao = $id_alocacao) -
            (SELECT COUNT(id_data_da_turma) FROM data_da_turmas WHERE id_alocacao = $id_alocacao)) AS carga_horaria,
            (SELECT COUNT(m.id_marcacao) FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN marcacaos m on i.id_inscricao = m.id_inscricao
                           JOIN sessaos s on m.id_sessao = s.id_sessao
                           JOIN aulas a on s.id_aula = a.id_aula WHERE a.id_alocacao = $id_alocacao
                                                                   AND m.id_inscricao = $id_inscricao
                                                                   AND m.is_presente = 0) AS faltas;"
        );
        return response()->json(['doughnut_chart_faltas' => $doughnut_chart_faltas], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInscricoes(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $inscricoes = DB::select("SELECT i2.id_inscricao FROM inscricaos i2 JOIN disciplina_cursos dc on i2.id_disciplina_curso = dc.id_disciplina_curso
                                                  JOIN alocacaos a2 on dc.id_disciplina_curso = a2.id_disciplina_curso WHERE a2.id_alocacao = $id_alocacao"
        );
        return response()->json(['inscricoes' => $inscricoes], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInscricoesMarcacoes(Request $request)
    {
        $id_aula = $request->get('id_aula');
        $inscricoes_marcacoes = DB::select("SELECT m.id_inscricao FROM marcacaos m JOIN sessaos s on m.id_sessao = s.id_sessao
                                                    WHERE s.id_aula = $id_aula;"
        );
        return response()->json(['inscricoes_marcacoes' => $inscricoes_marcacoes], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrExcluidosArquivo(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $nr_excluidos = DB::select("SELECT COUNT(*) AS nr_excluidos FROM alocacaos a
            JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
            JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso WHERE is_excluido = 1 AND a.id_alocacao = $id_alocacao;"
        );
        return response()->json(['nr_excluidos' => $nr_excluidos], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEstudantesFaltas(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $get_estudantes_faltas = DB::select("SELECT (SELECT COUNT(DISTINCT(t1.id_inscricao)) FROM (SELECT DISTINCT(m.id_inscricao) AS id_inscricao FROM alocacaos a
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso
                JOIN marcacaos m on i.id_inscricao = m.id_inscricao WHERE a.id_alocacao = $id_alocacao AND m.is_presente = 0) t1
                JOIN (SELECT i.id_inscricao FROM alocacaos a
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao) t2) AS estudantes_com_faltas,
            (SELECT COUNT(*) FROM alocacaos a
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao) -
            (SELECT COUNT(DISTINCT(t1.id_inscricao)) AS estudantes_com_faltas FROM (SELECT DISTINCT(m.id_inscricao) AS id_inscricao FROM alocacaos a
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso
                JOIN marcacaos m on i.id_inscricao = m.id_inscricao WHERE a.id_alocacao = $id_alocacao AND m.is_presente = 0) t1
                JOIN (SELECT i.id_inscricao FROM alocacaos a
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao) t2) AS estudantes_sem_faltas;"
        );
        return response()->json(['estudantes_faltas' => $get_estudantes_faltas], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFaltasBarChart1(Request $request)
    {
        $id_docente = $request->get('id_docente');
        $faltas_bar = DB::select("SELECT a.id_alocacao,  d2.sigla AS disciplina, r.sigla AS regime, a.ano, 0 AS nr_faltas FROM docentes d
                JOIN alocacaos a on d.id_docente = a.id_docente
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN disciplinas d2 on dc.id_disciplina = d2.id_disciplina
                JOIN regimes r on a.id_regime = r.id_regime
                                WHERE d.id_docente = $id_docente AND a.ano = EXTRACT(YEAR FROM CURRENT_DATE);"
        );
        return response()->json(['faltas_bar_1' => $faltas_bar], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFaltasBarChart2(Request $request)
    {
        $id_docente = $request->get('id_docente');
        $faltas_bar = DB::select("SELECT a.id_alocacao, d.sigla AS disciplina, r.sigla AS regime, a.ano, COUNT(m.id_marcacao) AS nr_faltas FROM alocacaos a
                    JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                    JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso
                    JOIN regimes r on a.id_regime = r.id_regime
                    JOIN disciplinas d on dc.id_disciplina = d.id_disciplina
                    JOIN docentes d2 on a.id_docente = d2.id_docente
                    JOIN marcacaos m on i.id_inscricao = m.id_inscricao WHERE m.is_presente = 0
                                                          AND d2.id_docente = $id_docente
                                                          AND a.ano = EXTRACT(YEAR FROM CURRENT_DATE) GROUP BY a.id_alocacao, d.sigla,
                                                                                                               r.sigla,
                                                                                                               a.ano;"
        );
        return response()->json(['faltas_bar_2' => $faltas_bar], 200);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO marcacaos(id_inscricao, is_presente, id_sessao) VALUES (?,?,?)",
            [$request->get('id_inscricao'), $request->get('is_presente'), $request->get('id_sessao')]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Marcacao $marcacao
     * @return \Illuminate\Http\Response
     */
    public function show(Marcacao $marcacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Marcacao $marcacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Marcacao $marcacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Marcacao $marcacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marcacao $marcacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Marcacao $marcacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marcacao $marcacao)
    {
        //
    }
}
