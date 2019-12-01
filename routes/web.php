<?php

Route::redirect('/', '/posts');

Auth::routes();

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::post('/feedback', 'FeedbackController@store');

Route::resource('posts', 'PostController');
Route::get('/posts/tags/{tag}', 'TagController@index');

Route::resource('news', 'NewsController')->only(['index', 'show']);

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/', 'admin.index');
    Route::get('/feedback', 'Admin\FeedbackController@index');

    Route::get('/posts', 'Admin\PostController@index');
    Route::patch('/posts/{post}/activate', 'Admin\PostController@activate');
    Route::patch('/posts/{post}/deactivate', 'Admin\PostController@deactivate');

    Route::resource('news', 'Admin\NewsController')->except(['show']);
    Route::patch('/news/{news}/activate', 'Admin\NewsController@activate');
    Route::patch('/news/{news}/deactivate', 'Admin\NewsController@deactivate');
});
