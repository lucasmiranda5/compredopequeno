<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',['as' => 'listar','uses' => 'SiteCtrl@listar']);

Route::get('/emp/{id}',['as' => 'getEmpresa','uses' => 'SiteCtrl@empresa']);



Route::group(['as' => 'painel::','prefix' => "painel"], function () {
   Route::get('/',['as' => 'dashboard','uses' => 'Painel\DashboardCtrl@index']);
   Route::match(['get', 'post'], '/login',['as' => 'login', 'uses' => 'Painel\LoginCtrl@login']);
   #tipos de servicos
   Route::group(['as' => 'categorias::','prefix' => "categorias"], function () {
      Route::get('/',['as' => 'listar','uses' => 'Painel\CategoriasCtrl@listar']);
      Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'Painel\CategoriasCtrl@cadastrar']);
      Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Painel\CategoriasCtrl@editar']);
      Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'Painel\CategoriasCtrl@excluir']);
   });

   Route::group(['as' => 'categoriasProduto::','prefix' => "categoriasProduto"], function () {
      Route::get('/',['as' => 'listar','uses' => 'Painel\CategoriaProdutoCtrl@listar']);
      Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'Painel\CategoriaProdutoCtrl@cadastrar']);
      Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Painel\CategoriaProdutoCtrl@editar']);
      Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'Painel\CategoriaProdutoCtrl@excluir']);
   });

   Route::group(['as' => 'cidades::','prefix' => "cidades"], function () {
      Route::get('/',['as' => 'listar','uses' => 'Painel\CidadesCtrl@listar']);
      Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'Painel\CidadesCtrl@cadastrar']);
      Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Painel\CidadesCtrl@editar']);
      Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'Painel\CidadesCtrl@excluir']);
   });

   Route::group(['as' => 'empresas::','prefix' => "empresas"], function () {
      Route::get('/',['as' => 'listar','uses' => 'Painel\EmpresasCtrl@listar']);
      Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'Painel\EmpresasCtrl@cadastrar']);
      Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Painel\EmpresasCtrl@editar']);
      Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'Painel\EmpresasCtrl@excluir']);
   });

   Route::group(['as' => 'produtos::','prefix' => "produtos"], function () {
      Route::get('/{id}',['as' => 'listar','uses' => 'Painel\ProdutosCtrl@listar']);
      Route::match(array('GET', 'POST'),'/cadastrar/{id}', ['as' => 'cadastrar','uses' => 'Painel\ProdutosCtrl@cadastrar']);
      Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Painel\ProdutosCtrl@editar']);
      Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'Painel\ProdutosCtrl@excluir']);
   });
});
