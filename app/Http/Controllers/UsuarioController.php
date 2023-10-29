<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $UsuarioClass = Usuario::all();
    }

    public function lista_usuarios()
    {

        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de usuários', 'route'=>'/usuarios'),
        );
            
        try {

            $parametro = (@$_GET['a'] === NULL || @$_GET['a'] === '' || !in_array(@$_GET['a'],[-1,0,1])) ? 1 : @$_GET['a'];

            $array_campos =  ($parametro == -1) ? [0,1] : [$parametro];

            $dados_usuarios = DB::table('usuarios')
            ->selectRaw('
                usuarios.id_usuario,
                usuarios.nome,
                usuarios.sobrenome,
                usuarios.ativo,
                usuario_grupo.descricao AS grupo_descricao
            ')
            ->join('usuario_grupo', 'usuario_grupo.id_grupo_usuario', '=', 'usuarios.id_usuario_grupo')
            ->whereIn('usuarios.ativo',$array_campos)
            ->get();

        } catch (\Throwable $e) {
            throw $e->getMessage();
        }
        
        $payload = array('routes' => $routes, 'usuarios' => $dados_usuarios, 'parametro_busca' => $parametro);
        
        return view('/usuario/usuario_listar',$payload);
    }

    public function formulario_usuario()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de usuários', 'route'=>'/usuarios'),
            array('index'=> (request('i')) ? 'Editar usuário' :'Cadastrar usuário', 'route'=>'/usuario')
        );
    
        $dados_usuario = NULL;
    
        if(request('i') != NULL)
        {
            try 
            {
                $dados_usuario = DB::table('usuarios')
                        ->join('usuario_grupo', 'usuario_grupo.id_grupo_usuario', '=', 'usuarios.id_usuario_grupo')
                        ->where('id_usuario', request('i'))
                        ->first();
                
            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        }

        $dados_usuario_grupo =  DB::table('usuario_grupo')->get();
    
        $payload = array('id' => request('i'), 'routes' => $routes, 'usuario' => $dados_usuario, 'grupos_usuario' => $dados_usuario_grupo);
    
        return view('/usuario/usuario_form',$payload);
    }

    public function cadastra_usuario(Request $request)
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de usuários', 'route'=>'/usuarios'),
        );

        try
        {
            DB::beginTransaction();

            $usuario = new Usuario;

            $usuario->nome             = $request->nome;
            $usuario->sobrenome        = $request->sobrenome;
            $usuario->cpf              = $request->cpf;
            $usuario->dt_nascimento    = $request->dt_nascimento;
            $usuario->id_usuario_grupo = $request->grupo_usuario;
            $usuario->email            = $request->email;
            $usuario->senha            = Hash::make($request->senha);
            $usuario->ativo            = 1;
    
            $usuario->save();
            DB::commit();

            return redirect('/usuarios')->with('success','Usuário inserido com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/usuarios')->with('error','Erro! Não foi possível inserir usuário. Por favor, procure o administrador do sistema.');
            //return redirect('/usuarios')->with('error',$e->getMessage());
        }
    }

    public function edita_usuario(Request $request, $id_usuario)
    {
        try
        {
            DB::beginTransaction();
            if(@$id_usuario != 31)
            {
                if(!empty($request->nova_senha))
                {
                    Usuario::where('id_usuario', '=', $id_usuario)->update([  
                        'nome' => $request->nome,
                        'sobrenome' => $request->sobrenome,
                        'dt_nascimento' => $request->dt_nascimento,
                        'ativo' => $request->ativo,
                        'id_usuario_grupo' => $request->grupo_usuario,
                        'email' =>  $request->email,
                        'senha' => Hash::make($request->nova_senha)
                    ]);

                }else{

                    Usuario::where('id_usuario', '=', $id_usuario)->update([  
                        'nome' => $request->nome,
                        'sobrenome' => $request->sobrenome,
                        'dt_nascimento' => $request->dt_nascimento,
                        'ativo' => $request->ativo,
                        'id_usuario_grupo' => $request->grupo_usuario,
                        'email' =>  $request->email,
                    ]);
                }
            }

            DB::commit();

            return redirect('/usuarios')->with('success','Dados do usuário atualizados com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/usuarios')->with('error', 'Erro! Não foi possível atualizar os dados do usuário. Por favor, procure o administrador do sistema.'.'\n'.$e->getMessage());
        }
    }

    public function remove_usuario(Request $request)
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de usuários', 'route'=>'/usuarios'),
        );

        $retorno = array();

        try
        {
            DB::beginTransaction();
            if(@$request->id != 31)
            {
                Usuario::where('id_usuario', '=', $request->id)->delete();
            }
            DB::commit();

            $retorno = ['status' => 'sucesso', 'msg'=>'Removido com sucesso', 'id' => $request->id];

        }catch (\Throwable $e) {
            DB::rollback();

            $retorno = ['status' => 'erro', 'msg'=>'Erro! Não foi possível remover usuário. Por favor, procure o administrador do sistema.', 'id' => $request->id];
            
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

                $dados = DB::table('usuarios')
                        ->selectRaw('usuarios.id_usuario, usuarios.email')
                        ->where('usuarios.email', request('email'))->first();
               
                if(empty($dados) || (!empty($dados) && $dados->id_usuario != request('id')))
                {
                    $flag = 'false';

                }else{
                    $flag = 'true';
                }  

            }else{
                
                $dados = DB::table('usuarios')
                        ->selectRaw('usuarios.id_usuario, usuarios.email')
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
