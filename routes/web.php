<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('hasSession');

Route::get('/incluir', function () {
    return view('incluir');
})->middleware('hasSession', 'adminArea');

Route::get('/dia', function () {
    return view('dia');
})->middleware('hasSession', 'adminArea');

Route::get('/colaboradores', function () {
    return view('colaboradores');
})->middleware('hasSession', 'adminArea');



Route::get('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/'); //login page
});
