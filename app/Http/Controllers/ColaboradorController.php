<?php

namespace App\Http\Controllers;

use App\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ColaboradorController extends Controller
{
    public function getAll()
    {
        $allColaboradores = Colaboradores::get()->toJson(JSON_PRETTY_PRINT);
        return response($allColaboradores, 200);
    }

    function GerarUsuario($nome)
    {
        //transforma o nome tudo em minusculo
        $nome = strtolower($nome);

        //remove toda a acentuação do nome
        $nome = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $nome);


        //transforma a string em array separado por ' ' espaço
        $parte = explode(" ", $nome);


        $usuario = "";

        if (count($parte) > 1) {
            //pega o primeiro item do array, e o ultimo e une com '.'
            $usuario = $parte[0] . "." . $parte[count($parte) - 1];
        } else {
            //pega somente o primeiro
            $usuario = $parte[0];
        }

        return $usuario;
    }

    function GerarSenha($lenght = 10)
    {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $lenght; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function create(Request $request)
    {
        $data = $request->json()->all();

        $_nome_completo = $data['nome_completo'];
        $_email = $data['email'];
        $_tipo = $data['tipo'];
        //nome gerado por função
        $usuario = $this->GerarUsuario($_nome_completo);
        //gera senha do usuario
        $senha = $this->GerarSenha();
        //gera key de autenticacao
        $key = $this->GerarSenha(50);

        $colaborador = new Colaboradores();
        $colaborador->c_nome_completo = $_nome_completo;
        $colaborador->c_email = $_email;
        $colaborador->c_tipo = $_tipo;
        $colaborador->c_usuario = $usuario;
        $colaborador->c_senha = $senha;
        $colaborador->c_key = $key;

        $colaborador->save();

        return response()->json([
            "message" => "Colaborador incluso com sucesso. Utilize os dados abaixo para logar",
            "email" =>  $_email,
            "usuario" => $usuario,
            "senha" => $senha,

        ], 201);
    }

    public function logar(Request $request)
    {
        $data = $request->json()->all();

        // Get user by email
        $colaborador = Colaboradores::where('c_email', $data['email'])->first();

        // Validate Company
        if (!$colaborador) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        // Validate Password
        if ($data['senha'] !== $colaborador->c_senha) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }



        return response()->json([
            'id' => $colaborador->c_id,
            'acess_key' => $colaborador->c_key,
            'tipo' => $colaborador->c_tipo
        ]);
    }
}
