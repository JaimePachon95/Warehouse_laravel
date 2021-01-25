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


Route::get('/','WarehouseController@index');
Route::post('/warehouses','WarehouseController@store')->name('warehouse.store');
Route::post('/warehouses/update','WarehouseController@update')->name('warehouse.update');
Route::post('/warehouses/destroy','WarehouseController@destroy')->name('warehouse.destroy');
