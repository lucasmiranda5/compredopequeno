<?php

namespace App\Http\Controllers\Painel;


use Auth;
use App\Http\Controllers\Controller;
use App\Cidades;
use DataTables;
use Request;

class CidadesCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authPainel');
    }
    public function listar(){
        if(!empty(Request::input('columns'))){
            return DataTables::of(Cidades::query()->orderBy('id', 'desc'))
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('painel::cidades::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('painel::cidades::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('painel.cidades.listar');
    }

    public function cadastrar(){
        if(Request::input('_token')){
            $ob = new Cidades();
            $ob['cidade'] = Request::input('cidade'); 
            $ob->save();
            return redirect()->route('painel::cidades::listar',['resposta'=>'sucesso_cadastro']);
        }
        return view('painel.cidades.formulario')->with('acao','Cadastrar');
    }

    public function editar($id){
        $ob = Cidades::find($id);
        if(!$ob)
            return redirect()->route('painel::cidades::listar');

        if(Request::input('_token')){
            $ob['cidade'] = Request::input('cidade'); 
            $ob->save();
            return redirect()->route('painel::cidades::editar',[$id,'resposta'=>'sucesso_editar']);
        }
        return view('painel.cidades.formulario')->with('acao','Editar')->with('retorno',$ob);
    }
}
