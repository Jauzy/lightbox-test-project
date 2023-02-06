<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BE\LoginControllerAPI;

/* Role Management */
Route::POST('products/list', 'BE\ProductsAPI@list');
Route::GET('products/{id}', 'BE\ProductsAPI@getById');
Route::DELETE('products/{id}', 'BE\ProductsAPI@delF');
Route::POST('products', 'BE\ProductsAPI@saveF');
Route::POST('products/import', 'BE\ProductsAPI@import');
