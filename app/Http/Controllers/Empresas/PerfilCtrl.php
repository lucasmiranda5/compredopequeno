<?php

namespace App\Http\Controllers\Empresas;

use Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use Auth;

class PerfilCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authEmpresa');
    }
   

    public function editar(){
        $ob = Usuario::find(Auth::user()->id);
        if(Request::input('_token')){
            if(Usuario::where('usuario',Request::input('usuario'))->where('id','<>',Auth::user()->id)->count() > 0)
                return redirect()->route('empresas::perfil',['resposta'=>'error_usuario']);
            
            $ob['nome'] = Request::input('nome'); 
            $ob['usuario'] = Request::input('usuario'); 
            if(Request::input('password') != '')
                $ob['password'] = bcrypt(Request::input('password'));
            $ob->save();
            return redirect()->route('empresas::perfil',['resposta'=>'sucesso_editar']);
        }        
        return view('empresas.perfil')->with('acao','Editar')->with('retorno',$ob);
    }
    }
