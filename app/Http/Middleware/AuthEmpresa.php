<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Usuarios;

class AuthEmpresa
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
                return redirect()->route('empresas::login');
            }
        }
        if(Auth::user()->tipo != 'user' or Auth::user()->empresa == 0 or Auth::user()->empresa == ''){
            Auth::logout();
            return redirect()->route('empresas::login');
        }

        return $next($request);
    }

   
}
