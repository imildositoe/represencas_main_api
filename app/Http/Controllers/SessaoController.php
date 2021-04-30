<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessaoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function abrirSessao(Request $request)
    {
        DB::insert("INSERT INTO sessaos(hora_inicio, is_aberta, id_aula) VALUES (?,?,?)",
            [$request->get('hora_inicio'), $request->get('is_aberta'), $request->get('id_aula')]);
    }

    /**
     * Update resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fecharSessao(Request $request)
    {
        $id_sessao = $request->get('id_sessao');
        DB::update("UPDATE sessaos SET hora_fim = ?, is_selada = ?, is_aberta = ? WHERE id_sessao=$id_sessao;",
            [$request->get('hora_fim'), $request->get('is_selada'), $request->get('is_aberta')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIdSessao(Request $request)
    {
        $hora_inicio_sessao = $request->get('hora_inicio_sessao');
        $id_aula = $request->get('id_aula');
        echo "\n \n";
        $id_sessao = DB::select("SELECT id_sessao AS id_sessao FROM sessaos WHERE id_aula=$id_aula AND hora_inicio='$hora_inicio_sessao';");
        return response()->json(['id_sessao' => $id_sessao], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIdInscricao(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $id_estudante = $request->get('id_estudante');
        echo "\n \n";
        $id_inscricao = DB::select("SELECT i.id_inscricao AS id_inscricao FROM estudantes e JOIN inscricaos i
                    ON e.id_estudante = i.id_estudante JOIN disciplina_cursos dc ON i.id_disciplina_curso = dc.id_disciplina_curso
                    JOIN alocacaos a on dc.id_disciplina_curso = a.id_disciplina_curso WHERE a.id_alocacao = $id_alocacao AND
                                                                                             e.id_estudante = $id_estudante;");
        return response()->json(['id_inscricao' => $id_inscricao], 200);
    }
}
