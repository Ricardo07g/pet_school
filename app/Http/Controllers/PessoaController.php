<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Pessoa;

class PessoaController extends Controller
{   
    private $debug = false;

    private function index()
    {
        $PessoaClass = Pessoa::all();
    }

    protected function lista_pessoas()
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
            ->paginate(20);

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
            array('index'=> (request('i')) ? 'Editar' :'Cadastrar', 'route'=>'/pessoa')
        );
    
        $dados_pessoa = NULL;

        try
        {
            $dados_sexo = DB::table('sexo')->get();
            $dados_cor_raca = DB::table('cor_raca')->get();
            $dados_estado_civil = DB::table('estdo_civil')->get();
            $dados_escolaridade = DB::table('escolaridade')->get();
            $dados_tipo_logradouro = DB::table('tipo_logradouro')->get();
            $dados_unidades_federativas = DB::table('unidades_federativas')->get();

            if(request('i') != NULL)
            {
                $dados_pessoa = DB::table('pessoa')
                ->selectRaw('
                    pessoa.id_pessoa,
                    pessoa.cpf,
                    pessoa.nome,
                    pessoa.sobrenome,
                    pessoa.dt_nascimento,
                    pessoa.email,
                    pessoa.telefone_notificacao,
                    sexo.id_sexo,
                    cor_raca.id_cor_raca,
                    estdo_civil.id_estdo_civil,
                    escolaridade.id_escolaridade,
                    pessoa.end_cep,
                    pessoa.end_id_tipo_logradouro,
                    pessoa.end_logradouro,
                    pessoa.end_numero,
                    pessoa.end_complemento,
                    pessoa.end_bairro,
                    pessoa.end_uf,
                    pessoa.end_municipio
                ')
                ->leftJoin('sexo', 'sexo.id_sexo', '=', 'pessoa.id_sexo')
                ->leftJoin('cor_raca', 'cor_raca.id_cor_raca', '=', 'pessoa.id_cor_raca')
                ->leftJoin('estdo_civil', 'estdo_civil.id_estdo_civil', '=', 'pessoa.id_estdo_civil')
                ->leftJoin('escolaridade', 'escolaridade.id_escolaridade', '=', 'pessoa.id_escolaridade')
                ->where('pessoa.id_pessoa', request('i'))->first();
            }

        } catch (\Throwable $e) {
            throw $e->getMessage();
        }
        $payload = array(
                'id' => request('i'), 
                'routes' => $routes,
                'pessoa' => $dados_pessoa,
                'sexo_sistema' => $dados_sexo,
                'cor_raca_sistema' => $dados_cor_raca,
                'estado_civil_sistema' => $dados_estado_civil,
                'escolaridade_sistema' => $dados_escolaridade,
                'tipo_logradouro_sistema' => $dados_tipo_logradouro,
                'unidades_federativas' => $dados_unidades_federativas
            );
    
        return view('/pessoa/pessoa_form',$payload);
    }

    public function cadastra_pessoa(Request $request)
    {   
        try
        {
            DB::beginTransaction();

            $pessoa = new Pessoa;

            $pessoa->nome                   = $request->nome;
            $pessoa->sobrenome              = $request->sobrenome;
            $pessoa->dt_nascimento          = $request->dt_nascimento;
            $pessoa->cpf                    = $request->cpf;
            $pessoa->email                  = $request->email;
            $pessoa->telefone_notificacao   = $request->telefone_notificacao;
            $pessoa->id_sexo                = $request->sexo;
            $pessoa->id_cor_raca            = $request->cor_raca;
            $pessoa->id_estdo_civil         = $request->estdo_civil;
            $pessoa->id_escolaridade        = $request->escolaridade;
            $pessoa->end_cep                = $request->cep;
            $pessoa->end_id_tipo_logradouro = $request->end_tipo_logradouro;
            $pessoa->end_logradouro         = $request->logradouro;
            $pessoa->end_numero             = $request->numero;
            $pessoa->end_complemento        = $request->complemento;
            $pessoa->end_bairro             = $request->bairro;
            $pessoa->end_uf                 = $request->estado;
            $pessoa->end_municipio          = $request->municipio;
            
            $pessoa->save();

            DB::commit();

            $retorno = array(
                        'rota' => '/pessoas',
                        'status' => 'success', 
                        'msg' => 'Pessoa inserida com sucesso!'
                    );

        }catch (\Throwable $e) {

            DB::rollback();

            $retorno = array(
                        'rota' => '/pessoas',
                        'status' => 'error', 
                        'msg' => ($this->debug == true) ? "<pre>".$e->getMessage()."</pre>" : 'Erro! Não foi possível atualizar os dados desta pessoa. Por favor, procure o administrador do sistema.'
                    );

        }finally{

            return redirect($retorno['rota'])->with($retorno['status'], $retorno['msg']);
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
                    'email'  => $request->email,
                    'telefone_notificacao'  => $request->telefone_notificacao,
                    'id_sexo'  => $request->sexo,
                    'id_cor_raca'  => $request->cor_raca,
                    'id_estdo_civil'  => $request->estdo_civil,
                    'id_escolaridade'  => $request->escolaridade,
                    'end_cep' => $request->cep,
                    'end_id_tipo_logradouro' => @$request->end_tipo_logradouro,
                    'end_logradouro' => $request->logradouro,
                    'end_numero' => $request->numero,
                    'end_complemento' => $request->complemento,
                    'end_bairro' => $request->bairro,
                    'end_uf' => $request->estado,
                    'end_municipio'  => $request->municipio
                ]);
            
            DB::commit();

            $retorno = array(
                'rota' => '/pessoas',
                'status' => 'success', 
                'msg' => 'Pessoa atualizada com sucesso!'
            );

        }catch (\Throwable $e) {

            DB::rollback();

            $retorno = array(
                'rota' => '/pessoas',
                'status' => 'error', 
                'msg' => ($this->debug == true) ? "<pre>".$e->getMessage()."</pre>" : 'Erro! Não foi possível atualizar esta pessoa. Por favor, procure o administrador do sistema.'
            );
        
        }finally{

            return redirect($retorno['rota'])->with($retorno['status'], $retorno['msg']);
        }
    }

    public function remove_pessoa(Request $request)
    {
        try
        {
            DB::beginTransaction();
            pessoa::where('id_pessoa', '=', $request->id)->delete();
            DB::commit();

            $retorno = ['status' => 'sucesso', 'msg'=>'Removido com sucesso', 'id' => $request->id];

        }catch (\Throwable $e) {
            DB::rollback();

            $retorno = ['status' => 'erro', 'msg'=> ($this->debug) ? $e->getMessage() : 'Erro! Não foi possível remover esta pessoa. Por favor, procure o administrador do sistema.', 'id' => $request->id];
        }finally{

            return response()->json($retorno);
        }
    }

    public function verifica_email_duplicado(Request $request,)
    {   
        try
        {   
            if(!empty(request('id')) && request('id') != '-1')
            {

                $dados = DB::table('pessoa')
                        ->selectRaw('pessoa.id_pessoa, pessoa.email')
                        ->where('pessoa.email', request('email'))->first();
               
                if(!empty($dados) && $dados->id_pessoa != request('id'))
                {
                    $flag = 'false';

                }else{
                    $flag = 'true';
                }  

            }else{
                
                $dados = DB::table('pessoa')
                        ->selectRaw('pessoa.id_pessoa, pessoa.email')
                        ->where('email', request('email'))->first();

                if(!empty($dados))
                {
                    $flag = 'false';

                }else{
                    $flag = 'true';
                }    
            } 

            $retorno = ['status' => 'sucesso', 'msg' => 'E-mail verificado com sucesso!', 'flag' => @$flag, 'dados'=> $dados];

        }catch (\Throwable $e) {

            $retorno = ['status' => 'erro', 'msg' => $e->getMessage(), 'flag' => @$flag, 'dados'=> $dados];
        
        }finally{

            return response()->json($retorno);
        }
        
    }

}
