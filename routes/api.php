<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoriesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// authentication
Route::post('/login', [AuthController::class, 'signIn'])->name('login');
Route::post('/register', [AuthController::class, 'signUp'])->name('register');
Route::post('/logout', [AuthController::class, 'signOut'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    //news
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    //categories
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});

//categories
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');

//news
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news/search/{title}', [NewsController::class, 'search'])->name('news.search');
Route::get('/news/category/sport', [NewsController::class, 'sport'])->name('news.sport');
Route::get('/news/category/finance', [NewsController::class, 'finance'])->name('news.finance');
Route::get('/news/category/automotive', [NewsController::class, 'automotive'])->name('news.automotive');
