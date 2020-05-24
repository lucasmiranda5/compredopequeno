<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Empresas;
use App\Categorias;
use App\Produtos;

class DashboardCtrl extends Controller
{
    public function __construct(){
        $this->middleware('authPainel');
    }
    public function index(){
        $retorno = [];
        $retorno['empresas'] = Empresas::count();
        $retorno['categorias'] = Categorias::count();
        $retorno['produtos'] = Produtos::count();
        return view('painel.dashboard')->with('retorno',$retorno);
    }
}
