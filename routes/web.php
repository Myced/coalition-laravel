<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'products'], function(){
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/{id}/update', [ProductController::class, 'update'])->name('product.update');
});
