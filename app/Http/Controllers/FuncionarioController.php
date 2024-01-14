<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use APP\Models\Pessoa;

class FuncionarioController extends Controller
{
    private function index()
    {
        $FuncionarioClass = Funcionario::all();
    }

    protected function lista_funcionarios()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de funcionários', 'route'=>'/funcionarios'),
        );
            
        try {

            $parametro = (@$_GET['a'] === NULL || @$_GET['a'] === '' || !in_array(@$_GET['a'],[-1,0,1])) ? 1 : @$_GET['a'];
            
            $array_campos =  ($parametro == -1) ? [0,1] : [$parametro];

            $dados_cargos = DB::table('cargo')->get();

            $dados_funcionarios = DB::table('funcionario')
                        ->selectRaw('
                            funcionario.id_funcionario,
                            funcionario.ativo,
                            cargo.descricao AS cargo,
                            pessoa.nome,
                            pessoa.sobrenome,
                            pessoa.dt_nascimento,
                            pessoa.cpf
                        ')
                        ->join('pessoa', 'pessoa.id_pessoa', '=', 'funcionario.id_pessoa')
                        ->join('cargo', 'cargo.id_cargo', '=', 'funcionario.id_cargo')
                        ->whereIn('funcionario.ativo',$array_campos)
                        ->get();
        } catch (\Throwable $e) {
            throw $e->getMessage();
        }
        
        $payload = array(
                'routes' => $routes,
                'funcionarios' => $dados_funcionarios,
                'cargos' => $dados_cargos,
                'parametro_busca' => $parametro
            );
        
        return view('/funcionario/funcionario_listar',$payload);
    }

    protected function formulario_funcionario()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de funcionários', 'route'=>'/funcionarios'),
            array('index'=> (request('i')) ? 'Editar' :'Cadastrar', 'route'=>'/funcionario')
        );
    
        $dados_funcionario = NULL;
        $dados_pessoas = array();
    
        if(request('i') != NULL)
        {
            try {
                $dados_funcionario = DB::table('funcionario')
                ->selectRaw('
                    pessoa.id_pessoa,
                    pessoa.cpf,
                    CONCAT(pessoa.nome, " ", pessoa.sobrenome) AS nome_completo,
                    pessoa.dt_nascimento,
                    pessoa.foto_perfil,
                    funcionario.id_cargo,
                    funcionario.ativo
                ')
                ->join('pessoa', 'pessoa.id_pessoa', '=', 'funcionario.id_pessoa')
                ->join('cargo', 'cargo.id_cargo', '=', 'funcionario.id_cargo')
                ->where('id_funcionario', request('i'))->first();

            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        }else{
            $dados_pessoas = DB::table('pessoa')
            ->selectRaw('
                pessoa.id_pessoa,
                CONCAT(pessoa.nome, " ", pessoa.sobrenome) AS nome_completo,
                pessoa.cpf,
                pessoa.dt_nascimento,
                pessoa.foto_perfil
            ')
            ->leftJoin('funcionario', 'pessoa.id_pessoa', '=', 'funcionario.id_pessoa')
            ->whereNull('funcionario.id_pessoa')
            ->get();
        }

        $dados_funcionario_cargo = DB::table('cargo')->get();
    
        $payload = array(
                'id' => request('i'), 
                'routes' => $routes,
                'funcionario' => $dados_funcionario,
                'cargos_usuario' => $dados_funcionario_cargo,
                'dados_pessoas' => $dados_pessoas
            );
    
        return view('/funcionario/funcionario_form',$payload);
    }

    protected function cadastra_funcionario(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $funcionario = new Funcionario;

            $funcionario->id_pessoa  = $request->id_pessoa;
            $funcionario->id_cargo   = $request->cargo_funcionario;
            $funcionario->ativo      = $request->ativo;
            
            $funcionario->save();

            DB::commit();

            $retorno = array(
                        'rota' => '/funcionarios',
                        'status' => 'success', 
                        'msg' => 'Funcionario inserido com sucesso!'
                    );

        }catch (\Throwable $e) {
            
            DB::rollback();
            $retorno = array(
                        'rota' => '/funcionarios',
                        'status' => 'error',
                        'msg' => 'Erro! Não foi possível inserir funcionário. Por favor, procure o administrador do sistema.'
                    );
        
        }finally{

            return redirect($retorno['rota'])->with($retorno['status'], $retorno['msg']);
        }
    }

    protected function edita_funcionario(Request $request, $id_funcionario)
    {
        try
        {
            DB::beginTransaction();

            Funcionario::where('id_funcionario', '=', $id_funcionario)->update([  
                    'id_pessoa' => $request->id_pessoa,
                    'id_cargo'  => $request->cargo_funcionario,
                    'ativo'     => $request->ativo
                ]);
            
            DB::commit();

            $retorno = array(
                        'rota' => '/funcionarios',
                        'status' => 'success', 
                        'msg' => 'Funcionário atualizado com sucesso!'
                    );

        }catch (\Throwable $e) {

            DB::rollback();

            $retorno = array(
                'rota' => '/funcionarios',
                'status' => 'error', 
                'msg' => 'Erro! Não foi possível atualizar este funcionário. Por favor, procure o administrador do sistema.'
            );

        }finally{

            return redirect($retorno['rota'])->with($retorno['status'], $retorno['msg']);
        }
    }

    protected function remove_funcionario(Request $request)
    {
        try
        {
            DB::beginTransaction();
            Funcionario::where('id_funcionario', '=', $request->id)->delete();
            DB::commit();

            $retorno = ['status' => 'sucesso', 'msg'=>'Removido com sucesso', 'id' => $request->id];

        }catch (\Throwable $e) {

            DB::rollback();

            $retorno = ['status' => 'erro', 'msg'=>'Erro! Não foi possível remover este funcionário. Por favor, procure o administrador do sistema.', 'id' => $request->id];
       
        }finally{

            return response()->json($retorno);
        }
    }
}
