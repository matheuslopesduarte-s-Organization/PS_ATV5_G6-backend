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
            if(json_decode($user->misc, true)['status'] != 'active'){
                return redirect()->route('login')->withErrors(['blocked' => 'blocked']);
            } 
            if(json_decode($user->misc, true)['email_verified'] == false){
                session('needVerify', $user->email);
                session()->forget('user');
                return redirect()->route('users.register.emailVerify');
            }
            
            $userPictures = json_decode($user->misc, true)['images'];
            $max = 0;
            foreach($userPictures as $key => $value){
                if($key != 'def'){
                    $key = intval($key);
                    if($key > $max){
                        $max = $key;
                    }
                }
            }
            if($max == 0){
                session('user')['image'] = $userPictures['def'];
            } else {
                session('user')['image'] = $userPictures[$max];
            }
            

        }
        if ($request->session()->has('needEmailVerification')) {
            return redirect()->route('users.register.emailVerify');
        }

        return $next($request);
    }
}
