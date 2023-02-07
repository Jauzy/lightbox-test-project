<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BE\LoginControllerAPI;

/* Role Management */
Route::POST('products/list', 'BE\ProductsAPI@list');
Route::POST('products/search', 'BE\ProductsAPI@search');
Route::GET('products/{id}', 'BE\ProductsAPI@getById');
Route::DELETE('products/{id}', 'BE\ProductsAPI@delF');
Route::POST('products', 'BE\ProductsAPI@saveF');
Route::POST('products/import', 'BE\ProductsAPI@import');
Route::GET('/products/{id}/export/pdf', 'BE\ProductsAPI@exportPDF');
Route::GET('/products/{id}/export/excel', 'BE\ProductsAPI@exportExcel');

Route::POST('projects/list', 'BE\ProjectsAPI@list');
Route::GET('projects/{id}', 'BE\ProjectsAPI@getById');
Route::DELETE('projects/{id}', 'BE\ProjectsAPI@delF');
Route::POST('projects', 'BE\ProjectsAPI@saveF');
Route::POST('projects/assign-product', 'BE\ProjectsAPI@assignProduct');
Route::DELETE('projects/product/{id}', 'BE\ProjectsAPI@delProductAssigned');
Route::GET('/projects/{id}/export/pdf', 'BE\ProjectsAPI@exportPDF');
Route::GET('/projects/{id}/export/excel', 'BE\ProjectsAPI@exportExcel');
