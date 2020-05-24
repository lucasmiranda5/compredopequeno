<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Http\Controllers\Controller;
use App\Produtos;
use App\Empresas;
use App\CategoriaProduto;
use App;
class ProdutosCtrl extends Controller
{
    public function listar(){
        $limit = Request::input('limit') ?? 2;
        $page = Request::input('page') ?? 1;
        $search = Request::input('search') ?? '';
        $empresa = Request::input('empresa') ?? '';

        $retorno = Produtos::orderBy('nome','ASC');
        if($search != '')
            $retorno = $retorno->where('nome','like','%'.$search.'%');
        
        
        $arr = [];
        if($empresa != ''){
            $retorno = $retorno->where('empresa',$empresa);
            $arr['empresa'] = Empresas::find($empresa)['nome'];
        }
        $arr['quantidade'] = $retorno->count();
       
        if($limit == 0)
            $arr['dados'] = $retorno->get();
        else{
            $quantidade = $retorno->count() / $limit;
            if($quantidade - (int)$quantidade  > 0)
                $quantidade = (int)$quantidade + 1; 
    
            $arr['paginas'] = $quantidade;
            $arr['dados'] = $retorno->limit($limit)->offset(($page-1)*$limit)->get()->transform(
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

    public function get($id){
        $produto = Produtos::find($id);       
        $produto['categoria'] = CategoriaProduto::find($produto['categoria'])['nome'];
        $produto['id_empresa'] = $produto['empresa'];
        $produto['empresa'] = Empresas::find($produto['empresa'])['nome'];
        if($produto['foto'] != '')
            $produto['foto'] = App::make('url')->to('/').'/uploads/'.$produto['foto'];
        else
            $produto['foto'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
        return $produto;
    }
}
