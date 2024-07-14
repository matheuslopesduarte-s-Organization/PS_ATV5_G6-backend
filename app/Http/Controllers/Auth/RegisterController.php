<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MeuEmail;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Carbon\Carbon;
use App\Utils\CreateUserPicture;
use App\Utils\VerificaCpf;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios,email',
            'cpf' => 'required|string|size:14|unique:usuarios,cpf',
            'password' => 'required|string|min:8',
            'username' => 'required|string|max:50|unique:usuarios,username',
            'birthdate' => 'required|date|before:today'
        ]);

        $birthdate = Carbon::parse($request->birthdate);
        $age = $birthdate->age;

        if($age < 18){
            session(['parentRegister' => $request->all()]);
            return redirect()->route('parentRegister');
        } 
        if(!preg_match('/^[a-zA-Z0-9_]*$/', $request->username)){
            return back()->withErrors(['username' => 'invalid characters in username']);
        }

        
        $usuario = new Usuario();

        $request->cpf = preg_replace('/[^0-9]/', '', $request->cpf);
        $cpfBase = substr($request->cpf, 0, 9);

        if($request->cpf != $cpfBase . VerificaCpf::calcularVerificador($cpfBase)){
            return back()->withErrors(['cpf' => 'invalid cpf']);
        }
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';

        for ($i = 0; $i < 7; $i++) {
            $codigo .= $caracteres[mt_rand(0, strlen($caracteres) - 1)];
        }

        $misc = [
            'email_verified' => false,
            'email_verification_tokens' => [ 
                [
                'token' => hash('sha256', $codigo),
                'expires_at' => Carbon::now()->addHours(24)->toDateTimeString()
                ]
            ],
            'status' => 'active',
            'images' => [
                'def' => CreateUserPicture::create($request->username)
            ]
        ];
        $usuario->id = uniqid();
        $usuario->misc = json_encode($misc);
        $usuario->nome = $request->name;
        $usuario->email = $request->email;
        $usuario->cpf = $request->cpf;
        $usuario->username = $request->username;
        $usuario->senha = hash('sha256', $request->password);
        $usuario->birthdate = $birthdate->toDateString();
        $usuario->save();

        $details = [
            'name' => $usuario->nome,
            'email' => $usuario->email,
            'token' => $codigo
        ];

        Mail::to($usuario->email)->send(new Email($details, 'Email Verification', 'emails.verification'));

        session(['needEmailVerification' => $usuario->email]);
        return redirect()->route('register.emailVerify');
    }

    public function emailVerify(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:7'
        ]);

        if(!session()->has('needEmailVerification')){
            return redirect()->route('login');
        }

        $usuario = Usuario::where('email', session('needEmailVerification'))->first();
        
        $userTokens = json_decode($usuario->misc, true)['email_verification_tokens'];

        for($i = 0; $i < count($userTokens); $i++){
            if($userTokens[$i]['token'] == hash('sha256', $request->token)){
                if(Carbon::parse($userTokens[$i]['expires_at'])->isPast()){
                    return back()->withErrors(['token' => 'expired token']);
                }
                $usuario->misc = json_encode(
                    array_merge(
                        json_decode($usuario->misc, true), 
                        ['email_verified' => true]
                    )
                );
                $usuario->save();
                session()->forget('needEmailVerification');
                return redirect()->route('login');
            }
        }
        return back()->withErrors(['token' => 'invalid token']);
    }

    public function showEmailVerify()
    {
        return view('verifyEmail');
    }
    
}