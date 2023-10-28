<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\GrupoUsuario;

class ConfiguracoesController extends Controller
{
    public function  lista_configuracoes()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Configurações', 'route'=>'/configuracoes'),
        );

        try
        {



        } catch (\Throwable $e) {
            throw $e->getMessage();
        }
        
        $payload = array('routes' => $routes, 'configuracoes' => NULL, 'parametro_busca' => NULL);
        
        return view('/configuracoes/configuracoes_form',$payload);
    }

    /* FUNÇÕES GRUPOS DE USUÁRIO */
    public function lista_grupos_usuario()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Configurações', 'route'=>'/configuracoes'),
            array('index'=> 'Grupos de usuário', 'route'=>'/grupos/usuario/listar'),
        );

        try
        {
            $parametro = (@$_GET['a'] === NULL || @$_GET['a'] === '' || !in_array(@$_GET['a'],[-1,0,1])) ? -1 : @$_GET['a'];
            $array_campos =  ($parametro == -1) ? [0,1] : [$parametro];

            $grupos_usuario = DB::table('usuario_grupo')
            ->selectRaw('
                usuario_grupo.id_grupo_usuario,
                usuario_grupo.descricao,
                usuario_grupo.nativo
            ')
            ->whereIn('usuario_grupo.nativo',$array_campos)
            ->get();


        } catch (\Throwable $e) {
            throw $e->getMessage();
        }
        
        $payload = array('routes' => $routes, 'grupos_usuario' => $grupos_usuario, 'parametro_busca' => $parametro);
        
        return view('/configuracoes/grupos_usuario/grupos_usuario_listar',$payload);
    }

     public function formulario_grupos_usuario()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Configurações', 'route'=>'/configuracoes'),
            array('index'=> 'Grupos de usuário', 'route'=>'/grupos_usuario'),
            array('index'=> (request('i')) ? 'Editar' :'Novo', 'route'=>'/configuracoes/grupos_usuario/grupos_usuario_listar')
        );
    
        $grupo_usuario = NULL;
    
        if(request('i') != NULL)
        {
            try {

                $grupo_usuario = DB::table('usuario_grupo')
                    ->selectRaw('
                        usuario_grupo.id_grupo_usuario,
                        usuario_grupo.descricao,
                        usuario_grupo.nativo
                    ')
                    ->where('usuario_grupo.id_grupo_usuario', request('i'))->first();

            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        }else{

            $grupo_usuario = DB::table('usuario_grupo')
                ->selectRaw('
                    usuario_grupo.id_grupo_usuario,
                    usuario_grupo.descricao,
                    usuario_grupo.nativo
                ')
                ->get();
        }
    
        $payload = array(
                'id' => request('i'), 
                'routes' => $routes,
                'grupo_usuario' => $grupo_usuario
            );
    
        return view('/configuracoes/grupos_usuario/grupos_usuario_form',$payload);
    }

    public function cadastra_grupo_usuario(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $grupos_usuario = new GrupoUsuario;

            $grupos_usuario->descricao  = trim($request->descricao);
            $grupos_usuario->nativo     = 0;
            
            $grupos_usuario->save();

            DB::commit();

            return redirect('/grupos_usuario')->with('success','Grupo de usuário inserido com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/grupos_usuario')->with('error', 'Erro! Não foi possível inserir grupo de usuário. Por favor, procure o administrador do sistema.');
        }
    }

    public function edita_grupo_usuario(Request $request, $id_grupo_usuario)
    {   

        try
        {
            DB::beginTransaction();

            GrupoUsuario::where('id_grupo_usuario', '=', $id_grupo_usuario)->update([  
                    'descricao' => trim($request->descricao)
                ]);
            
            DB::commit();

            return redirect('/grupos_usuario')->with('success','Dados do grupo de usuário atualizados com sucesso!');

        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/grupos_usuario')->with('error', 'Erro! Não foi possível atualizar os dados do grupo de usuário. Por favor, procure o administrador do sistema.');
        }
    }

    public function remove_grupo_usuario(Request $request)
    {
        $retorno = array();

        try
        {   
            $retorno = ['status' => 'sucesso', 'msg'=>'Removido com sucesso', 'id' => $request->id];

            DB::beginTransaction();

                $grupo_usuario = DB::table('usuario_grupo')
                ->selectRaw('
                    usuario_grupo.id_grupo_usuario,
                    usuario_grupo.descricao,
                    usuario_grupo.nativo
                ')
                ->where('usuario_grupo.id_grupo_usuario', $request->id)->first();

                $dados_usuarios = DB::table('usuarios')
                ->selectRaw('
                    COUNT(usuarios.id_usuario) AS total
                ')
                ->join('usuario_grupo', 'usuario_grupo.id_grupo_usuario', '=', 'usuarios.id_usuario_grupo')
                ->where('usuario_grupo.id_grupo_usuario',$request->id)
                ->whereIn('usuarios.ativo',[0,1])
                ->first();

                if(@$grupo_usuario->nativo == 1)
                {
                    $retorno['status'] = 'erro';
                    $retorno['msg'] = 'Um grupo de usuário nativo não pode ser removido.';

                }else if($dados_usuarios->total > 0)
                {
                    $retorno['status'] = 'erro';
                    $retorno['msg'] = 'Este grupo é utilizado por um ou mais usuários do sistema. Atualize os registros para proseguir';
                
                }else{
                    GrupoUsuario::where('id_grupo_usuario', '=', $request->id)->where('nativo', '=', 0)->delete();
                }
            DB::commit();   

        }catch (\Throwable $e) {
            DB::rollback();
            $retorno = ['status' => 'erro', 'msg'=>'Erro! Não foi possível remover grupoo de usuário. Por favor, procure o administrador do sistema.', 'id' => $request->id];
        }finally{

            return response()->json($retorno);
        }
    }

    /* FUNÇÕES FUNCIONÁRIO */

}
