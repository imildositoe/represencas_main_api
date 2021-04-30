<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotificacoes(Request $request)
    {
        $id_estudante = $request->get("id_estudante");
        $notificacoes = DB::select("SELECT  n.id_notificacao, n.titulo AS titulo, n.mensagem AS mensagem, n.data AS data, n.is_vista AS is_vista,
            a.ano AS ano, r.sigla AS regime, d.sigla AS disciplina FROM alocacaos a JOIN notificacaos n ON a.id_alocacao = n.id_alocacao
                JOIN estudantes e ON e.id_estudante = n.id_estudante
                JOIN regimes r ON a.id_regime = r.id_regime
                JOIN disciplina_cursos dc ON a.id_disciplina_curso = dc.id_disciplina_curso
                JOIN disciplinas d ON dc.id_disciplina = d.id_disciplina WHERE a.ano = EXTRACT(YEAR FROM CURRENT_DATE()) AND e.id_estudante = $id_estudante
                                                                                                                             ORDER BY n.id_notificacao DESC;");
        return response()->json(['notificacoes' => $notificacoes], 200);
    }

}
