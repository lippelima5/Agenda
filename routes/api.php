<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Colaboradores;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//colaboradores
Route::get('colaborador', 'ColaboradorController@getAll');
Route::post('colaborador', 'ColaboradorController@create');
Route::post('logar', 'ColaboradorController@logar');


//get agenda
Route::get('agenda', 'AgendaController@getAll');
Route::get('agenda/{id_colaborador}', 'AgendaController@getExclusive');
Route::post('agenda', 'AgendaController@cadastrar');
Route::delete('agenda/{id}', 'AgendaController@deletar');