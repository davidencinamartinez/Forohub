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

	Route::get('/destacados', [App\Http\Controllers\Site\IndexController::class, 'featuredIndex']);

/* USER ROUTES */

	Route::get('/register', function () {
		return redirect()->route('index');
	});

	Route::get('/login', function () {
		return redirect()->route('index');
	});

	Route::get('/logout', function () {
		return redirect()->route('index');
	});

	Route::get('/u/{user}', [App\Http\Controllers\Site\User\DataController::class, 'getUser']);

	Route::post('/register', [App\Http\Controllers\Site\User\RegisterController::class, 'register']);

	Route::get('/user/verify/{token}',  [App\Http\Controllers\Site\User\RegisterController::class, 'verifyUser']);

	Route::post('/login', [App\Http\Controllers\Site\User\LogController::class, 'login'])->name('login');

	Route::post('/logout', [App\Http\Controllers\Site\User\LogController::class, 'logout'])->name('logout');


/* COMMUNITY ROUTES */

	Route::get('/c/{community_tag}', [App\Http\Controllers\Site\Community\CommunityController::class, 'getCommunity']);

	Route::get('/crear/comunidad', [App\Http\Controllers\Site\Community\CommunityController::class, 'newCommunity']);

	/* New Community */

/* THREAD ROUTES */

	Route::get('/crear/tema', [App\Http\Controllers\Site\Thread\ThreadController::class, 'newThread']);

	Route::get('/c/{community_tag}/t/{thread_id}', [App\Http\Controllers\Site\Thread\ThreadController::class, 'getThreadData'])->where('thread_id', '[0-9]+');

	Route::post('/aLzEAm3NB3BelFXWhNnPm7lt4enHzGFu0f64eX6Yt7ExAqkRWmnUQspibxZN5UkX', [App\Http\Controllers\Site\Thread\ThreadController::class, 'makeThread']);

/* REPLY ROUTES */

	Route::post('bkXekAj1QU3vFgFB3Sk8XtZxnxzsuSaKmJbktKTXVEz8jm9JKBs8v3QC7RoKfbIm', [App\Http\Controllers\Site\Thread\ReplyController::class, 'makeReply']);

/* GUIDE ROUTES */

	Route::get('/comunidades/{character}', [App\Http\Controllers\Site\Guide\GuideController::class, 'communitiesGuide']);

	Route::get('/usuarios/{character}', [App\Http\Controllers\Site\Guide\GuideController::class, 'usersGuide']);

