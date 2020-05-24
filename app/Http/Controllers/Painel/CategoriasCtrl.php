<?php

namespace App\Http\Controllers\Painel;


use Auth;
use App\Http\Controllers\Controller;
use App\Categorias;
use DataTables;
use Request;

class CategoriasCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authPainel');
    }
    public function listar(){
        if(!empty(Request::input('columns'))){
            return DataTables::of(Categorias::query()->orderBy('id', 'desc'))
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('painel::categorias::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('painel::categorias::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('painel.categorias.listar');
    }

    public function cadastrar(){
        if(Request::input('_token')){
            $ob = new Categorias();
            $ob['nome'] = Request::input('nome'); 
            $ob->save();
            return redirect()->route('painel::categorias::listar',['resposta'=>'sucesso_cadastro']);
        }
        return view('painel.categorias.formulario')->with('acao','Cadastrar');
    }

    public function editar($id){
        $ob = Categorias::find($id);
        if(!$ob)
            return redirect()->route('painel::categorias::listar');

        if(Request::input('_token')){
            $ob['nome'] = Request::input('nome'); 
            $ob->save();
            return redirect()->route('painel::categorias::editar',[$id,'resposta'=>'sucesso_editar']);
        }
        return view('painel.categorias.formulario')->with('acao','Editar')->with('retorno',$ob);
    }
}
