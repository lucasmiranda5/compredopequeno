<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Http\Controllers\Controller;
use App\Empresas;
use App\Produtos;
use App\Categorias;
use App\ContatosEmpresas;
use App\CategoriaProduto;
use App;
use Carbon\Carbon;
class EmpresasCtrl extends Controller
{
    public function listar(){
        $limit = Request::input('limit') ?? 2;
        $page = Request::input('page') ?? 1;
        $search = Request::input('search') ?? '';
        $categoria = Request::input('categoria') ?? '';

        $retorno = Empresas::where('ativo','s')->orderBy('nome','ASC');
        if($search != '')
            $retorno = $retorno->where('nome','like','%'.$search.'%');
        
        
        $arr = [];
        if($categoria != ''){
            $retorno = $retorno->where('categoria',$categoria);
            $arr['categoria'] = Categorias::find($categoria)['nome'];
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
                    if($item['marca'] != '')
                        $item['marca'] = App::make('url')->to('/').'/uploads/'.$item['marca'];
                    else
                        $item['marca'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
                    $item['categoria'] = Categorias::find($item['categoria'])['nome'];
                    return $item;
                });
        }
        return $arr;
    }


    public function get($id){
        $empresa = Empresas::find($id);
        $empresa['contatos'] = ContatosEmpresas::where('empresa',$id)->get();
        $empresa['produtos'] = Produtos::where('empresa',$id)->limit(5)->get()->transform(function($item){
            if($item['foto'] != '')
                $item['foto'] = App::make('url')->to('/').'/uploads/'.$item['foto'];
            else
                $item['foto'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
            $item['categoria'] = CategoriaProduto::find($item['categoria'])['nome'];
            return $item;
        });
        $empresa['categoria'] = Categorias::find($empresa['categoria'])['nome'];
        if($empresa['marca'] != '')
            $empresa['marca'] = App::make('url')->to('/').'/uploads/'.$empresa['marca'];
        else
            $empresa['marca'] = App::make('url')->to('/').'/uploads/semfoto.jpg';
        return $empresa;
    }

    public function cadastrar(){
        $ob = new Empresas();
        $ob['ativo'] = 'n';
        $ob['nome'] = Request::input('nome'); 
        $ob['categoria'] = Request::input('categoria'); 
        $ob['descricao'] = Request::input('descricao'); 
        $ob['horario_funcionamento'] = Request::input('horario_funcionamento'); 
        $ob['nome_responsavel'] = Request::input('nome_responsavel'); 
        $ob['telefone_responsavel'] = Request::input('telefone_responsavel'); 
        if(Request::input('image') != '' and Request::input('name_image') != ''){
            $realImage = base64_decode(Request::input('image'));              
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $name = $timestamp. '-' .Request::input('name_image');
            file_put_contents(base_path().'/uploads/'.$name,$realImage);
            $ob['marca'] = $name;
        }else
            $ob['marca'] = '';
        $ob->save();
        $contatos = json_decode(Request::input('contatos'),true);
        foreach($contatos as $contato){
            if($contato[1] != ''){
                $ob2 = new ContatosEmpresas();
                $ob2['tipo'] = $contato[0];
                $ob2['escrita'] = $contato[1];
                $ob2['direcionamento'] = $contato[1];
                $ob2['empresa'] = $ob['id'];
                $ob2->save();
            }
        }

        return ['retorno' => true];


    }
}
