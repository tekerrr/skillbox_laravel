<?php

Route::redirect('/', '/posts');

Auth::routes();

Route::view('/about', 'about')->name('about');
Route::view('/contacts', 'contacts')->name('contacts');
Route::post('/feedback', 'FeedbackController@store')->name('feedback.store');

Route::resource('posts', 'PostController');
Route::get('/tags/{tag}', 'TagController@show')->name('tags.show');

Route::resource('news', 'NewsController')->only(['index', 'show']);

Route::resource('comments', 'CommentController')->only('store');

Route::prefix('/admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/', 'admin.index')->name('index');
    Route::get('/feedback', 'Admin\FeedbackController@index')->name('feedback.index');
    Route::get('/statistics', 'Admin\StatisticsController@index')->name('statistics.index');

    Route::get('/posts', 'Admin\PostController@index')->name('posts.index');
    Route::patch('/posts/{post}/activate', 'Admin\PostController@activate')->name('posts.activate');
    Route::patch('/posts/{post}/deactivate', 'Admin\PostController@deactivate')->name('posts.deactivate');

    Route::resource('news', 'Admin\NewsController')->except(['show']);
    Route::patch('/news/{news}/activate', 'Admin\NewsController@activate')->name('news.activate');
    Route::patch('/news/{news}/deactivate', 'Admin\NewsController@deactivate')->name('news.deactivate');
});
