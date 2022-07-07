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

Route::get('/show-sale',[App\Http\Controllers\ManageSalesController::class, 'GetSaleByCode']);
Route::get('/all-sales',[App\Http\Controllers\ManageSalesController::class, 'GetAllSales']);
Route::get('/update-sale',[App\Http\Controllers\ManageSalesController::class, 'updateSaleByCode']);
Route::get('/delete-sale',[App\Http\Controllers\ManageSalesController::class, 'deleteSaleByCode']);


