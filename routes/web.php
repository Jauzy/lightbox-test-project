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

    Route::get('/projects', 'FE\ProjectsController@index');
    Route::get('/projects/new', 'FE\ProjectsController@new');
    Route::get('/projects/{id}/form/{stage?}', 'FE\ProjectsController@form');

    Route::get('/tender/submission-form/success', 'FE\TenderForm@success');
    Route::get('/tender/submission-form/{id}', 'FE\TenderForm@index');
    Route::get('/tender/comparison/{id}', 'FE\TenderComparison@index');
    Route::get('/tender/comparison-simple/{id}', 'FE\TenderComparison@simple');

    Route::prefix('masterdata')->group(function () {
        Route::get('/categories', 'FE\Masterdata\CategoriesController@index');
        Route::get('/brands', 'FE\Masterdata\BrandsController@index');
        Route::get('/lumtypes', 'FE\Masterdata\LumtypesController@index');
        Route::get('/company', 'FE\Masterdata\CompanyController@index');

        Route::prefix('products')->group(function () {
            Route::get('/', 'FE\Products@index');
            Route::get('/new', 'FE\Products@new');
            Route::get('/{id}/form', 'FE\Products@form');
        });
    });
});


Route::GET('getimage/{file}', function ($file) {
    $f = urldecode(base64_decode($file));
    $headers = [
        'Content-Type'        => 'image/jpeg',
        'Content-Disposition' => 'attachment; filename="image"',
    ];

    return \Response::make(Storage::disk('local')->get($f), 200, $headers);
});


