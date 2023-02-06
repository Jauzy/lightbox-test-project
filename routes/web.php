<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['web']], function () {
    Route::GET('/', 'FE\LoginController@index');
    // Route::GET('login', 'FE\LoginController@login');

    Route::get('/products', 'FE\Products@index');
    Route::get('/products/{code}/form', 'FE\Products@form');

    // Route::get('/content/articles', 'FE\ArticlesController@index');

    // Route::get('/settings/languages', 'FE\Settings\LanguageController@index');
});


Route::GET('getimage/{file}', function ($file) {
    $f = urldecode(base64_decode($file));
    $headers = [
        'Content-Type'        => 'image/jpeg',
        'Content-Disposition' => 'attachment; filename="image"',
    ];

    return \Response::make(Storage::disk('local')->get($f), 200, $headers);
});
