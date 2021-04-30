<?php

namespace App\Http\Controllers;

use App\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscricaoController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        DB::table('inscricaos')->insert([
//            'ano' => $request->get('ano'),
//            'id_estudante' => $request->get('id_estudante'),
//            'id_regime' => $request->get('id_regime'),
//            'id_disciplina' => $request->get('id_disciplina'),
//        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrEstudantes(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        echo "\n \n";
        $nr_estudantes = DB::select("SELECT COUNT(*) AS nr_estudantes FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
                           JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao =$id_alocacao"
        );
        return response()->json(['nr_estudantes' => $nr_estudantes], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrExcluidos(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        echo "\n \n";
        $nr_excluidos = DB::select("SELECT COUNT(*) AS nr_excluidos FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
                           JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao AND i.is_excluido = 1"
        );
        return response()->json(['nr_excluidos' => $nr_excluidos], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrGenero(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $genero = $request->get('genero');
        echo "\n \n";
        $nr_genero = DB::select("SELECT COUNT(*) AS nr_genero FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
                           JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao AND e.genero = '$genero';"
        );
        return response()->json(['nr_genero' => $nr_genero], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrExcluidosPorGenero(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $genero = $request->get('genero');
        echo "\n \n";
        $nr_excluidos_por_genero = DB::select("SELECT COUNT(*) AS nr_excluidos_por_genero FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
                           JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao
                                                                                                AND e.genero = '$genero'
                                                                                                AND i.is_excluido = 1;"
        );
        return response()->json(['nr_excluidos_por_genero' => $nr_excluidos_por_genero], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrExcluidosFaixa(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $minimo = $request->get('minimo');
        $maximo = $request->get('maximo');
        echo "\n \n";
        $nr_excluidos_faixa = DB::select("SELECT COUNT(*) AS nr_excluidos_faixa FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
                           JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao
                                                                                                AND i.is_excluido = 1
                                                                                                AND (EXTRACT(YEAR FROM CURRENT_DATE()) - EXTRACT(YEAR FROM e.data_nascimento)) BETWEEN $minimo AND $maximo;"
        );
        return response()->json(['nr_excluidos_faixa' => $nr_excluidos_faixa], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNrFaixa(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $minimo = $request->get('minimo');
        $maximo = $request->get('maximo');
        echo "\n \n";
        $nr_faixa = DB::select("SELECT COUNT(*) AS nr_faixa FROM estudantes e JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN disciplina_cursos dc on i.id_disciplina_curso = dc.id_disciplina_curso
                           JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao
                                                                                                AND (EXTRACT(YEAR FROM CURRENT_DATE()) - EXTRACT(YEAR FROM e.data_nascimento)) BETWEEN $minimo AND $maximo;"
        );
        return response()->json(['nr_faixa' => $nr_faixa], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO inscricaos(ano, id_estudante, id_regime, id_disciplina_curso) VALUES (?,?,?,?)",
        [$request->get('ano'), $request->get('id_estudante'), $request->get('id_regime'),
            $request->get('id_disciplina_curso')]);
    }

    public function excluirEstudante(Request $request)
    {
        $id_inscricao = $request->get('id_inscricao');
        DB::update("UPDATE inscricaos SET is_excluido = 1 WHERE id_inscricao = $id_inscricao");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function show(Inscricao $inscricao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscricao $inscricao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscricao $inscricao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscricao $inscricao)
    {
        //
    }
}
