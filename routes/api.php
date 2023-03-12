<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BE\LoginControllerAPI;

Route::prefix('projects')->group(function () {
    Route::POST('/stage/toggle-tender', 'BE\ProjectsAPI@toggleTender');
    Route::POST('/stage/product', 'BE\ProjectsAPI@assignProduct');
    Route::POST('/stage', 'BE\ProjectsAPI@saveStage');
    Route::POST('/list', 'BE\ProjectsAPI@list');

    Route::prefix('product-offered')->group(function () {
        Route::DELETE('/{id}', 'BE\ProjectsAPI@delFProdukOffered');
        Route::POST('/', 'BE\ProjectsAPI@saveFProdukOffered');
    });

    Route::GET('/{id}', 'BE\ProjectsAPI@getById');
    Route::DELETE('/{id}', 'BE\ProjectsAPI@delF');
    Route::POST('/', 'BE\ProjectsAPI@saveF');
    Route::GET('/{id}/export/pdf/{ps_id}', 'BE\ProjectsAPI@exportPDF');
    Route::GET('/{id}/export/excel/{ps_id}', 'BE\ProjectsAPI@exportExcel');
});

Route::prefix('tender')->group(function () {
    Route::POST('/form', 'BE\TenderForm@saveF');
    Route::GET('/comparison/pdf/{id}', 'BE\TenderComparison@printPDF');
    Route::GET('/comparison-simple/pdf/{id}', 'BE\TenderComparison@printPDFSimple');
    Route::GET('/comparison/excel/{id}', 'BE\TenderComparison@exportExcel');

});

Route::prefix('masterdata')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::POST('/dt', 'BE\Masterdata\CategoriesControllerAPI@dt');
        Route::GET('/{id}', 'BE\Masterdata\CategoriesControllerAPI@getById');
        Route::POST('/', 'BE\Masterdata\CategoriesControllerAPI@save');
        Route::DELETE('/{id}', 'BE\Masterdata\CategoriesControllerAPI@delete');
    });
    Route::prefix('brands')->group(function () {
        Route::POST('/dt', 'BE\Masterdata\BrandsControllerAPI@dt');
        Route::GET('/{id}', 'BE\Masterdata\BrandsControllerAPI@getById');
        Route::POST('/', 'BE\Masterdata\BrandsControllerAPI@save');
        Route::DELETE('/{id}', 'BE\Masterdata\BrandsControllerAPI@delete');
    });
    Route::prefix('lumtypes')->group(function () {
        Route::POST('/dt', 'BE\Masterdata\LumtypesControllerAPI@dt');
        Route::GET('/{id}', 'BE\Masterdata\LumtypesControllerAPI@getById');
        Route::POST('/', 'BE\Masterdata\LumtypesControllerAPI@save');
        Route::DELETE('/{id}', 'BE\Masterdata\LumtypesControllerAPI@delete');
    });
    Route::prefix('company')->group(function () {
        Route::POST('/dt', 'BE\Masterdata\CompanyControllerAPI@dt');
        Route::GET('/{id}', 'BE\Masterdata\CompanyControllerAPI@getById');
        Route::POST('/', 'BE\Masterdata\CompanyControllerAPI@save');
        Route::DELETE('/{id}', 'BE\Masterdata\CompanyControllerAPI@delete');
    });
    Route::prefix('products')->group(function () {
        Route::POST('/list', 'BE\ProductsAPI@list');
        Route::POST('/search', 'BE\ProductsAPI@search');
        Route::GET('/{id}', 'BE\ProductsAPI@getById');
        Route::DELETE('/{id}', 'BE\ProductsAPI@delF');
        Route::POST('/', 'BE\ProductsAPI@saveF');
        Route::POST('/import', 'BE\ProductsAPI@import');
        Route::GET('/{id}/export/pdf', 'BE\ProductsAPI@exportPDF');
        Route::GET('/{id}/export/excel', 'BE\ProductsAPI@exportExcel');
    });
});