/* AJAX CALLS */

	/* Vote Thread */
	Route::post('/Pvda2ubTcQSFI7bhHgJRP3VS9PrQf8zpK4PuDwg0z57S9uLyWd6zPRy0MPUJasnc', [App\Http\Controllers\Site\IndexController::class, 'voteThread']);
	Route::get('/Pvda2ubTcQSFI7bhHgJRP3VS9PrQf8zpK4PuDwg0z57S9uLyWd6zPRy0MPUJasnc', function () {
		abort(404);
	});

	/* Get Rewards */
	Route::get('/ttdKHuNiH5AGpk3iVy04ORoMxfimsEW77ggVCbEA9Bvl9ZMbrXFqED7DjgCwkjEi', [App\Http\Controllers\Site\User\DataController::class, 'getRewards']);

	/* Refresh Voted Thread */
	Route::post('/YUakGZBLR5lmfvm1HlwGFLUbHaPfJhAYr7oo4qweWFhDUfMfBWqlIzjIvb1NXbBN', [App\Http\Controllers\Site\IndexController::class, 'voteThread']);
	Route::get('/YUakGZBLR5lmfvm1HlwGFLUbHaPfJhAYr7oo4qweWFhDUfMfBWqlIzjIvb1NXbBN', function () {
		abort(404);
	});

	/* Get Notifications */
	Route::get('/yT5rjyh3QA1Pk8kH4A3rLchG1oGgGMtr7Hs3qpwvhgC8UagAaVoSlCZgEzdiMHxn', [App\Http\Controllers\Site\User\DataController::class, 'getNotifications']);

	/* Read Notifications */
	Route::post('/KlRf4ZSnlOuriz8ymbDDacEtaEdYPwUPi2uMOskmKxuh2coL11JwIdtyYH2qZRmG', [App\Http\Controllers\Site\User\DataController::class, 'readNotifications']);
	Route::get('/KlRf4ZSnlOuriz8ymbDDacEtaEdYPwUPi2uMOskmKxuh2coL11JwIdtyYH2qZRmG', function () {
		abort(404);
	});

	/* Join Community */
	Route::post('/m825i5Wul0hEBxjHBh8GVS9n5WmFU8ARuDqPSfOEDrXaoeo7HCQYJgMWmYt1LeXJ', [App\Http\Controllers\Site\User\DataController::class, 'joinCommunity']);
	Route::get('/m825i5Wul0hEBxjHBh8GVS9n5WmFU8ARuDqPSfOEDrXaoeo7HCQYJgMWmYt1LeXJ', function () {
		abort(404);
	});

	/* Unjoin Community */
	Route::post('/g1VJH8HX7nsGvGuGPVZxASEW4rcSjyZ2oAuwrSWo8oor1f94OCk1WGxLKQIkA2cv', [App\Http\Controllers\Site\User\DataController::class, 'unjoinCommunity']);
	Route::get('/g1VJH8HX7nsGvGuGPVZxASEW4rcSjyZ2oAuwrSWo8oor1f94OCk1WGxLKQIkA2cv', function () {
		abort(404);
	});

	/* Send Thread Report */
	Route::post('/zKj113txZHvkB86ZPWnnJxIYB438y7SeBfkKMR84zvp5XgC5DIsEpP5F1vOtPsoT', [App\Http\Controllers\Site\Report\ReportController::class, 'sendThreadReport']);
	Route::get('/zKj113txZHvkB86ZPWnnJxIYB438y7SeBfkKMR84zvp5XgC5DIsEpP5F1vOtPsoT', function () {
		abort(404);
	});

	/* Send Reply Report */
	Route::post('/gAKFLXK4xRsW8kMCRAFi3GjzwBYa8oMrSV4pQ6O0m14xoZP6Mi8hAAH6LEqdwsOl', [App\Http\Controllers\Site\Report\ReportController::class, 'sendReplyReport']);
	Route::get('/gAKFLXK4xRsW8kMCRAFi3GjzwBYa8oMrSV4pQ6O0m14xoZP6Mi8hAAH6LEqdwsOl', function () {
		abort(404);
	});

	/* Update User Avatar */
	Route::post('/hT8IFRUl6hAVCSCmv7iBeGDKBSMgT0XQl3quQh4EJOzeMCQ1ZwTMzWE6VMWo3le7', [App\Http\Controllers\Site\User\DataController::class, 'updateAvatar']);
	Route::get('/hT8IFRUl6hAVCSCmv7iBeGDKBSMgT0XQl3quQh4EJOzeMCQ1ZwTMzWE6VMWo3le7', function () {
		abort(404);
	});

	/* Get Community Tag */
	Route::get('/9bKSmij7MRoNx6ZU9MWFzRe8zPre4klv7L3YxXYZ7Knl8qW5PYn1l3ESgejrV1cE/{tag}', [App\Http\Controllers\Site\Thread\ThreadController::class, 'getCommunityTag']);

	/* Vote Poll */
	Route::post('/S4Tv3XILDMnGXYwp8bqof0Of5A4kEAzehcoJKnGj6KyOf8fKCQrklvGuWZ7ATU43', [App\Http\Controllers\Site\Thread\ThreadController::class, 'votePoll']);
	Route::get('/S4Tv3XILDMnGXYwp8bqof0Of5A4kEAzehcoJKnGj6KyOf8fKCQrklvGuWZ7ATU43', function () {
		abort(404);
	});

	/* Check */
	Route::post('/bEOqw0g8isVWDPjOKCbHjfxUNsgMCLtOlIux2pSbp7PLI6uMVSGkvmlFkyIfde6c', [App\Http\Controllers\Site\Thread\ThreadController::class, 'checkMultimedia']);

	/* New Community */
	Route::post('/67aOVLKR4DLJTUSL6OkdHewSt9fcCxJiCt0EkE1dCUejJ4VMhH5iiE0ecKxzxmMl', [App\Http\Controllers\Site\Community\CommunityController::class, 'validateNewCommunity']);
	Route::get('/67aOVLKR4DLJTUSL6OkdHewSt9fcCxJiCt0EkE1dCUejJ4VMhH5iiE0ecKxzxmMl', function () {
		abort(404);
	});

/* TEST ROUTES */

Route::get('/test', [App\Http\Controllers\Site\IndexController::class, 'test']);
