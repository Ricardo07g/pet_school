<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\EventController;
use App\Http\Controllers\UsuarioController;
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

Route::get('/', [EventController::class, 'index']);
Route::get('/inicio', [EventController::class, 'inicio']);

Route::get('/usuarios', [UsuarioController::class, 'lista_usuarios']);
Route::get('/usuario', [UsuarioController::class, 'formulario_usuario']);
Route::post('/usuario/novo', [UsuarioController::class, 'cadastra_usuario']);
Route::post('/usuario/edita/{id}', [UsuarioController::class, 'edita_usuario']);
Route::post('/usuario/remove', [UsuarioController::class, 'remove_usuario']);

Route::get('/funcionarios', function () {
    $payload = array();
    return view('/funcionario/funcionario_listar');
});