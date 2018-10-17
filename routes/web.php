<?php

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
Auth::routes();

Route::get('/discussions', function () {
    return view('discussions');
});

Route::get('/', 'ForumsController@index')->name('forum.index');
Route::get('/topic/{id}', 'ForumsController@topic')->name('topic.discussions');
Route::get('/home', 'ForumsController@index')->name('forum.index');

Route::get('{provider}/auth', [
    'uses' => 'SocialsController@auth',
    'as' => 'social.auth'
]);


Route::group(['middleware' => 'auth'], function () {
    Route::resource('topics', 'TopicsController');
    Route::get('discussions/create', 'DiscussionsController@create')
        ->name('discussions.create');
    Route::post('discussions/store', 'DiscussionsController@store')
        ->name('discussions.store');
    Route::get('/discussions/my/discussions', 'DiscussionsController@user_discussions')
        ->name('discussions.my-discussions');
    Route::get('discussions/{slug}', 'DiscussionsController@show')
        ->name('discussions.show');
    Route::get('/discussions/edit/{id}', 'DiscussionsController@edit')
        ->name('discussions.edit');
    Route::post('/discussions/update/{id}', 'DiscussionsController@update')
        ->name('discussions.update');
    Route::get('/discussions/destroy/{id}', 'DiscussionsController@destroy')
        ->name('discussions.destroy');
    Route::post('discussions/reply/{id}', 'DiscussionsController@reply')
        ->name('discussions.reply');
    Route::get('/reply/like/{id}', 'RepliesController@like')
        ->name('reply.like');
    Route::get('/reply/unlike/{id}', 'RepliesController@unlike')
        ->name('reply.unlike');
    Route::get('/discussions/watch/{id}', 'WatchersController@watch')
        ->name('discussion.watch');
    Route::get('/discussions/unwatch/{id}', 'WatchersController@unwatch')
        ->name('discussion.unwatch');
    Route::get('/discussions/best-reply/{id}', 'RepliesController@best_answer')
        ->name('discussion.best-reply');
});