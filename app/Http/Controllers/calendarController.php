<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class calendarController extends Controller
{
    public function getAll(Request $request)
    {
        $id_colaborador = $request->session()->get('id');
        $tipo = $request->session()->get('tipo');

        if ($tipo === 1) {
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
                ->where(function ($query) use ($id_colaborador) {
                    $query->where('colaboradores.c_id', $id_colaborador);
                })->get();
        } else {
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
        }

        $return = array();
        $decode = json_decode($agenda, TRUE);
        foreach ($decode as $valor) {

            $rec_nome = explode(" ", $valor["nome"]);

            $medico = "Dr. " . $rec_nome[0] . " " . $rec_nome[1][0];
            $return[] = array(

                'id' => $valor["id_agenda"],
                'start' => $valor["data"],
                'title' => $medico . " - " . $valor["unidade"] . " - " . $valor["periodo"] . " - " . $valor["cidade"] . " - " . $valor["procedimento"],

            );
        }

        return response()->json($return, 200);
    }

    public function getEvent($id)
    {

        $Evento = DB::table('agenda')
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
            ->where('agenda.x_id', '=', $id)
            ->get();



        return response()->json($Evento, 200);
    }
}
