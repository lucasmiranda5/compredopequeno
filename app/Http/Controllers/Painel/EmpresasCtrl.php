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
use App\Usuario;
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
            $ob['ativo'] = Request::input('ativo'); 
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

            if(Request::input('usuario_usuario') != ''){
                if(Usuario::where('usuario',Request::input('usuario_usuario'))->count() > 0){
                    return redirect()->route('painel::empresas::editar',[$ob['id'],'resposta'=>'error_usuario']);
                }else{
                 
                    $user = new Usuario();
                    $user['nome'] = Request::input('usuario_nome');
                    $user['usuario'] = Request::input('usuario_usuario');
                    $user['password'] =  bcrypt(Request::input('usuario_password'));
                    $user['tipo'] = 'user';
                    $user['empresa'] = $ob['id'];
                    $user->save();
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
            $ob['ativo'] = Request::input('ativo'); 
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
           
            if(Request::input('usuario_usuario') != ''){
                if(Usuario::where('usuario',Request::input('usuario_usuario'))->where('empresa','<>',$id)->count() > 0){
                    return redirect()->route('painel::empresas::editar',[$id,'resposta'=>'error_usuario']);
                }else{
                    if(Usuario::where('empresa',$id)->count() > 0){
                        $user = Usuario::where('empresa',$id)->first();
                        if(Request::input('usuario_password') != '')
                            $user['password'] =  bcrypt(Request::input('usuario_password'));
                    }else{
                        $user = new Usuario();
                        $user['password'] =  bcrypt(Request::input('usuario_password'));
                    }

                    $user['nome'] = Request::input('usuario_nome');
                    $user['usuario'] = Request::input('usuario_usuario');                    
                    $user['tipo'] = 'user';
                    $user['empresa'] = $id;
                    $user->save();
                }
            }else{
                Usuario::where('empresa',$id)->delete();
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
      
        $ob['usuario'] = Usuario::where('empresa',$id)->first();
        
        return view('painel.empresas.formulario')->with('acao','Editar')->with('retorno',$ob)->with('cidades',Cidades::all())->with('categorias',Categorias::all())->with('contatos',$contatos);
    }

    public function excluir($id){
        ContatosEmpresas::where('empresa',$id)->delete();
        Produtos::where('empresa',$id)->delete();
        CidadesEmpresas::where('empresa',$id)->delete();
        Usuario::where('empresa',$id)->delete();
        
        Empresas::where('id',$id)->delete();

        return redirect()->route('painel::empresas::listar',['resposta'=>'sucesso_excluir']);
    }
}
