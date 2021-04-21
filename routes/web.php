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

	Route::post('/Oz5ebsV9HnflVOUTX7d23AdcJyILNMtM0A2t08udzbsKCKNwgYzDTT8NmlwuIyxH', [App\Http\Controllers\Site\User\DataController::class, 'isLoged']);

	/* UPDATE USER DATA */

		Route::post('/fOvpJZWfCJAULgNxBxVINoFyr6k9rBxxqG2HMbGGDZjN3HidWmWTrUPqaJPNCIqV', [App\Http\Controllers\Site\User\DataController::class, 'passwordUpdate']);

		Route::post('/FRsS0qDC72HsM1TxceEpmyUtU3vT4rA5T9H0j2QB8AJd1UdFklUpGSc5takQTpLg', [App\Http\Controllers\Site\User\DataController::class, 'titleUpdate']);

/* COMMUNITY ROUTES */
	
	/* Get Community */
	Route::get('/c/{community_tag}', [App\Http\Controllers\Site\Community\CommunityController::class, 'getCommunity']);

	/* New Community */
	Route::get('/crear/comunidad', [App\Http\Controllers\Site\Community\CommunityController::class, 'newCommunity']);

	/* Delete Thread From Community */
	Route::post('/MnwBIllIldnKdXEQIPjzD5Lw9afwhWnlwhPbNR74rqJwnY4GOpVho1k86BtzlmAe', [App\Http\Controllers\Site\Thread\ThreadController::class, 'deleteThread']);

	/* Close Thread From Community */
	Route::post('/yj6fXnl79TqYcl0qzQcSgDf5nmffpks17WHwwl0XSa4Awv4QQF7oG1BamLMPRX2o', [App\Http\Controllers\Site\Thread\ThreadController::class, 'closeThread']);

	/* Community Affiliates */
	Route::get('/c/{community_tag}/afiliados/{character?}', [App\Http\Controllers\Site\Community\CommunityController::class, 'getAffiliates']);

		/* Rank as Affiliate */
		Route::post('/MgJCirumZx0M57VrYsez96UcOcLDldCSdSlbUB8htSQaHP81rSFHWLm1GfEfX3K0', [App\Http\Controllers\Site\Community\CommunityController::class, 'rankAsAffiliate']);

		/* Rank as Moderator */
		Route::post('/4DzqRtvvMOTK0UIy6z9wXPaHwDTu0qiJk9288x8SGVv9DGkOWYh5elW2tad2ab6T', [App\Http\Controllers\Site\Community\CommunityController::class, 'rankAsModerator']);

		/* Rank as Leader */
		Route::post('/nn6pOlrj9U80946uspAXdcdBQylNZEK5cvyQKWDcZHTm05PQAfAaTpX8lH27IFVm', [App\Http\Controllers\Site\Community\CommunityController::class, 'rankAsLeader']);

		/* Ban from Community */
		Route::post('/Tlka8Kyzu5R0srMvRS6oXzoDqmjcuGc6747JTgBamYS5lBwYgzZExLg2ii6KSOPO', [App\Http\Controllers\Site\Community\CommunityController::class, 'banUserFromCommunity']);

	/* UPDATE COMMUNITY DATA */

		Route::post('/kXQ2kAuP1djrzKllFvbRBQGKJlvg9iHzmUyhfZM7PcsAJcQBOGvPY1rZ8E1GjlN6', [App\Http\Controllers\Site\Community\CommunityController::class, 'titleUpdate']);

		Route::post('/OC7OuuXnoN00lT5xb9Mu49UcKBsy2Ghe6TOk0T2OA4Ucl4nM7azA4zaRI611e3xc', [App\Http\Controllers\Site\Community\CommunityController::class, 'descriptionUpdate']);

		Route::post('/hlZ2PLZqClmRv5hJiOx9yuTxloMkRc9dnIeIGvbGDLuSXZzgSLtMQeWWCRprHOTu', [App\Http\Controllers\Site\Community\CommunityController::class, 'addCommunityRule']);

		Route::post('/FtxRLrW2w7crAx99m5gT6ukkiwxeG1HcZTq7tWreG0w5uiqbugrFGihXRQDGM7il', [App\Http\Controllers\Site\Community\CommunityController::class, 'editCommunityRule']);

		Route::post('/ShFf3C9lafsFix1WiQZaYibRKnNRnACmocgHSpHq4cPqVfXdkD0YzT6io2uV0keL', [App\Http\Controllers\Site\Community\CommunityController::class, 'deleteCommunityRule']);

		Route::post('/RQvm8SR9ZOTZ7nSCFEYCCxirXnlam7VblDkIEYkVbbTCUaKuBnlCJG6DBlW7E8nF', [App\Http\Controllers\Site\Community\CommunityController::class, 'logoUpdate']);

		Route::post('/4pT8SAeIt9rpNsm2W8tUd9cytXHUOXANLXec6V6aTqjbehfFd8EXT6f5Yp6jezQs', [App\Http\Controllers\Site\Community\CommunityController::class, 'backgroundUpdate']);

	/* COMMUNITY REPORTS */
	
		/* Get Community Reports */
		Route::get('/c/{community_tag}/reportes', [App\Http\Controllers\Site\Community\CommunityController::class, 'getCommunityReports']);

		/* Solve Thread Report */
		Route::post('/O6pbHM8Jj18jTPAAwKAyLfL0TCbduWNcGxykzWm7qwb876B2y3pJAdeD9ZOgaZX3', [App\Http\Controllers\Site\Community\ReportController::class, 'solveThread']);

		/* Solve Reply Report */
		Route::post('/fs8wk39otA5BO5feaB7xWkvhMCBgXOHuWZIhYjNe72Zy9XBMpTYUAFQHyFtdI7iS', [App\Http\Controllers\Site\Community\ReportController::class, 'solveReply']);

/* THREAD ROUTES */

	Route::get('/crear/tema', [App\Http\Controllers\Site\Thread\ThreadController::class, 'newThread']);

	Route::get('/c/{community_tag}/t/{thread_id}', [App\Http\Controllers\Site\Thread\ThreadController::class, 'getThreadData'])->where('thread_id', '[0-9]+');

	Route::post('/aLzEAm3NB3BelFXWhNnPm7lt4enHzGFu0f64eX6Yt7ExAqkRWmnUQspibxZN5UkX', [App\Http\Controllers\Site\Thread\ThreadController::class, 'makeThread']);

/* REPLY ROUTES */

	Route::post('/bkXekAj1QU3vFgFB3Sk8XtZxnxzsuSaKmJbktKTXVEz8jm9JKBs8v3QC7RoKfbIm', [App\Http\Controllers\Site\Thread\ReplyController::class, 'makeReply']);

	/* Wipe Reply */
		Route::post('/T1QjrednUfNiJxYousLYfcBNGu8f5UzSgtb6JgL7ZicvswZgv8T0gkfh97PqVqFu', [App\Http\Controllers\Site\Thread\ReplyController::class, 'wipeReply']);

/* GUIDE ROUTES */

	Route::get('/comunidades/{character?}', [App\Http\Controllers\Site\Guide\GuideController::class, 'communitiesGuide']);

	Route::get('/usuarios/{character?}', [App\Http\Controllers\Site\Guide\GuideController::class, 'usersGuide']);

	Route::get('/temas/{character?}', [App\Http\Controllers\Site\Guide\GuideController::class, 'threadsGuide']);

	Route::get('/tops/{date}', [App\Http\Controllers\Site\Guide\GuideController::class, 'topsByDate']);

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
Route::get('/test2', [App\Http\Controllers\Site\IndexController::class, 'test2']);
