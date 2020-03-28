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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/listar',['as' => 'listar','uses' => 'SiteCtrl@listar']);


 #tipos de servicos
 Route::group(['as' => 'categorias::','prefix' => "categorias"], function () {
    Route::get('/',['as' => 'listar','uses' => 'CategoriasCtrl@listar']);
    Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'CategoriasCtrl@cadastrar']);
    Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'CategoriasCtrl@editar']);
    Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'CategoriasCtrl@excluir']);
 });

 Route::group(['as' => 'cidades::','prefix' => "cidades"], function () {
    Route::get('/',['as' => 'listar','uses' => 'CidadesCtrl@listar']);
    Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'CidadesCtrl@cadastrar']);
    Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'CidadesCtrl@editar']);
    Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'CidadesCtrl@excluir']);
 });

 Route::group(['as' => 'empresas::','prefix' => "empresas"], function () {
    Route::get('/',['as' => 'listar','uses' => 'EmpresasCtrl@listar']);
    Route::match(array('GET', 'POST'),'/cadastrar', ['as' => 'cadastrar','uses' => 'EmpresasCtrl@cadastrar']);
    Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'EmpresasCtrl@editar']);
    Route::get('/excluir/{id}',['as' => 'excluir','uses' => 'EmpresasCtrl@excluir']);
 });