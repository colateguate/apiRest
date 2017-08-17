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

/*
resourde hace referencia a un controlador de recurso
param1: ruta a chequear
param2: path al controlador
param3: condiciones
*/

//Buyers
Route::resource('buyers', 'buyer\buyerController', ['only' => ['index', 'show']]);

//Categories
//Capamos editar y crear categorias de ese controlador, lo haremos desde el user(permisos)
Route::resource('categoires', 'category\categoryController', ['except' => ['create', 'edit']]);

//Products
//Del controlador productController solo dejamos usar los metodos index y show
Route::resource('products', 'product\productController', ['only' => ['index', 'show']]);

//Transactions
Route::resource('transactions', 'transaction\transactionController', ['only' => ['index', 'show']]);

//Sellers
Route::resource('sellers', 'seller\sellerController', ['only' => ['index', 'show']]);

//Users
//Capamos las rutas de crear y editar usuarios, lo haremos desde el user
Route::resource('users', 'user\userController', ['except' => ['create', 'edit']]);
