<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataDaTurmaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $id_alocacao = $request->get('id_alocacao');
        $datas_da_turma = DB::select("SELECT dh.data, dh.descricao FROM data_da_turmas dt JOIN data_historicas dh WHERE id_alocacao = $id_alocacao;");
        return response()->json(['datas_da_turma' => $datas_da_turma], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO data_da_turmas(id_data_historica, id_alocacao) VALUES (?,?)",
            [$request->get('id_data_historica'), $request->get('id_alocacao')]);
    }
}
