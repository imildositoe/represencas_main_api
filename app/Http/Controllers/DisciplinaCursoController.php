<?php

namespace App\Http\Controllers;

use App\DisciplinaCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisciplinaCursoController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function store(Request $request)
    {
        DB::insert("INSERT INTO disciplina_cursos(id_curso, id_disciplina, id_nivel)
        VALUES (?,?,?)", [$request->get('id_curso'), $request->get('id_disciplina'), $request->get('id_nivel')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIdDisciplinaCurso(Request $request)
    {
        $id_curso = $request->get('id_curso');
        $id_disciplina = $request->get('id_disciplina');
        $id_nivel = $request->get('id_nivel');
        echo "\n \n";
        $id_disciplina_curso = DB::select("SELECT id_disciplina_curso FROM disciplina_cursos WHERE id_curso=$id_curso
            AND id_disciplina=$id_disciplina AND id_nivel=$id_nivel GROUP BY id_disciplina_curso DESC LIMIT 1;"
        );
        return response()->json(['id_disciplina_curso' => $id_disciplina_curso], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DisciplinaCurso  $disciplinaCurso
     * @return \Illuminate\Http\Response
     */
    public function show(DisciplinaCurso $disciplinaCurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DisciplinaCurso  $disciplinaCurso
     * @return \Illuminate\Http\Response
     */
    public function edit(DisciplinaCurso $disciplinaCurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DisciplinaCurso  $disciplinaCurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DisciplinaCurso $disciplinaCurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DisciplinaCurso  $disciplinaCurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(DisciplinaCurso $disciplinaCurso)
    {
        //
    }
}
