<?php

namespace App\Http\Controllers\Painel;


use Auth;
use App\Http\Controllers\Controller;
use App\Cidades;
use App\Categorias;
use App\CidadesEmpresas;
use App\ContatosEmpresas;
use App\Empresas;
use App\Produtos;
use App\Usuario;
use DataTables;
use Carbon\Carbon;
use Request;

class UsuariosCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authPainel');
    }
    public function listar(){
        if(!empty(Request::input('columns'))){
            return DataTables::of(Usuario::query()->where('tipo','admin')->orderBy('id', 'desc'))
            ->editColumn('categoria',function($model){
                return Categorias::find($model->categoria)['nome'];
            })
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('painel::usuarios::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('painel::usuarios::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('painel.usuarios.listar');
    }

    public function cadastrar(){
        if(Request::input('_token')){
            $ob = new Usuario();            
            if(Usuario::where('usuario',Request::input('usuario'))->count() > 0){
                return redirect()->route('painel::usuarios::cadastrar',['resposta'=>'error_usuario']);
            }else{                
                $user = new Usuario();
                $user['nome'] = Request::input('nome');
                $user['usuario'] = Request::input('usuario');
                $user['password'] =  bcrypt(Request::input('password'));
                $user['tipo'] = 'admin';
                $user['empresa'] = 0;
                $user->save();
            }
            
            
            return redirect()->route('painel::usuarios::listar',['resposta'=>'sucesso_cadastro']);
        }
        return view('painel.usuarios.formulario')->with('acao','Cadastrar');
    }

    public function editar($id){
        $ob = Usuario::find($id);
        
        if(Request::input('_token')){
            if(Usuario::where('usuario',Request::input('usuario'))->where('id','<>',$id)->count() > 0){
                return redirect()->route('painel::usuarios::cadastrar',['resposta'=>'error_usuario']);
            }else{                
                $ob['nome'] = Request::input('nome');
                $ob['usuario'] = Request::input('usuario');
                if(Request::input('password') != '')
                    $ob['password'] =  bcrypt(Request::input('password'));               
                $ob->save();
            }


            return redirect()->route('painel::usuarios::editar',[$id,'resposta'=>'sucesso_editar']);
        }

      
        
        return view('painel.usuarios.formulario')->with('acao','Editar')->with('retorno',$ob);
    }

    public function excluir($id){
        Usuario::where('id',$id)->delete();        

        return redirect()->route('painel::usuarios::listar',['resposta'=>'sucesso_excluir']);
    }
}
