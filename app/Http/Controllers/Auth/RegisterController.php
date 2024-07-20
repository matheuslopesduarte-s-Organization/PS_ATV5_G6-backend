<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Carbon\Carbon;
use App\Utils\CreateUserPicture;
use App\Utils\VerificaCpf;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }
    public function store(Request $request)
    {
        /*
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios,email',
            'cpf' => 'required|string|size:14|unique:usuarios,cpf',
            'password' => 'required|string|min:8',
            'username' => 'required|string|max:50|unique:usuarios,username',
            'birthdate' => 'required|date|before:today'
        ]);
        */

        switch ($request->name) {
            case null:
                return back()->withInput()->withErrors(['name' => 'name is required']);
            case !is_string($request->name):
                return back()->withInput()->withErrors(['name' => 'name must be a string']);
            case strlen($request->name) > 100:
                return back()->withInput()->withErrors(['name' => 'name is too long']);
        }
        switch ($request->email) {
            case null:
                return back()->withInput()->withErrors(['email' => 'email is required']);
            case !is_string($request->email):
                return back()->withInput()->withErrors(['email' => 'email must be a string']);
            case strlen($request->email) > 100:
                return back()->withInput()->withErrors(['email' => 'email is too long']);
            case Usuario::where('email', $request->email)->exists():
                return back()->withInput()->withErrors(['email' => 'email already in use']);
        }

        switch ($request->password) {
            case null:
                return back()->withInput()->withErrors(['password' => 'password is required']);
            case !is_string($request->password):
                return back()->withInput()->withErrors(['password' => 'password must be a string']);
            case strlen($request->password) < 8:
                return back()->withInput()->withErrors(['password' => 'password is too short']);
        }

        $request->cpf = preg_replace('/[^0-9]/', '', $request->cpf);
        $cpfBase = substr($request->cpf, 0, 9);
        $verificador = substr($request->cpf, 9, 11);
        switch ($request->cpf) {
            case null:
                return back()->withInput()->withErrors(['cpf' => 'cpf is required']);
            case !is_string($request->cpf):
                return back()->withInput()->withErrors(['cpf' => 'cpf must be a string']);
            case strlen($request->cpf) != 11:
                return back()->withInput()->withErrors(['cpf' => 'invalid cpf']);
            case !($verificador == VerificaCpf::calcularVerificador($cpfBase)):
                return back()->withInput()->withErrors(['cpf' => 'invalid cpf']);
            case Usuario::where('cpf', $request->cpf)->exists():
                return back()->withInput()->withErrors(['cpf' => 'cpf already in use']);
        }

        switch ($request->username) {
            case null:
                return back()->withInput()->withErrors(['username' => 'username is required']);
            case !is_string($request->username):
                return back()->withInput()->withErrors(['username' => 'username must be a string']);
            case strlen($request->username) > 50:
                return back()->withInput()->withErrors(['username' => 'username is too long']);
            case !preg_match('/^[a-zA-Z0-9_]*$/', $request->username):
                return back()->withInput()->withErrors(['username' => 'invalid characters in username']);
            case Usuario::where('username', $request->username)->exists():
                return back()->withInput()->withErrors(['username' => 'username already in use']);
        }

        switch ($request->birthdate) {
            case null:
                return back()->withInput()->withErrors(['birthdate' => 'birthdate is required']);
            case Carbon::parse($request->birthdate)->year < 1900:
                return back()->withInput()->withErrors(['birthdate' => 'invalid date']);
            case Carbon::parse($request->birthdate)->isFuture():
                return back()->withInput()->withErrors(['birthdate' => 'invalid date']);
            case !Carbon::parse($request->birthdate):
                return back()->withInput()->withErrors(['birthdate' => 'invalid date']);
        }

        $birthdate = Carbon::parse($request->birthdate);
        $age = $birthdate->age;

        if ($age < 18) {
            session(['parentRegister' => $request->all()]);
            return redirect()->route('parentRegister');
        }

        $usuario = new Usuario();

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

    public function emailVerify_create()
    {
        return view('verifyEmail');
    }

    public function emailVerify_store(Request $request)
    {
        switch ($request->token) {
            case null:
                return back()->withInput()->withErrors(['token' => 'token is required']);
            case !is_string($request->token):
                return back()->withInput()->withErrors(['token' => 'token must be a string']);
            case strlen($request->token) != 7:
                return back()->withInput()->withErrors(['token' => 'invalid token']);
        }

        if (!session()->has('needEmailVerification')) {
            return redirect()->route('login');
        }

        $usuario = Usuario::where('email', session('needEmailVerification'))->first();

        $userTokens = json_decode($usuario->misc, true)['email_verification_tokens'];

        for ($i = 0; $i < count($userTokens); $i++) {
            if ($userTokens[$i]['token'] == hash('sha256', $request->token)) {
                if (Carbon::parse($userTokens[$i]['expires_at'])->isPast()) {
                    return back()->withInput()->withErrors(['token' => 'expired token']);
                }
                $usuario->misc = json_encode(
                    array_merge(
                        json_decode($usuario->misc, true),
                        [
                            'email_verified' => true,
                            'email_verification_tokens' => null
                        ]
                    )
                );
                $usuario->save();
                session()->forget('needEmailVerification');
                return redirect()->route('login');
            }
        }
        return back()->withInput()->withErrors(['token' => 'invalid token']);
    }
}
