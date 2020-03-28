<?php

namespace App\Http\Controllers;


use Auth;
use App\Http\Controllers\Controller;
use App\Categorias;
use App\ContatosEmpresas;
use App\Empresas;
use DataTables;
use Request;

class SiteCtrl extends Controller
{

    static function getDDD($tel){ return "(".substr($tel,0,2).")"; }
    static function getTel($tel){ return substr($tel,2,-4)." - ".substr($tel,-4);  }


    public function listar(){
       $categorias = Categorias::all();
       foreach($categorias as $key => $cat){
           $categorias[$key]['quantidade'] = Empresas::where('categoria',$cat['id'])->count();
           $empresas = Empresas::where('categoria',$cat['id'])->get();
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

       return view('listar')->with('categorias',$categorias);
    }

}
