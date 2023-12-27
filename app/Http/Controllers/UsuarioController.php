<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;

class UsuarioController extends Controller
{   
    private $debug = false;

    private function index()
    {
        $UsuarioClass = Usuario::all();
    }

    protected function lista_usuarios()
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

    protected function formulario_usuario()
    {
        $routes = array(
            array('index'=> 'Inicio', 'route'=>'/inicio'),
            array('index'=> 'Listagem de usuários', 'route'=>'/usuarios'),
            array('index'=> (request('i')) ? 'Editar' :'Cadastrar', 'route'=>'/usuario')
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

                $dados_usuario->foto_perfil = (!empty($dados_usuario->foto_perfil)) ? $dados_usuario->foto_perfil : 'generic_user.png';
                
            } catch (\Throwable $e) {
                throw $e->getMessage();

            }
        }

        $dados_usuario_grupo =  DB::table('usuario_grupo')->get();
    
        $payload = array('id' => request('i'), 'routes' => $routes, 'usuario' => $dados_usuario, 'grupos_usuario' => $dados_usuario_grupo);
    
        return view('/usuario/usuario_form',$payload);
    }

    protected function cadastra_usuario(Request $request)
    {
        try
        {   
            $request->validate([
                'nome' => 'required|string|max:256',
                'sobrenome' => 'required|string|max:256',
                'cpf' => 'required|string|max:14',
                'dt_nascimento' => 'date',
                'email' => 'required|email',
                'senha' => 'required|string|max:256',
                //'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif,jpeg|max:2048', // Exemplo: tamanho máximo de 2 MB
            ]);

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
    
            

            if(!empty(@$request->foto_perfil))
            {
                try
                {  
                    // Obtenha o caminho temporário do arquivo carregado
                    $imagemTemporaria = $request->file('foto_perfil');

                    // Gere um nome único para a imagem
                    $nomeUnico = uniqid() . '_' . time() . '.' . $imagemTemporaria->extension();

                    // Salve a imagem no armazenamento público
                    //$caminhoImagem = $imagemTemporaria->storeAs('system/images/foto_usuario/', $nomeUnico, 'public');
                    $caminhoImagem = $imagemTemporaria->move(public_path('system/images/foto_usuario/'), $nomeUnico);

                }catch(\Throwable $e){
                    $nomeUnico = NULL;
                }
            }

            $usuario->foto_perfil = $nomeUnico;

            $usuario->save();

            DB::commit();

            $retorno = array(
                'rota' => '/usuarios',
                'status' => 'success', 
                'msg' => 'Usuário inserido com sucesso!'
            );

        }catch (\Throwable $e) {

            DB::rollback();
            //\Illuminate\Validation\ValidationException $e
            //$errors = $e->validator->errors()->messages();
            //dd($errors)

            $retorno = array(
                'rota' => '/usuarios',
                'status' => 'error', 
                'msg' => ($this->debug) ?  $e->getMessage() : 'Erro! Não foi possível inserir este usuário. Por favor, procure o administrador do sistema.'
            );

        }finally{

            return redirect($retorno['rota'])->with($retorno['status'], $retorno['msg']);
        }
    }

    protected function edita_usuario(Request $request, $id_usuario)
    {
        try
        {   
            $request->validate([
                'nome' => 'required|string|max:256',
                'sobrenome' => 'required|string|max:256',
                'cpf' => 'required|string|max:14',
                'dt_nascimento' => 'date',
                'email' => 'required|email',
                'nova_senha' => 'nullable|string|max:256',
                //'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif,jpg|max:2048'
            ]);

            DB::beginTransaction();

            $dados_usuario = DB::table('usuarios')->where('id_usuario', $id_usuario)->first();

            $nomeUnico = @$dados_usuario->foto_perfil;

            if(@$id_usuario != 31)
            {   
                if(!empty(@$request->foto_perfil))
                {
                    try
                    {  
                        // Obtenha o caminho temporário do arquivo carregado
                        $imagemTemporaria = $request->file('foto_perfil');

                        // Gere um nome único para a imagem
                        $nomeUnico = uniqid() . '_' . time() . '.' . $imagemTemporaria->extension();

                        // Salve a imagem no armazenamento público
                        //$caminhoImagem = $imagemTemporaria->storeAs('system/images/foto_usuario/', $nomeUnico, 'public');
                        $caminhoImagem = $imagemTemporaria->move(public_path('system/images/foto_usuario/'), $nomeUnico);

                        if(!empty($dados_usuario->foto_perfil) && Storage::disk('foto_usuario')->exists($dados_usuario->foto_perfil) == true)
                        {
                            Storage::disk('foto_usuario')->delete(@$dados_usuario->foto_perfil);
                        }

                    }catch(\Throwable $e){
                        $nomeUnico = NULL;
                    }
                }

                if(!empty($request->nova_senha))
                {
                    Usuario::where('id_usuario', '=', $id_usuario)->update([  
                        'nome' => $request->nome,
                        'sobrenome' => $request->sobrenome,
                        'dt_nascimento' => $request->dt_nascimento,
                        'ativo' => $request->ativo,
                        'id_usuario_grupo' => $request->grupo_usuario,
                        'email' =>  $request->email,
                        'senha' => Hash::make($request->nova_senha),
                        'foto_perfil' => $nomeUnico
                    ]);

                }else{

                    Usuario::where('id_usuario', '=', $id_usuario)->update([  
                        'nome' => $request->nome,
                        'sobrenome' => $request->sobrenome,
                        'dt_nascimento' => $request->dt_nascimento,
                        'ativo' => $request->ativo,
                        'id_usuario_grupo' => $request->grupo_usuario,
                        'email' =>  $request->email,
                        'foto_perfil' => $nomeUnico
                    ]);
                }
            }

            DB::commit();

            $retorno = array(
                'rota' => '/usuarios',
                'status' => 'success', 
                'msg' => 'Usuário atualizado com sucesso!'
            );
            
        }catch (\Throwable $e) {

            DB::rollback();
            /*
            \Illuminate\Validation\ValidationException $e
            $errors = $e->validator->errors()->messages();
            dd($errors)
            */

            $retorno = array(
                'rota' => '/usuarios',
                'status' => 'error', 
                'msg' => ($this->debug) ? $e->getMessage() : 'Erro! Não foi possível atualizar este usuário. Por favor, procure o administrador do sistema'
            );

        }finally{

            return redirect($retorno['rota'])->with($retorno['status'], $retorno['msg']);
        }
    }

    protected function remove_usuario(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if(@$request->id != 31)
            {   

                $dados_usuario = DB::table('usuarios')->where('id_usuario', $request->id)->first();

                Storage::disk('foto_usuario')->delete($dados_usuario->foto_perfil);

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

    protected function verifica_email_duplicado(Request $request,)
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
