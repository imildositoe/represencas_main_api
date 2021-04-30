<?php

namespace App\Http\Controllers;

use App\Estudante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $estudantes = DB::select("SELECT e.id_estudante, e.apelido, e.nome, e.nr_estudante, e.url_foto,
            e.email, e.senha, e.genero, e.data_nascimento, e.id_curso, e.is_finger_registered FROM estudantes e");
        return response()->json(['estudantes' => $estudantes], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEstudantes(Request $request)
    {
        $id_disciplina_curso = $request->get('id_disciplina_curso');
        $id_regime = $request->get('id_regime');
        $ano = $request->get('ano');
        echo "\n \n";
        $estudantes = DB::select("SELECT e.id_estudante, e.apelido, e.nome, e.nr_estudante, e.url_foto,
            e.email, e.senha, e.genero, e.data_nascimento, e.id_curso, e.is_finger_registered, i.*, dc.*, a.* FROM estudantes e
            JOIN inscricaos i on e.id_estudante = i.id_estudante
            JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
            JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso
            WHERE a.id_disciplina_curso=$id_disciplina_curso AND a.id_regime=$id_regime AND a.ano=$ano;"
        );
        return response()->json(['estudantes' => $estudantes], 200);
    }


    public function getTurmasEstudante(Request $request)
    {
        $id_estudante = $request->get('id_estudante');
        $ano = $request->get('ano');
        $turmas = DB::select("SELECT i.id_inscricao AS id_inscricao, d.designacao AS disciplina, d.sigla AS disciplina_sigla, a.ano AS ano, r.designacao AS regime,
            r.sigla AS regime_sigla, i.is_excluido AS is_excluido, a.carga_horaria AS carga_horaria, a.id_alocacao AS id_alocacao FROM inscricaos i
                JOIN regimes r ON i.id_regime = r.id_regime
                JOIN disciplina_cursos dc ON i.id_disciplina_curso = dc.id_disciplina_curso
                JOIN disciplinas d ON dc.id_disciplina = d.id_disciplina
                JOIN alocacaos a ON dc.id_disciplina_curso = a.id_disciplina_curso WHERE i.id_estudante = $id_estudante AND i.ano = $ano;");
        return response()->json(['turmas' => $turmas], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEstudantesArquivo(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        echo "\n \n";
        $estudantes = DB::select("SELECT i.id_inscricao AS id_inscricao, e.nr_estudante AS nr_estudante,
            e.nome AS nome, e.apelido AS apelido, COUNT(m.id_marcacao) AS faltas, i.is_excluido AS is_excluido FROM alocacaos a
                JOIN disciplina_cursos dc on a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN inscricaos i on dc.id_disciplina_curso = i.id_disciplina_curso
                JOIN estudantes e on i.id_estudante = e.id_estudante
                JOIN marcacaos m on i.id_inscricao = m.id_inscricao
                                WHERE m.is_presente = 0 AND a.id_alocacao = $id_alocacao
                                                            GROUP BY i.id_inscricao, e.nr_estudante, e.nome, e.apelido, i.is_excluido;"
        );
        return response()->json(['estudantes' => $estudantes], 200);
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
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO estudantes(apelido, nome, nr_estudante, email, senha, genero, data_nascimento, id_curso)
        VALUES (?,?,?,?,?,?,?,?)", [$request->get('apelido'), $request->get('nome'), $request->get('nr_estudante'),
            $request->get('email'), $request->get('senha'), $request->get('genero'), $request->get('data_nascimento'), $request->get('id_curso')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIdStudent(Request $request)
    {
        $nr = $request->get('nr_estudante');
        echo "\n \n";
        $id_estudante = DB::select("SELECT id_estudante FROM estudantes WHERE nr_estudante=$nr");
        return response()->json(['id_estudante' => $id_estudante], 200);
    }


    public function getTurmas(Request $request)
    {
        $id_docente = $request->get('id_docente');
        $turmas = DB::select("SELECT d.designacao AS disciplina, a.ano, r.designacao AS regime, d.sigla AS disciplina_sigla, r.sigla AS regime_sigla,
       r.id_regime, dc.id_disciplina_curso, dc.id_curso, a.id_alocacao AS id_alocacao FROM disciplinas d JOIN disciplina_cursos dc ON
           d.id_disciplina=dc.id_disciplina JOIN alocacaos a ON a.id_disciplina_curso=dc.id_disciplina_curso
           JOIN regimes r ON r.id_regime=a.id_regime WHERE a.id_docente=$id_docente AND a.ano=EXTRACT(YEAR FROM CURRENT_DATE());");
        return response()->json(['turmas' => $turmas], 200);
    }


    public function getTurmasCompletas(Request $request)
    {
        $id_docente = $request->get('id_docente');
        $turmas = DB::select("SELECT n.designacao AS nivel, c.designacao AS curso, d.designacao AS disciplina, r.designacao AS regime, a.semestre AS semestre, a.carga_horaria AS carga_horaria FROM cursos c
                        JOIN disciplina_cursos dc on c.id_curso = dc.id_curso
                        JOIN disciplinas d on dc.id_disciplina = d.id_disciplina
                        JOIN nivels n on dc.id_nivel = n.id_nivel
                        JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso
                        JOIN regimes r on a.id_regime = r.id_regime WHERE a.id_docente=$id_docente
                                                                          AND a.ano=EXTRACT(YEAR FROM CURRENT_DATE());");
        return response()->json(['turmas_completas' => $turmas], 200);
    }

    public function getTurmasArquivo(Request $request)
    {
        $id_docente = $request->get('id_docente');
        $ano = $request->get('ano');
        $turmas = DB::select("SELECT d.designacao AS disciplina, a.ano, r.designacao AS regime, d.sigla AS disciplina_sigla, r.sigla AS regime_sigla,
       r.id_regime, dc.id_disciplina_curso, dc.id_curso, a.id_alocacao AS id_alocacao FROM disciplinas d JOIN disciplina_cursos dc ON
           d.id_disciplina=dc.id_disciplina JOIN alocacaos a ON a.id_disciplina_curso=dc.id_disciplina_curso
           JOIN regimes r ON r.id_regime=a.id_regime WHERE a.id_docente=$id_docente AND a.ano=$ano;");
        return response()->json(['turmas_arquivo' => $turmas], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Estudante $estudante
     * @return \Illuminate\Http\Response
     */
    public function show(Estudante $estudante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Estudante $estudante
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudante $estudante)
    {
        DB::table('estudantes')
            ->where('id', 1)
            ->update(['nome' => 'Imildo']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Estudante $estudante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estudante $estudante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Estudante $estudante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudante $estudante)
    {
        DB::table('estudantes')
            ->where('id', 2)
            ->delete();
    }
}
