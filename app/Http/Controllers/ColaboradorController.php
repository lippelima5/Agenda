<?php

namespace App\Http\Controllers;

use App\Colaboradores;
use App\Mail\MailModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ColaboradorController extends Controller
{
    public function getAll(Request $request)
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
        $data = $request->input();



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


        //send email com credenciais
        try {
            $sendEmail = new \stdClass();
            $sendEmail->nome = $_nome_completo;
            $sendEmail->email = $_email;
            $sendEmail->senha = $senha;

            Mail::to($_email)->send(new MailModel($sendEmail));
        } catch (Exception $th) {
            return response()->json([
                "message" => $th,

            ], 400);
        }




        return response()->json([
            "message" => "Colaborador incluso com sucesso. Utilize os dados abaixo para logar",
            "email" =>  $_email,
            "usuario" => $usuario,
            "senha" => $senha,

        ], 201);
    }

    public function logar(Request $request)
    {
        $data = $request->input();
        // Get user by email
        $colaborador = Colaboradores::where('c_email', $data['email'])->first();
        // validar colaborador
        if (!$colaborador) {
            return response()->json([
                'error' => 'Invalid credentials email'
            ], 401);
        }

        // Validate Password
        if ($data['senha'] !== $colaborador->c_senha) {
            return response()->json([
                'error' => 'Invalid credentials senha'
            ], 401);
        }

        $request->session()->put('id', $colaborador->c_id);
        $request->session()->put('acess_key', $colaborador->c_key);
        $request->session()->put('tipo', $colaborador->c_tipo);


        return redirect('dashboard'); //login page

        return redirect()->action(
            'dashboard',
            [
                'tipo' => $colaborador->c_tipo,
                'acess_key' => $colaborador->c_key,
            ]
        );
    }

    public function deletar($id)
    {
        if (Colaboradores::where('c_id', $id)->exists()) {
            $deletados = Colaboradores::where('c_id', $id)->delete();

            return response()->json([
                "message" => "Colaborador deletado com sucesso."
            ], 202);
        } else {
            return response()->json([
                "message" => "Falha ao deletar colaborador"

            ], 404);
        }
    }
}
