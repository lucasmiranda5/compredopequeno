<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Usuarios;

class AuthPainel
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()){
            if($request->ajax()){
                return response('Não Autorizado',401);
            }else{
                return redirect()->route('painel::login');
            }
        }
        if(Auth::user()->tipo != 'admin'){
            Auth::logout();
            return redirect()->route('painel::login');
        }

        return $next($request);
    }

   
}
