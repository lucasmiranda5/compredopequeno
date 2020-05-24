<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Http\Controllers\Controller;
use App\Categorias;
use App\Empresas;
use App\Produtos;
use App;

class DashboardCtrl extends Controller
{
    public function index(){
        $retorno = [];
        $retorno['categorias'] = Categorias::inRandomOrder()->limit(5)->get()->transform(function($item){
            $item['quantidadeEmpresas'] = Empresas::where('categoria',$item['id'])->count();
            return $item;
        });
        $retorno['ultimosProdutos'] = Produtos::orderBy('id','DESC')->limit(6)->get()->transform(function($item){
            $item['nomeEmpresa'] = Empresas::find($item['empresa'])['nome'];
            if($item['foto'] != '')
                $item['foto'] = App::make('url')->to('/').'/uploads/'.$item['foto'];
            else
                $item['foto'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
            return $item;
        });
        $retorno['ultimasEmpresas'] = Empresas::orderBy('id','DESC')->limit(6)->get()->transform(function($item){
            $item['nomeCategoria'] = Categorias::find($item['categoria'])['nome'];
            if($item['marca'] != '')
                $item['marca'] = App::make('url')->to('/').'/uploads/'.$item['marca'];
            else
                $item['marca'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
            return $item;
        });
        return $retorno;
    }

    public function pesquisar(){
        $search = Request::input('search') ?? '';

        $limit_empresa = Request::input('limit_empresa') ?? 2;
        $page_empresa = Request::input('page_empresa') ?? 1; 
        $retorno_empresa = Empresas::orderBy('nome','ASC');
        if($search != '')
            $retorno_empresa = $retorno_empresa->where('nome','like','%'.$search.'%')->orWhere('descricao','like','%'.$search.'%');
        
        
        $arr = [];       
        $arr['quantidade_empresa'] = $retorno_empresa->count();
       
        if($limit_empresa == 0)
            $arr['dados_empresa'] = $retorno_empresa->get();
        else{
            $quantidade = $retorno_empresa->count() / $limit_empresa;
            if($quantidade - (int)$quantidade  > 0)
                $quantidade = (int)$quantidade + 1; 
    
            $arr['paginas_empresa'] = $quantidade;
            $arr['dados_empresa'] = $retorno_empresa->limit($limit_empresa)->offset(($page_empresa-1)*$limit_empresa)->get()->transform(
                function($item){
                    if($item['marca'] != '')
                        $item['marca'] = App::make('url')->to('/').'/uploads/'.$item['marca'];
                    else
                        $item['marca'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
                    $item['categoria'] = Categorias::find($item['categoria'])['nome'];
                    return $item;
                });
        }

        // Produto

        $limit_produto = Request::input('limit_produto') ?? 2;
        $page_produto = Request::input('page_produto') ?? 1; 
        $retorno_produto = Produtos::orderBy('nome','ASC');
        if($search != '')
            $retorno_produto = $retorno_produto->where('nome','like','%'.$search.'%')->orWhere('descricao','like','%'.$search.'%');
        
        
        $arr['quantidade_produto'] = $retorno_produto->count();
       
        if($limit_produto == 0)
            $arr['dados_produto'] = $retorno_produto->get();
        else{
            $quantidade = $retorno_produto->count() / $limit_produto;
            if($quantidade - (int)$quantidade  > 0)
                $quantidade = (int)$quantidade + 1; 
    
            $arr['paginas_produto'] = $quantidade;
            $arr['dados_produto'] = $retorno_produto->limit($limit_produto)->offset(($page_produto-1)*$limit_produto)->get()->transform(
                function($item){
                    if($item['foto'] != '')
                        $item['foto'] = App::make('url')->to('/').'/uploads/'.$item['foto'];
                    else
                        $item['foto'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
                    $item['empresa'] = Empresas::find($item['empresa'])['nome'];
                    return $item;
                });
        }
        return $arr;
    }
}
