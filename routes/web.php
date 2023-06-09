<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index']);
Route::get('user/{user:id}', [UserController::class, 'show']);
Route::post('user/create', [UserController::class, 'store']);
Route::put('user/{user:id}/update', [UserController::class, 'update']);
Route::post('user/{user:id}/delete', [UserController::class, 'destroy']);

Route::controller(ProductController::class)->group(function () {
  Route::get('/products', 'index');
  Route::post('/products', 'store');
  Route::put('/products/{product:id}', 'update');
  Route::delete('/products/{product:id}', 'destroy');
});
