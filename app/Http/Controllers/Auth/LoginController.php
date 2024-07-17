<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');

    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->identifier)
                            ->orWhere('username', $request->identifier)
                            ->first();

        if($usuario && hash('sha256', $request->password) == $usuario->senha){
            $misc = json_decode($usuario->misc, true);
            if($misc['status'] != 'active'){
                return back()->withErrors(['identifier' => 'Usuário bloqueado']);
            }

            if($misc['email_verified'] == false){
                return redirect()->route('register.emailVerify');
            }

            $usuarioInfo = [
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'email' => $usuario->email,
                'username' => $usuario->username,
                'image' => $misc['images']['def'],
                'birthday' => $usuario->nascimento
            ];
            if(isset($misc['specialRole'])){
                $usuarioInfo['specialRole'] = $misc['specialRole'];
            }

            session(['user' => $usuarioInfo]);
            return redirect()->route('home');
        } else {
            return back()->withErrors(['identifier' => 'Usuário ou senha inválidos']);
        }

    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('home');
    }
}