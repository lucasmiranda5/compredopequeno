<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/dashboard',['as' => 'api::dasboard','uses' => 'Api\DashboardCtrl@index']);
Route::get('/pesquisa',['as' => 'api::dasboard','uses' => 'Api\DashboardCtrl@pesquisar']);
   //Grade
Route::group(['as'=>'categorias::','prefix' => 'categorias'], function () {
    Route::get('/',['as'=>'listar' , 'uses'=> 'Api\CategoriasCtrl@listar' ]);
    Route::get('/{id}',['as'=>'get' , 'uses'=> 'Api\CategoriasCtrl@get' ]); 
});

Route::group(['as'=>'empresas::','prefix' => 'empresas'], function () {
    Route::get('/',['as'=>'listar' , 'uses'=> 'Api\EmpresasCtrl@listar' ]);
    Route::get('/{id}',['as'=>'get' , 'uses'=> 'Api\EmpresasCtrl@get' ]); 
});

Route::group(['as'=>'produtos::','prefix' => 'produtos'], function () {
    Route::get('/',['as'=>'listar' , 'uses'=> 'Api\ProdutosCtrl@listar' ]);
    Route::get('/{id}',['as'=>'get' , 'uses'=> 'Api\ProdutosCtrl@get' ]); 
});