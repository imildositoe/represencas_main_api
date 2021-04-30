<?php

namespace App\Http\Controllers;

use App\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AulaController extends Controller
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
    public function getAula(Request $request)
    {
        $data = $request->get('data');
        $id_alocacao = $request->get('id_alocacao');
        echo "\n \n";
        $aulas = DB::select("SELECT * FROM aulas WHERE SUBSTRING_INDEX(data, ' ', 1) = '$data' AND id_alocacao=$id_alocacao");
        return response()->json(['aulas' => $aulas], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPresencas(Request $request)
    {
        $data = $request->get('data');
        $id_alocacao = $request->get('id_alocacao');
        $id_aula = $request->get('id_aula');
        echo "\n \n";
        $presencas = DB::select("SELECT m.id_sessao AS id_sessao, e.nr_estudante AS nr_estudante, e.nome AS nome,
                            e.apelido AS apelido, m.is_presente AS is_presente FROM estudantes e
                           JOIN inscricaos i on e.id_estudante = i.id_estudante
                           JOIN marcacaos m on i.id_inscricao = m.id_inscricao
                           JOIN sessaos s ON m.id_sessao = s.id_sessao
                           JOIN aulas a on s.id_aula = a.id_aula
                           JOIN alocacaos al on a.id_alocacao = al.id_alocacao WHERE a.id_aula = $id_aula
                                                                                 AND SUBSTRING_INDEX(data, ' ', 1) = '$data'
                                                                                 AND al.id_alocacao = $id_alocacao");
        return response()->json(['presencas' => $presencas], 200);
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
        DB::insert("INSERT INTO aulas(data, id_alocacao, id_tipo_aula, id_sala)
        VALUES (?,?,?,?)", [$request->get('data'), $request->get('id_alocacao'), $request->get('id_tipo_aula'),
            $request->get('id_sala')]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function show(Aula $aula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function edit(Aula $aula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aula $aula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aula $aula)
    {
        //
    }
}
