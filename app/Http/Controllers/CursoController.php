<?php

namespace App\Http\Controllers;

use App\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCursos(Request $request)
    {
        $semestre = $request->get('semestre');
        $id_docente = $request->get('id_docente');
        echo "\n \n";
        $cursos = DB::select("SELECT c.designacao AS curso, n.designacao AS nivel, a.semestre AS semestre FROM
            cursos c JOIN disciplina_cursos dc on c.id_curso = dc.id_curso JOIN alocacaos a on dc.id_disciplina_curso =
            a.id_disciplina_curso JOIN nivels n on dc.id_nivel = n.id_nivel WHERE a.ano=(SELECT YEAR(CURRENT_DATE())) AND
            a.semestre=$semestre AND a.id_docente=$id_docente;");
        return response()->json(['cursos' => $cursos], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountCursos(Request $request)
    {
        $semestre = $request->get('semestre');
        $id_docente = $request->get('id_docente');
        echo "\n \n";
        $cursos = DB::select("SELECT COUNT(DISTINCT(dc.id_curso)) AS cursos FROM cursos c JOIN disciplina_cursos dc ON
            c.id_curso=dc.id_curso JOIN alocacaos a ON dc.id_disciplina_curso=a.id_disciplina_curso JOIN docentes doc
            ON a.id_docente=doc.id_docente WHERE a.ano=(SELECT YEAR(CURRENT_DATE())) AND a.semestre=$semestre AND
            doc.id_docente=$id_docente;"
        );
        return response()->json(['cursos' => $cursos], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountTurmas(Request $request)
    {
        $semestre = $request->get('semestre');
        $id_docente = $request->get('id_docente');
        echo "\n \n";
        $turmas = DB::select("SELECT COUNT(*) AS turmas FROM alocacaos WHERE ano=(SELECT YEAR(CURRENT_DATE()))
                          AND semestre=$semestre AND id_docente=$id_docente;"
        );
        return response()->json(['turmas' => $turmas], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
