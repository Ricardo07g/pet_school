<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\EventController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\FuncionarioController;
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

/* ROTAS DE INICIO */
Route::get('/', [EventController::class, 'index']);
Route::get('/inicio', [EventController::class, 'inicio']);

/* ROTAS USUÁRIOS */
Route::get('/usuarios', [UsuarioController::class, 'lista_usuarios']);
Route::get('/usuario', [UsuarioController::class, 'formulario_usuario']);
Route::post('/usuario/novo', [UsuarioController::class, 'cadastra_usuario']);
Route::post('/usuario/edita/{id}', [UsuarioController::class, 'edita_usuario']);
Route::post('/usuario/remove', [UsuarioController::class, 'remove_usuario']);

/* ROTAS PESSOAS */
Route::get('/pessoas', [PessoaController::class, 'lista_pessoas']);
Route::get('/pessoa', [PessoaController::class, 'formulario_pessoa']);
Route::post('/pessoa/novo', [PessoaController::class, 'cadastra_pessoa']);
Route::post('/pessoa/edita/{id}', [PessoaController::class, 'edita_pessoa']);
Route::post('/pessoa/remove', [PessoaController::class, 'remove_pessoa']);

/* ROTAS FUNCIONÁRIOS */
Route::get('/funcionarios', [FuncionarioController::class, 'lista_funcionarios']);
Route::get('/funcionario', [FuncionarioController::class, 'formulario_funcionario']);
Route::post('/funcionario/novo', [FuncionarioController::class, 'cadastra_funcionario']);
Route::post('/funcionario/edita/{id}', [FuncionarioController::class, 'edita_funcionario']);
Route::post('/funcionario/remove', [FuncionarioController::class, 'remove_funcionario']);

/*
Route::get('/funcionarios', function () {
    $payload = array();
    return view('/funcionario/funcionario_listar');
});
*/