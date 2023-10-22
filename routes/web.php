<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\EventController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\AuthController;
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

/* ROTAS DE AUTENTICAÇÃO */
Route::post('/login/auth', [AuthController::class, 'login']);




Route::middleware(['unauthenticated'])->group(function () {

    /* ROTAS DE INICIO */
    Route::get('/inicio', [EventController::class, 'inicio'])->name('protegida.inicio');

    /* ROTAS DE AUTENTICAÇÃO */
    Route::get('/logout', [AuthController::class, 'logout']);

    /* ROTAS USUÁRIOS */
    Route::get('/usuarios', [UsuarioController::class, 'lista_usuarios'])->name('protegida.usuarios');
    Route::get('/usuario', [UsuarioController::class, 'formulario_usuario'])->name('protegida.usuario');
    Route::post('/usuario/novo', [UsuarioController::class, 'cadastra_usuario'])->name('protegida.usuario_novo');
    Route::post('/usuario/edita/{id}', [UsuarioController::class, 'edita_usuario'])->name('protegida.usuario_edita');
    Route::post('/usuario/remove', [UsuarioController::class, 'remove_usuario'])->name('protegida.usuario_remove');
    Route::post('/usuario/verifica_email', [UsuarioController::class, 'verifica_email_duplicado'])->name('protegida.usuario_verifica_email');

    /* ROTAS PESSOAS */
    Route::get('/pessoas', [PessoaController::class, 'lista_pessoas'])->name('protegida.pessoas');
    Route::get('/pessoa', [PessoaController::class, 'formulario_pessoa'])->name('protegida.pessoa');
    Route::post('/pessoa/novo', [PessoaController::class, 'cadastra_pessoa'])->name('protegida.pessoa_novo');
    Route::post('/pessoa/edita/{id}', [PessoaController::class, 'edita_pessoa'])->name('protegida.pessoa_edita');
    Route::post('/pessoa/remove', [PessoaController::class, 'remove_pessoa'])->name('protegida.pessoa_remove');

    /* ROTAS FUNCIONÁRIOS */
    Route::get('/funcionarios', [FuncionarioController::class, 'lista_funcionarios'])->name('protegida.funcionarios');
    Route::get('/funcionario', [FuncionarioController::class, 'formulario_funcionario'])->name('protegida.funcionario');
    Route::post('/funcionario/novo', [FuncionarioController::class, 'cadastra_funcionario'])->name('protegida.funcionario_novo');
    Route::post('/funcionario/edita/{id}', [FuncionarioController::class, 'edita_funcionario'])->name('protegida.funcionario_edita');
    Route::post('/funcionario/remove', [FuncionarioController::class, 'remove_funcionario'])->name('protegida.funcionario_remove');

});


