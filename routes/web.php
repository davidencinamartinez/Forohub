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

//Auth::routes(['verify' => true, 'register' => false]);

/* SITE ROUTES */

Route::get('/', [App\Http\Controllers\Site\IndexController::class, 'index'])->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);



/* USER ROUTES */

Route::get('/register', function () {
	return redirect()->route('index');
});

Route::post('/register', [App\Http\Controllers\Site\User\RegisterController::class, 'register']);

Route::get('/user/verify/{token}',  [App\Http\Controllers\Site\User\RegisterController::class, 'verifyUser']);

Route::post('/login', [App\Http\Controllers\Site\User\LogController::class, 'login'])->name('login');

Route::post('/logout', [App\Http\Controllers\Site\User\LogController::class, 'logout'])->name('logout');

/* AJAX CALLS */

Route::post('/ajax/Pvda2ubTcQSFI7bhHgJRP3VS9PrQf8zpK4PuDwg0z57S9uLyWd6zPRy0MPUJasnc', [App\Http\Controllers\Site\IndexController::class, 'voteThread']);

Route::get('/ajax/ttdKHuNiH5AGpk3iVy04ORoMxfimsEW77ggVCbEA9Bvl9ZMbrXFqED7DjgCwkjEi', [App\Http\Controllers\Site\User\DataController::class, 'rewards']);

Route::post('/ajax/YUakGZBLR5lmfvm1HlwGFLUbHaPfJhAYr7oo4qweWFhDUfMfBWqlIzjIvb1NXbBN', [App\Http\Controllers\Site\IndexController::class, 'voteThread']);

/* TEST ROUTES */

Route::get('/test', [App\Http\Controllers\Site\IndexController::class, 'test'])->name('test');

