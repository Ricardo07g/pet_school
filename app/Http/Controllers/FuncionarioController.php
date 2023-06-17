<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class FuncionarioController extends Controller
{
    public function index()
    {
        $FuncionarioClass = Funcionario::all();
    }

    public function lista_funcionarios()
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


    public function formulario_funcionario()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de funcionários', 'route'=>'/funcionarios'),
            array('index'=> (request('i')) ? 'Editar funcionário' :'Cadastrar funcionário', 'route'=>'/funcionario')
        );
    
        $dados_funcionario = NULL;
    
        if(request('i') != NULL)
        {
            try {
                $dados_funcionario = DB::table('funcionario')
                ->selectRaw('
                    pessoa.cpf,
                    CONCAT(pessoa.nome, " ", pessoa.sobrenome) AS nome_completo,
                    pessoa.dt_nascimento,
                    funcionario.id_cargo,
                    funcionario.ativo
                ')
                ->join('pessoa', 'pessoa.id_pessoa', '=', 'funcionario.id_pessoa')
                ->join('cargo', 'cargo.id_cargo', '=', 'funcionario.id_cargo')
                ->where('id_funcionario', request('i'))->first();

            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        }

        $dados_funcionario_cargo = DB::table('cargo')->get();
    
        $payload = array('id' => request('i'), 'routes' => $routes, 'funcionario' => $dados_funcionario, 'cargos_usuario' => $dados_funcionario_cargo);
    
        return view('/funcionario/funcionario_form',$payload);
    }

    public function cadastra_funcionario(Request $request)
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de usuários', 'route'=>'/usuarios'),
        );

        try
        {
            DB::beginTransaction();

            $usuario = new Usuario;

            $usuario->nome          = $request->nome;
            $usuario->sobrenome     = $request->sobrenome;
            $usuario->cpf           = $request->cpf;
            $usuario->dt_nascimento = $request->dt_nascimento;
    
            $usuario->save();
            DB::commit();

            return redirect('/usuarios')->with('success','Usuário inserido com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/usuarios')->with('error','Erro! Não foi possível inserir usuário. Por favor, procure o administrador do sistema.');
        }
    }

    public function edita_funcionario(Request $request, $id_usuario)
    {
        try
        {
            DB::beginTransaction();

            Usuario::where('id_usuario', '=', $id_usuario)->update([  
                    'nome' => $request->nome,
                    'sobrenome' => $request->sobrenome,
                    'dt_nascimento' => $request->dt_nascimento
                ]);
            
            DB::commit();

            return redirect('/usuarios')->with('success','Dados do usuário atualizados com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/usuarios')->with('error', 'Erro! Não foi possível atualizar os dados do usuário. Por favor, procure o administrador do sistema.');
        }
    }

    public function remove_funcionario(Request $request)
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de funcionários', 'route'=>'/funcionarios'),
        );
        $retorno = array();
        try
        {
            DB::beginTransaction();
            Usuario::where('id_usuario', '=', $request->id)->delete();
            DB::commit();

            $retorno = ['status' => 'sucesso', 'msg'=>'Removido com sucesso', 'id' => $request->id];

        }catch (\Throwable $e) {
            DB::rollback();

            $retorno = ['status' => 'erro', 'msg'=>'Erro! Não foi possível remover usuário. Por favor, procure o administrador do sistema.', 'id' => $request->id];
        }finally{

            return response()->json($retorno);
        }
    }
}
