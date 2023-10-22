<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function index()
    {
        return view('login.index');
    }  
      
    public function login(Request $request)
    {   

        $request->validate([
            'email' => 'required',
            'senha' => 'required',
        ]);
   
        $credentials = $request->only('email', 'senha');

        $user = Usuario::where('email', $request->email)->first();

        if ($user && Hash::check($request->senha, $user->senha))
        {
            Auth::login($user);
            return redirect('/inicio');
        } else {
            // Senha não corresponde
            return redirect('/')->with('error', 'E-mail e/ou senha inválido(s)!');
        }

    }
    
    public function logout()
    {
        Session::flush();
        Auth::logout();
  
        return redirect('/');
    }
}