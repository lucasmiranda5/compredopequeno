<?php

namespace App\Http\Controllers\Empresas;


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

class EmpresasCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authEmpresa');
    }    

    public function editar(){
        $id = Auth::user()->empresa;
        $ob = Empresas::find($id);
        if(!$ob)
            return redirect()->route('empresas::login');

        if(Request::input('_token')){
            $ob['nome'] = Request::input('nome'); 
            $ob['categoria'] = Request::input('categoria'); 
            $ob['descricao'] = Request::input('descricao'); 
            $ob['horario_funcionamento'] = Request::input('horario_funcionamento'); 
            $ob['nome_responsavel'] = Request::input('nome_responsavel'); 
            $ob['telefone_responsavel'] = Request::input('telefone_responsavel'); 
            $arquivo = Request::file('marca');
            if(!empty($arquivo)){
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp. '-' .$arquivo->getClientOriginalName();
                $arquivo->move(base_path().'/uploads', $name);
                $ob['marca'] = $name;
            }
            $ob->save();
            ContatosEmpresas::where('empresa',$id)->delete();
            $direcionamento =  Request::input('direcionamento'); 
            $link =  Request::input('link'); 
            $tipo =  Request::input('tipo'); 
            for($x = 1; $x <= 3; $x++){
                if($direcionamento[$x] != ''){
                    $ob2 = new ContatosEmpresas();
                    $ob2['tipo'] = $tipo[$x];
                    $ob2['escrita'] = $direcionamento[$x];
                    $ob2['direcionamento'] = $link[$x];
                    $ob2['empresa'] = $ob['id'];
                    $ob2->save();
                }
            } 
            return redirect()->route('empresas::dashboard',['resposta'=>'sucesso_editar']);
        }

        $contatos = [];
        $x = 1;
        foreach(ContatosEmpresas::where('empresa',$id)->get() as $cont){
            $a = [];
            $a['tipo'] = $cont['tipo'];
            $a['direcionamento'] = $cont['escrita'];
            $a['link'] = $cont['direcionamento'];
            $contatos[$x] = $a;
            $x++;
        }
        
        
        return view('empresas.empresa')->with('acao','Editar')->with('retorno',$ob)->with('categorias',Categorias::all())->with('contatos',$contatos);
    }

}
