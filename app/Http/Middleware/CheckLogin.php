<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Usuario;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->session()->has('user')){
            $user = Usuario::find(session('user')['id']);
            if($user->status != 'active'){
                return redirect()->route('login')->withErrors(['blocked' => 'blocked']);
            } 
            if($user->misc['email_verified'] == false){
                session('needVerify', $user->email);
                session()->forget('user');
                return redirect()->route('register.emailVerify');
            }

        }
        if ($request->session()->has('needEmailVerification')) {
            return redirect()->route('register.emailVerify');
        }

        return $next($request);
    }
}
