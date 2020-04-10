<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function getAll()
    {
        $agenda = DB::table('agenda')
            ->join('colaboradores', 'colaboradores.c_id', '=', 'agenda.x_colaborador_id')
            ->select(
                'agenda.x_id as id_agenda',
                'agenda.x_data as data',
                'agenda.x_unidade as unidade',
                'agenda.x_periodos as periodo',
                'agenda.x_cidade as cidade',
                'agenda.x_procedimento as procedimento',
                'agenda.x_obs as obs',
                'agenda.x_colaborador_id as id_colaborador',
                'colaboradores.c_nome_completo as nome',
                'colaboradores.c_email as email',
                'colaboradores.c_tipo as tipo'
            )
            ->get();


        return response()->json($agenda, 200);
    }

    public function getDay($data)
    {
        if (!isset($data)) {
            return response()->json([
                "message" => "Data inválida"
            ], 400);
        }

        $agenda = DB::table('agenda')
            ->join('colaboradores', 'colaboradores.c_id', '=', 'agenda.x_colaborador_id')
            ->select(
                'agenda.x_id as id_agenda',
                'agenda.x_data as data',
                'agenda.x_unidade as unidade',
                'agenda.x_periodos as periodo',
                'agenda.x_cidade as cidade',
                'agenda.x_procedimento as procedimento',
                'agenda.x_obs as obs',
                'agenda.x_colaborador_id as id_colaborador',
                'colaboradores.c_nome_completo as nome',
                'colaboradores.c_email as email',
                'colaboradores.c_tipo as tipo'
            )
            ->where('x_data', '=', $data)
            ->get();

        return response()->json($agenda, 200);
    }

    public function cadastrar(Request $request)
    {
        $dados = $request->input();
        $id_colaborador = $dados['id'];
        $data = $dados['data'];
        $unidade = $dados['unidade'];
        $periodos = $dados['periodos'];
        $cidade = $dados['cidade'];
        $procedimento = $dados['procedimento'];
        $obs = '' . $dados['obs'] . '';


        $ageda = new Agenda();
        $ageda->x_data = $data;
        $ageda->x_colaborador_id = $id_colaborador;
        $ageda->x_unidade = $unidade;
        $ageda->x_periodos = $periodos;
        $ageda->x_cidade = $cidade;
        $ageda->x_procedimento = $procedimento;
        $ageda->x_obs = $obs;

        $ageda->save();

        return response()->json([
            "message" => "Sucesso."

        ], 201);
    }

    public function deletar(Request $request, $id)
    {

        $tipo = $request->session()->get('tipo');

        if ($tipo === 1 || $tipo === 2) {
            return response()->json([
                'message' => "Você não tem autorização para acessar essa página",
            ], 401);
        }

        if (Agenda::where('x_id', $id)->exists()) {
            $deletados = Agenda::where('x_id', $id)->delete();

            return response()->json([
                "message" => "Sucesso"
            ], 202);
        } else {
            return response()->json([
                "message" => "Falha ao deletar evento"

            ], 404);
        }
    }
}
