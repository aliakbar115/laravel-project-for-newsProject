<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\CommentController;
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

Route::middleware('auth:api')->group(function () {
    Route::get('admin/checkAdmin', [UserController::class, "checkAdmin"]);
    Route::get('admin/users/all', [UserController::class, "index"]);
    Route::post('admin/users/create', [UserController::class, "create"]);
    Route::get('admin/users/edit/{user}', [UserController::class, "edit"]);
    Route::post('admin/users/update', [UserController::class, "update"]);
    Route::delete('admin/users/delete/{user}', [UserController::class, "delete"]);
    Route::get('admin/users/search', [UserController::class, "search"]);

    Route::get('admin/categories/all', [CategoryController::class, "index"]);
    Route::get('admin/categories/allParent', [CategoryController::class, "allParent"]);
    Route::post('admin/categories/create', [CategoryController::class, "create"]);
    Route::get('admin/categories/edit/{category}', [CategoryController::class, "edit"]);
    Route::post('admin/categories/update', [CategoryController::class, "update"]);
    Route::delete('admin/categories/delete/{category}', [CategoryController::class, "delete"]);
    Route::get('admin/categories/search', [CategoryController::class, "search"]);

    Route::get('admin/articles/all', [ArticleController::class, "index"]);
    Route::post('admin/articles/create', [ArticleController::class, "create"]);
    Route::get('admin/articles/edit/{article}', [ArticleController::class, "edit"]);
    Route::post('admin/articles/update', [ArticleController::class, "update"]);
    Route::delete('admin/articles/delete/{article}', [ArticleController::class, "delete"]);
    Route::get('admin/articles/search', [ArticleController::class, "search"]);

    Route::get('admin/comments/allApproved', [CommentController::class, "allApproved"]);
    Route::get('admin/comments/allUnApproved', [CommentController::class, "allUnApproved"]);
    Route::delete('admin/comments/delete/{comment}', [CommentController::class, "delete"]);
    Route::get('admin/comments/search', [CommentController::class, "search"]);
    Route::post('admin/comments/setApproved/{comment}', [CommentController::class, "setApproved"]);
    Route::post('admin/comments/response', [CommentController::class, "response"]);
    Route::get('admin/comments/getResponse/{comment}', [CommentController::class, "getResponse"]);
    Route::post('admin/comments/delete/response/{comment}', [CommentController::class, "delete_response"]);
});

Route::get('articles/all/visited', [App\Http\Controllers\Api\V1\Home\ArticleController::class, "visited"]);
Route::get('articles/one/recentNews', [App\Http\Controllers\Api\V1\Home\ArticleController::class, "recentNews"]);
Route::get('articles/tow/viewNews', [App\Http\Controllers\Api\V1\Home\ArticleController::class, "viewNews"]);
Route::get('home/articles/commentArticles', [App\Http\Controllers\Api\V1\Home\ArticleController::class, "commentArticles"]);
Route::get('article/one/content/{article}', [App\Http\Controllers\Api\V1\Home\ArticleController::class, "getArticle"]);
Route::post('articles/comments/send_comment/{article}', [App\Http\Controllers\Api\V1\Home\ArticleController::class, "send_comment"]);
Route::get('home/categories/all', [App\Http\Controllers\Api\V1\Home\CategoryController::class, "allCategories"]);
Route::get('articles/category/content/{category}', [App\Http\Controllers\Api\V1\Home\CategoryController::class, "getArticles"]);
Route::post('account/register', [App\Http\Controllers\Api\V1\Home\UserController::class, "register"]);
Route::post('account/login', [App\Http\Controllers\Api\V1\Home\UserController::class, "login"]);
