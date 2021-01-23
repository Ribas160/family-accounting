<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/categories/create', [\App\Http\Controllers\AppController::class, 'createCategory']);
Route::post('/categories/get', [\App\Http\Controllers\AppController::class, 'getCategories']);
Route::post('/categories/delete', [\App\Http\Controllers\AppController::class, 'deleteCategory']);
Route::post('/products/create', [\App\Http\Controllers\AppController::class, 'createProduct']);
Route::post('/products/get', [\App\Http\Controllers\AppController::class, 'getProducts']);
Route::post('/products/delete', [\App\Http\Controllers\AppController::class, 'deleteProduct']);
Route::post('/history/get', [\App\Http\Controllers\AppController::class, 'getHistory']);
Route::post('/doughnut', [\App\Http\Controllers\AppController::class, 'doughnut']);
Route::post('/scan', [\App\Http\Controllers\AppController::class, 'scan']);
