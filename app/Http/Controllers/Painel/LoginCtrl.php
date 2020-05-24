<?php

namespace App\Http\Controllers\Painel;

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
                if(Auth::attempt(['usuario' => Request::input('usuario'), 'password' => Request::input('password'),'tipo' => 'admin'],$lembrar)){
                    return redirect()->route('painel::dashboard');
                }else{
                    return view('painel.login')->with('error',true);
                }
            }
        }
        return view('painel.login');
    }

    public function sair(){
        Auth::logout();
        return redirect()->route('painel::login');
    }
}
