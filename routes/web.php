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

/* THREAD ROUTES */

Route::post('bkXekAj1QU3vFgFB3Sk8XtZxnxzsuSaKmJbktKTXVEz8jm9JKBs8v3QC7RoKfbIm', [App\Http\Controllers\Site\Thread\ReplyController::class, 'createReply']);

/* AJAX CALLS */

Route::post('/Pvda2ubTcQSFI7bhHgJRP3VS9PrQf8zpK4PuDwg0z57S9uLyWd6zPRy0MPUJasnc', [App\Http\Controllers\Site\IndexController::class, 'voteThread']);

Route::get('/ttdKHuNiH5AGpk3iVy04ORoMxfimsEW77ggVCbEA9Bvl9ZMbrXFqED7DjgCwkjEi', [App\Http\Controllers\Site\User\DataController::class, 'getRewards']);

Route::post('/YUakGZBLR5lmfvm1HlwGFLUbHaPfJhAYr7oo4qweWFhDUfMfBWqlIzjIvb1NXbBN', [App\Http\Controllers\Site\IndexController::class, 'voteThread']);

Route::get('/yT5rjyh3QA1Pk8kH4A3rLchG1oGgGMtr7Hs3qpwvhgC8UagAaVoSlCZgEzdiMHxn', [App\Http\Controllers\Site\User\DataController::class, 'getNotifications']);

Route::post('/KlRf4ZSnlOuriz8ymbDDacEtaEdYPwUPi2uMOskmKxuh2coL11JwIdtyYH2qZRmG', [App\Http\Controllers\Site\User\DataController::class, 'readNotifications']);

Route::post('/m825i5Wul0hEBxjHBh8GVS9n5WmFU8ARuDqPSfOEDrXaoeo7HCQYJgMWmYt1LeXJ', [App\Http\Controllers\Site\User\DataController::class, 'joinCommunity']);

Route::post('/g1VJH8HX7nsGvGuGPVZxASEW4rcSjyZ2oAuwrSWo8oor1f94OCk1WGxLKQIkA2cv', [App\Http\Controllers\Site\User\DataController::class, 'unjoinCommunity']);


/* TEST ROUTES */

Route::get('/test', [App\Http\Controllers\Site\IndexController::class, 'test'])->name('test');

Route::get('/testing', [App\Http\Controllers\Site\User\DataController::class, 'unreadNotifications']);

