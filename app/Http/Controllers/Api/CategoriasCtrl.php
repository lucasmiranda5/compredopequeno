<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Http\Controllers\Controller;
use App\Categorias;
use App\Empresas;

class CategoriasCtrl extends Controller
{
    public function listar(){
        $limit = Request::input('limit') ?? 2;
        $page = Request::input('page') ?? 1;
        $search = Request::input('search') ?? '';

        $retorno = Categorias::orderBy('nome','ASC');
        if($search != '')
            $retorno = $retorno->where('nome','like','%'.$search.'%');
        
        $arr = [];
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
                    $item['empresas'] = Empresas::where('categoria',$item['id'])->count();
                    return $item;
                });
        }
        return $arr;
    }

    public function get(){
        return Categorias::all();
    }
}
