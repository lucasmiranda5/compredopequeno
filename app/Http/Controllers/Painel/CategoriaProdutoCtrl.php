<?php

namespace App\Http\Controllers\Painel;


use Auth;
use App\Http\Controllers\Controller;
use App\CategoriaProduto;
use DataTables;
use Request;

class CategoriaProdutoCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authPainel');
    }
    public function listar(){
        if(!empty(Request::input('columns'))){
            return DataTables::of(CategoriaProduto::query()->orderBy('id', 'desc'))
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('painel::categoriasProduto::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('painel::categoriasProduto::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('painel.categoriasProduto.listar');
    }

    public function cadastrar(){
        if(Request::input('_token')){
            $ob = new CategoriaProduto();
            $ob['nome'] = Request::input('nome'); 
            $ob->save();
            return redirect()->route('painel::categoriasProduto::listar',['resposta'=>'sucesso_cadastro']);
        }
        return view('painel.categoriasProduto.formulario')->with('acao','Cadastrar');
    }

    public function editar($id){
        $ob = CategoriaProduto::find($id);
        if(!$ob)
            return redirect()->route('painel::categoriasProduto::listar');

        if(Request::input('_token')){
            $ob['nome'] = Request::input('nome'); 
            $ob->save();
            return redirect()->route('painel::categoriasProduto::editar',[$id,'resposta'=>'sucesso_editar']);
        }
        return view('painel.categoriasProduto.formulario')->with('acao','Editar')->with('retorno',$ob);
    }
}
