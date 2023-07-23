<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Pessoa;

class PessoaController extends Controller
{
    public function index()
    {
        $PessoaClass = Pessoa::all();
    }

    public function lista_pessoas()
    {

        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de pessoas', 'route'=>'/pessoas'),
        );
            
        try {

            $parametro = (@$_GET['a'] === NULL || @$_GET['a'] === '' || !in_array(@$_GET['a'],[-1,0,1])) ? 1 : @$_GET['a'];

            $array_campos =  ($parametro == -1) ? [0,1] : [$parametro];

            $dados_pessoas = DB::table('pessoa')
            ->selectRaw('
                pessoa.id_pessoa,
                CONCAT(pessoa.nome," ", pessoa.sobrenome) as nome,
                pessoa.dt_nascimento,
                pessoa.cpf
            ')
            ->get();

        } catch (\Throwable $e) {
            throw $e->getMessage();
        }
        
        $payload = array('routes' => $routes, 'pessoas' => $dados_pessoas, 'parametro_busca' => $parametro);
        
        return view('/pessoa/pessoa_listar',$payload);
    }

    public function formulario_pessoa()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de pessoas', 'route'=>'/pessoas'),
            array('index'=> (request('i')) ? 'Editar pessoa' :'Cadastrar pessoa', 'route'=>'/pessoa')
        );
    
        $dados_pessoa = NULL;
    
        if(request('i') != NULL)
        {
            try {
                $dados_pessoa = DB::table('pessoa')
                ->selectRaw('
                    pessoa.id_pessoa,
                    pessoa.cpf,
                    pessoa.nome,
                    pessoa.sobrenome,
                    pessoa.dt_nascimento
                ')
                ->where('id_pessoa', request('i'))->first();

            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        }
    
        $payload = array(
                'id' => request('i'), 
                'routes' => $routes,
                'pessoa' => $dados_pessoa
            );
    
        return view('/pessoa/pessoa_form',$payload);
    }

    public function cadastra_pessoa(Request $request)
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de pessoas', 'route'=>'/pessoas'),
        );

        try
        {
            DB::beginTransaction();

            $pessoa = new Pessoa;

            $pessoa->nome           = $request->nome;
            $pessoa->sobrenome      = $request->sobrenome;
            $pessoa->dt_nascimento  = $request->dt_nascimento;
            $pessoa->cpf            = $request->cpf;
            
            $pessoa->save();

            DB::commit();

            return redirect('/pessoas')->with('success','Pessoa inserida com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/pessoas')->with('error','Erro! Não foi possível inserir pessoa. Por favor, procure o administrador do sistema.');
        }
    }

    public function edita_pessoa(Request $request, $id_pessoa)
    {
        try
        {
            DB::beginTransaction();

            pessoa::where('id_pessoa', '=', $id_pessoa)->update([  
                    'nome' => $request->nome,
                    'sobrenome' => $request->sobrenome,
                    'dt_nascimento' => $request->dt_nascimento,
                    'cpf'  => $request->cpf,
                ]);
            
            DB::commit();

            return redirect('/pessoas')->with('success','Dados da pessoa atualizados com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/pessoas')->with('error', 'Erro! Não foi possível atualizar os dados desta pessoa. Por favor, procure o administrador do sistema.');
        }
    }

    public function remove_pessoa(Request $request)
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de pessoas', 'route'=>'/pessaos'),
        );
        $retorno = array();
        try
        {
            DB::beginTransaction();
            pessoa::where('id_pessoa', '=', $request->id)->delete();
            DB::commit();

            $retorno = ['status' => 'sucesso', 'msg'=>'Removido com sucesso', 'id' => $request->id];

        }catch (\Throwable $e) {
            DB::rollback();

            $retorno = ['status' => 'erro', 'msg'=>'Erro! Não foi possível remover esta pessoa. Por favor, procure o administrador do sistema.', 'id' => $request->id];
        }finally{

            return response()->json($retorno);
        }
    }

}
