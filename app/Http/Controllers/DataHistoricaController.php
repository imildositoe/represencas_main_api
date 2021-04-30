<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataHistoricaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $datas = DB::select("SELECT * FROM data_historicas WHERE is_feriado = 1;");
        return response()->json(['datas' => $datas], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDatas2()
    {
        $datas2 = DB::select("SELECT * FROM data_historicas WHERE is_feriado = 0;");
        return response()->json(['datas_2' => $datas2], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO data_historicas(data, descricao, is_feriado) VALUES (?,?,?)",
            [$request->get('data'), $request->get('descricao'), $request->get('is_feriado')]);
    }
}
