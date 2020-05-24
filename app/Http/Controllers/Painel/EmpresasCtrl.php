<?php

namespace App\Http\Controllers\Painel;


use Auth;
use App\Http\Controllers\Controller;
use App\Cidades;
use App\Categorias;
use App\CidadesEmpresas;
use App\ContatosEmpresas;
use App\Empresas;
use App\Produtos;
use DataTables;
use Carbon\Carbon;
use Request;

class EmpresasCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authPainel');
    }
    public function listar(){
        if(!empty(Request::input('columns'))){
            return DataTables::of(Empresas::query()->orderBy('id', 'desc'))
            ->editColumn('categoria',function($model){
                return Categorias::find($model->categoria)['nome'];
            })
            ->editColumn('acoes',function($model){
                return'
                 <div class="tools">                           
                <a href="'.route('painel::empresas::editar', $model->id).'"> <i class="fa fa-edit"></i></a>                  
                <a href="'.route('painel::empresas::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>                  
                <a href="'.route('painel::produtos::listar', $model->id).'"> <i class="fa fa-boxes"></i></a>                  
                </div>';
            })->escapeColumns('acoes')->make(true);
        }else
    	return view('painel.empresas.listar');
    }

    public function cadastrar(){
        if(Request::input('_token')){
            $ob = new Empresas();
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
                $marca = $name;
            }else{
                $marca = '';
            }
            $ob['marca'] = $marca;
            $ob->save();
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

            $atende = Request::input('atende');
            $entrega = Request::input('entrega');
            $tx = Request::input('tx');
            foreach(Cidades::all() as $cidade){
                if(!empty($atende[$cidade['id']]) and $atende[$cidade['id']] == 'S'){
                    $ob3 = new CidadesEmpresas();
                    $ob3['empresa'] = $ob['id'];
                    $ob3['cidade'] = $cidade['id'];
                    if(!empty($entrega[$cidade['id']]) and $entrega[$cidade['id']] == 'S')
                        $ob3['entrega'] = 'S';
                    else
                        $ob3['entrega'] = 'N';
                    $ob3['taxa_entrega'] = $tx[$cidade['id']];
                    $ob3->save();
                }
            }
            return redirect()->route('painel::empresas::listar',['resposta'=>'sucesso_cadastro']);
        }
        return view('painel.empresas.formulario')->with('acao','Cadastrar')->with('cidades',Cidades::all())->with('categorias',Categorias::all());
    }

    public function editar($id){
        $ob = Empresas::find($id);
        if(!$ob)
            return redirect()->route('painel::empresas::listar');

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
            CidadesEmpresas::where('empresa',$id)->delete();
            $atende = Request::input('atende');
            $entrega = Request::input('entrega');
            $tx = Request::input('tx');
            foreach(Cidades::all() as $cidade){
                if(!empty($atende[$cidade['id']]) and $atende[$cidade['id']] == 'S'){
                    $ob3 = new CidadesEmpresas();
                    $ob3['empresa'] = $ob['id'];
                    $ob3['cidade'] = $cidade['id'];
                    if(!empty($entrega[$cidade['id']]) and $entrega[$cidade['id']] == 'S')
                        $ob3['entrega'] = 'S';
                    else
                        $ob3['entrega'] = 'N';
                    $ob3['taxa_entrega'] = $tx[$cidade['id']];
                    $ob3->save();
                }
            }

            return redirect()->route('painel::empresas::editar',[$id,'resposta'=>'sucesso_editar']);
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
        $cidEmpresa = [];
        foreach(Cidades::all() as $c){
            $a = [];
            if(CidadesEmpresas::where('cidade',$c['id'])->where('empresa',$id)->count() > 0){
                $b = CidadesEmpresas::where('cidade',$c['id'])->where('empresa',$id)->first();                
                $a['atende'] = 'S';
                $a['entrega'] = strtoupper($b['entrega']);
                $a['tx'] = $b['taxa_entrega'];                
            }else{
                $a['atende'] = 'N';
                $a['entrega'] = 'N';
                $a['tx'] = '';
            }
            $cidEmpresa[$c['id']] = $a;
        }
        
        return view('painel.empresas.formulario')->with('acao','Editar')->with('retorno',$ob)->with('cidades',Cidades::all())->with('categorias',Categorias::all())->with('contatos',$contatos)->with('cidEmpresa',$cidEmpresa);
    }

    public function excluir($id){
        ContatosEmpresas::where('empresa',$id)->delete();
        Produtos::where('empresa',$id)->delete();
        CidadesEmpresas::where('empresa',$id)->delete();
        Empresas::where('id',$id)->delete();
        return redirect()->route('painel::empresas::listar',['resposta'=>'sucesso_excluir']);
    }
}
