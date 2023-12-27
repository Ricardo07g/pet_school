<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\EventController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfiguracoesController;
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
    Route::get('/logout', [AuthController::class, 'logout'])->name('protegida.logout');


    /* ROTAS DE CONFIGURAÇÃO */
    Route::get('/configuracoes',[ConfiguracoesController::class, 'lista_configuracoes'])->name('protegida.configuracoes');
        //GRUPOS DE USUÁRIO
    Route::get('/grupos_usuario',[ConfiguracoesController::class, 'lista_grupos_usuario'])->name('protegida.config_grupos_usuario');
    Route::get('/grupos_usuario_form',[ConfiguracoesController::class, 'formulario_grupos_usuario'])->name('protegida.grupos_usuario_form');
    Route::post('/grupos_usuario/novo', [ConfiguracoesController::class, 'cadastra_grupo_usuario'])->name('protegida.grupo_usuario_novo');
    Route::post('/grupos_usuario/edita/{id}', [ConfiguracoesController::class, 'edita_grupo_usuario'])->name('protegida.grupo_usuario_edita');
    Route::post('/grupos_usuario/remove', [ConfiguracoesController::class, 'remove_grupo_usuario'])->name('protegida.grupo_usuario_remove');
        //CARGOS DE FUNCIONÁRIO
    Route::get('/funcoes_funcionario',[ConfiguracoesController::class, 'lista_cargos_funcionario'])->name('protegida.config_funcoes_funcionario');
    Route::get('/funcoes_funcionario_form',[ConfiguracoesController::class, 'formulario_cargo_funcionario'])->name('protegida.funcoes_funcionario_form');
    Route::post('/funcoes_funcionario/novo', [ConfiguracoesController::class, 'cadastra_cargo_funcionario'])->name('protegida.funcoes_funcionario_novo');
    Route::post('/funcoes_funcionario/edita/{id}', [ConfiguracoesController::class, 'edita_cargo_funcionario'])->name('protegida.funcoes_funcionario_edita');
    Route::post('/funcoes_funcionario/remove', [ConfiguracoesController::class, 'remove_cargo_funcionario'])->name('protegida.funcoes_funcionario_remove');

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
    Route::post('/pessoa/verifica_email', [PessoaController::class, 'verifica_email_duplicado'])->name('protegida.pessoa_verifica_email');


    /* ROTAS FUNCIONÁRIOS */
    Route::get('/funcionarios', [FuncionarioController::class, 'lista_funcionarios'])->name('protegida.funcionarios');
    Route::get('/funcionario', [FuncionarioController::class, 'formulario_funcionario'])->name('protegida.funcionario');
    Route::post('/funcionario/novo', [FuncionarioController::class, 'cadastra_funcionario'])->name('protegida.funcionario_novo');
    Route::post('/funcionario/edita/{id}', [FuncionarioController::class, 'edita_funcionario'])->name('protegida.funcionario_edita');
    Route::post('/funcionario/remove', [FuncionarioController::class, 'remove_funcionario'])->name('protegida.funcionario_remove');

    /* ROTAS PET */
    Route::get('/pets', [PetController::class, 'lista_pets'])->name('protegida.pets');

});
