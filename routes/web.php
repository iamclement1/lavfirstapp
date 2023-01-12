<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
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

Route::get('/',[UserController::class, "showHomepage"] );

Route::get('/about', [WebController::class, "About"] );

Route::post('/register', [UserController::class, "register"]);

Route::get('/login', [UserController::class, "login"]);

Route::get('/logout', [UserController::class, "logout"]);

