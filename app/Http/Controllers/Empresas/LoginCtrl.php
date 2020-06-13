<?php

namespace App\Http\Controllers\Empresas;

use Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use Auth;

class LoginCtrl extends Controller
{
    
    public function login(){

        if(Request::input('_token')){
            if(Request::input('usuario') != '' and Request::input('password') != ''){
                $lembrar = (Request::input('lembreme') ? true : false);
                if(Auth::attempt(['usuario' => Request::input('usuario'), 'password' => Request::input('password'),'tipo' => 'user'],$lembrar)){
                    return redirect()->route('empresas::dashboard');
                }else{
                    return view('empresas.login')->with('error',true);
                }
            }
        }
        return view('empresas.login');
    }

    public function sair(){
        Auth::logout();
        return redirect()->route('empresas::login');
    }
}
