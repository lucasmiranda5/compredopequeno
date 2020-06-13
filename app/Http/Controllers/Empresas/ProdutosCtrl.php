<?php

namespace App\Http\Controllers\Empresas;

use Request;
use App\Http\Controllers\Controller;
use App\Produtos;
use App\Empresas;
use App\CategoriaProduto;
use DataTables;
use Carbon\Carbon;
use Auth;

class ProdutosCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authEmpresa');
    }
    public function listar(){
        $id = Auth::user()->empresa;
        if(!empty(Request::input('columns'))){
            return DataTables::of(Produtos::query()->where('empresa',$id)->orderBy('id', 'desc'))
            ->editColumn('categoria',function($model){
                return CategoriaProduto::find($model->categoria)['nome'];
            })
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('empresas::produtos::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('empresas::produtos::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('empresas.produtos.listar');
    }

    public function cadastrar(){
        $id = Auth::user()->empresa;
        if(Request::input('_token')){
            $ob = new Produtos();
            $ob['nome'] = Request::input('nome'); 
            $ob['categoria'] = Request::input('categoria'); 
            $ob['descricao'] = Request::input('descricao'); 
            $ob['empresa'] = $id; 
            $arquivo = Request::file('foto');
            if(!empty($arquivo)){
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp. '-' .$arquivo->getClientOriginalName();
                $arquivo->move(base_path().'/uploads', $name);
                $foto = $name;
            }else{
                $marca = '';
            }
            $ob['foto'] = $foto;
            $ob->save();
            return redirect()->route('empresas::produtos::listar',[$id,'resposta'=>'sucesso_cadastro']);
        }
        return view('empresas.produtos.formulario')->with('acao','Cadastrar')->with('categorias',CategoriaProduto::all());
    }

    public function editar($id){
        $ob = Produtos::find($id);
        if(!$ob or $ob['empresa'] != Auth::user()->empresa)
            return redirect()->route('empresas::dashboard');

        if(Request::input('_token')){
            $ob['nome'] = Request::input('nome'); 
            $ob['categoria'] = Request::input('categoria'); 
            $ob['descricao'] = Request::input('descricao');            
            $arquivo = Request::file('foto');
            if(!empty($arquivo)){
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp. '-' .$arquivo->getClientOriginalName();
                $arquivo->move(base_path().'/uploads', $name);
                $ob['foto'] = $name;
            }
            $ob->save();

            return redirect()->route('empresas::produtos::editar',[$id,'resposta'=>'sucesso_editar']);
        }
        
        return view('empresas.produtos.formulario')->with('acao','Editar')->with('retorno',$ob)->with('categorias',CategoriaProduto::all());
    }

    public function excluir($id){
        Produtos::where('id',$id)->delete();
        return redirect()->route('empresas::produtos::listar',['resposta'=>'sucesso_excluir']);
    }
}
