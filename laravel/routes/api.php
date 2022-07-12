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

Route::get('/sales',[App\Http\Controllers\ManageSalesController::class, 'GetAllSales']);
Route::get('/sales/{sale}',[App\Http\Controllers\ManageSalesController::class, 'GetSaleByCode']);
Route::put('/sales/{sale}',[App\Http\Controllers\ManageSalesController::class, 'updateSaleByCode']);
Route::delete('/sales/{sale}',[App\Http\Controllers\ManageSalesController::class, 'deleteSaleByCode']);
Route::post('/sales',[App\Http\Controllers\CreateSaleController::class, 'addSale']);


