<?php

use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Http\Controllers\Web\EcommerceController;
use Modules\Ecommerce\Http\Controllers\Web\ProductsController;

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

//global module prefix ecommerce applied at RouteServiceProvider

Route::get('/', EcommerceController::class)->name('index')->middleware('auth:web,adminWeb');

Route::group([
    'middleware' => 'auth:web,adminWeb',
    'prefix' => 'products',
    'as' => 'products.',
], function () {
    Route::get('create', [ProductsController::class, 'create'])->name('create');
    Route::post('/', [ProductsController::class, 'store'])->name('store');
});
