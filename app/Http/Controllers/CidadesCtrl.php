<?php

namespace App\Http\Controllers;


use Auth;
use App\Http\Controllers\Controller;
use App\Cidades;
use DataTables;
use Request;

class CidadesCtrl extends Controller
{
    public function listar(){
        if(!empty(Request::input('columns'))){
            return DataTables::of(Cidades::query()->orderBy('id', 'desc'))
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('cidades::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('cidades::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('cidades.listar');
    }

    public function cadastrar(){
        if(Request::input('_token')){
            $ob = new Cidades();
            $ob['cidade'] = Request::input('cidade'); 
            $ob->save();
            return redirect()->route('cidades::listar',['resposta'=>'sucesso_cadastro']);
        }
        return view('cidades.formulario')->with('acao','Cadastrar');
    }

    public function editar($id){
        $ob = Cidades::find($id);
        if(!$ob)
            return redirect()->route('cidades::listar');

        if(Request::input('_token')){
            $ob['cidade'] = Request::input('cidade'); 
            $ob->save();
            return redirect()->route('cidades::editar',[$id,'resposta'=>'sucesso_editar']);
        }
        return view('cidades.formulario')->with('acao','Editar')->with('retorno',$ob);
    }
}
