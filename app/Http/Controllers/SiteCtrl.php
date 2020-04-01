<?php

namespace App\Http\Controllers;


use Auth;
use App\Http\Controllers\Controller;
use App\Categorias;
use App\ContatosEmpresas;
use App\CidadesEmpresas;
use App\Empresas;
use App\Cidades;
use DataTables;
use Request;

class SiteCtrl extends Controller
{

    static function getDDD($tel){ return "(".substr($tel,0,2).")"; }
    static function getTel($tel){ return substr($tel,2,-4)." - ".substr($tel,-4);  }


    public function empresa($id){

        $empresa = Empresas::find($id);
        $empresa['categoria'] = Categorias::find($empresa['id'])['nome'];

        $contatos = [];
        foreach(ContatosEmpresas::where('empresa',$empresa['id'])->get() as $contato){
            $a = [];
            $a['tipo'] = $contato['tipo'];
            if($contato['tipo'] == 'telefone'){     
                $telefone = str_replace(['(',')','-','_',' '],'',$contato['escrita']);                   
                $a['link'] = 'tel:'.$telefone;
                $a['escrita'] = self::getTel($telefone);
                $a['ddd'] = self::getDDD($telefone);

            }elseif($contato['tipo'] == 'whatsapp'){
                $telefone = str_replace(['(',')','-','_',' '],'',$contato['escrita']);
                $a['link'] = 'http://wa.me/55'.$telefone;
                $a['escrita'] = self::getTel($telefone);
                $a['ddd'] = self::getDDD($telefone);
            }else{
                $a['link'] = $contato['direcionamento'];
                $a['escrita'] = $contato['escrita'];
            }
            $contatos[] = $a;                   
        }

        $empresa['contatos'] = $contatos;
        $cids = [];
        foreach(CidadesEmpresas::where('empresa',$empresa['id'])->get() as $cidades){
            $a =[];
            $a['cidade'] = Cidades::find($cidades['cidade'])['cidade'];
            $a['entrega'] = $cidades['entrega'];
            $a['taxa_entrega'] = $cidades['taxa_entrega'];
            $cids[] = $a;
        }
        $empresa['cidades'] = $cids;


        return view('empresa')->with('empresa',$empresa);


    }

    public function listar($gerarPDF = false){
        if(Request::input('pesquisa') != ''){
            $p = Request::input('pesquisa') ;
            $categorias = Categorias::whereIn('id',Empresas::where('nome','like','%'.$p.'%')->orWhere('descricao','like','%'.$p.'%')->select('categoria')->get()->toArray())->orderBy('nome','ASC')->get();
        }elseif(Request::input('categoria') != ''){
            $categorias = Categorias::where('id',Request::input('categoria'))->get();
        }else{
            $categorias = Categorias::orderBy('nome','ASC')->get();
        }
           

        
       
       foreach($categorias as $key => $cat){
           $categorias[$key]['quantidade'] = Empresas::where('categoria',$cat['id'])->count();
           if(Request::input('pesquisa') != ''){
           $empresas = Empresas::where('nome','like','%'.$p.'%')->orWhere('descricao','like','%'.$p.'%')->where('categoria',$cat['id'])->get();
           }else{
            $empresas = Empresas::where('categoria',$cat['id'])->get();
           }
           foreach($empresas as $key2 => $emp){
               $contatos = [];
               foreach(ContatosEmpresas::where('empresa',$emp['id'])->get() as $contato){
                   $a = [];
                   $a['tipo'] = $contato['tipo'];
                   if($contato['tipo'] == 'telefone'){     
                        $telefone = str_replace(['(',')','-','_',' '],'',$contato['escrita']);                   
                        $a['link'] = 'tel:'.$telefone;
                        $a['escrita'] = self::getTel($telefone);
                        $a['ddd'] = self::getDDD($telefone);

                   }elseif($contato['tipo'] == 'whatsapp'){
                        $telefone = str_replace(['(',')','-','_',' '],'',$contato['escrita']);
                        $a['link'] = 'http://wa.me/55'.$telefone;
                        $a['escrita'] = self::getTel($telefone);
                        $a['ddd'] = self::getDDD($telefone);
                   }else{
                        $a['link'] = $contato['direcionamento'];
                        $a['escrita'] = $contato['escrita'];
                   }
                   $contatos[] = $a;                   
               }
               $empresas[$key2]['contatos'] = $contatos;
           }
           $categorias[$key]['empresas'] = $empresas;
       }

        return view('listar')->with('categorias',$categorias)->with('pesquisa',Request::input('pesquisa'));
    }

}
