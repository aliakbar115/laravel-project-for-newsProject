<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\CategoryController;

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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('admin/users/all',[UserController::class,"index"] );
Route::post('admin/users/create',[UserController::class,"create"] );
Route::get('admin/users/edit/{user}',[UserController::class,"edit"] );
Route::post('admin/users/update',[UserController::class,"update"] );
Route::delete('admin/users/delete/{user}',[UserController::class,"delete"] );
Route::get('admin/users/search',[UserController::class,"search"] );

Route::get('admin/categories/all',[CategoryController::class,"index"] );
Route::get('admin/categories/allParent',[CategoryController::class,"allParent"] );
Route::post('admin/categories/create',[CategoryController::class,"create"] );
Route::get('admin/categories/edit/{category}',[CategoryController::class,"edit"] );
Route::post('admin/categories/update',[CategoryController::class,"update"] );



Route::delete('admin/categories/delete/{category}',[CategoryController::class,"delete"] );
Route::get('admin/categories/search',[CategoryController::class,"search"] );

