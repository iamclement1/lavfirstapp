<?php

use App\Http\Controllers\BlogPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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
//user related routes
Route::get('/', [UserController::class, "showHomepage"])->name('login');

Route::post('/register', [UserController::class, "register"])->middleware('guest');

Route::post('/login', [UserController::class, "login"])->middleware('guest');

Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLoggedIn');

//blog post routes
Route::get('/create-post', [BlogPostController::class, "showCreateForm"])->middleware('mustBeLoggedIn');
Route::post('/create-post', [BlogPostController::class, "newPost"])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [BlogPostController::class, 'viewSinglePost']);
