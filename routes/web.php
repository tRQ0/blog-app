<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\Dashboardcontroller;

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

Route::get('/',[PostsController::class, 'index']);

Route::get('/services', [pagesController::class, 'services']);

Route::get('/about',[pagesController::class, 'about']);

Route::resource('/post', PostsController::class);
Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 