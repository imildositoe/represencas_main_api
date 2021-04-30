<?php

namespace App\Http\Controllers;

use App\Alocacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlocacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDisciplinas(Request $request)
    {
        $id_curso = $request->get('id_curso');
        $id_nivel = $request->get('id_nivel');
        echo "\n \n";
        $disciplinas = DB::select("SELECT DISTINCT(dc.id_disciplina), d.designacao FROM disciplina_cursos dc JOIN disciplinas d on
            dc.id_disciplina = d.id_disciplina WHERE dc.id_curso=$id_curso AND dc.id_nivel=$id_nivel;"
        );
        return response()->json(['disciplinas' => $disciplinas], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIdAlocacao(Request $request)
    {
        $id_disciplina_curso = $request->get('id_disciplina_curso');
        $id_docente = $request->get('id_docente');
        echo "\n \n";
        $id_alocacao = DB::select("SELECT id_alocacao FROM alocacaos WHERE id_disciplina_curso=$id_disciplina_curso
                                    AND id_docente=$id_docente;"
        );
        return response()->json(['id_alocacao' => $id_alocacao], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCargaHorariaReduzida(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        echo "\n \n";
        $carga_horaria_reduzida = DB::select("SELECT (SELECT carga_horaria FROM alocacaos WHERE id_alocacao = $id_alocacao) - (SELECT COUNT(id_data_da_turma) FROM data_da_turmas WHERE id_alocacao = $id_alocacao) AS carga_horaria;");
        return response()->json(['carga_horaria_reduzida' => $carga_horaria_reduzida], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTurmasEstatisticas(Request $request)
    {
        $id_docente = $request->get('id_docente');
        echo "\n \n";
        $turmas_estatisticas = DB::select("SELECT t.id_alocacao, t.disciplina, t.ano, t.regime, COUNT(m.id_marcacao) AS faltas FROM
            marcacaos m JOIN aulas a on m.id_aula = a.id_aula JOIN (SELECT d.sigla AS disciplina, a.ano AS ano, r.designacao
            AS regime, a.id_alocacao AS id_alocacao FROM disciplinas d JOIN disciplina_cursos dc ON
            d.id_disciplina=dc.id_disciplina JOIN alocacaos a ON a.id_disciplina_curso=dc.id_disciplina_curso JOIN regimes r
            ON r.id_regime=a.id_regime WHERE a.id_docente=$id_docente) t ON a.id_alocacao=t.id_alocacao WHERE m.is_presente=0
            GROUP BY t.id_alocacao");
        return response()->json(['turmas_estatisticas' => $turmas_estatisticas], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalFaltasArquivo(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        echo "\n \n";
        $total_faltas = DB::select("SELECT COUNT(m.id_marcacao) AS total_faltas FROM marcacaos m JOIN sessaos s on m.id_sessao = s.id_sessao
    JOIN aulas a on s.id_aula = a.id_aula JOIN alocacaos a2 on a.id_alocacao = a2.id_alocacao WHERE a2.id_alocacao = $id_alocacao;");
        return response()->json(['total_faltas' => $total_faltas], 200);
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
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO alocacaos(carga_horaria, ano, semestre, id_docente, id_regime, id_disciplina_curso)
            VALUES (?,?,?,?,?,?)", [$request->get('carga_horaria'), $request->get('ano'),
            $request->get('semestre'), $request->get('id_docente'), $request->get('id_regime'),
            $request->get('id_disciplina_curso')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alocacao  $alocacao
     * @return \Illuminate\Http\Response
     */
    public function show(Alocacao $alocacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alocacao  $alocacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Alocacao $alocacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alocacao  $alocacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alocacao $alocacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alocacao  $alocacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alocacao $alocacao)
    {
        //
    }
}
