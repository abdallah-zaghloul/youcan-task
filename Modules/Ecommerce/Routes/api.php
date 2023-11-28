<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Http\Controllers\Api\ProductsController;

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

//global module prefix api/ecommerce applied at RouteServiceProvider

Route::get('products', [ProductsController::class, 'index'])->name('products.index');
Route::post('products', [ProductsController::class, 'create'])->name('products.create');
