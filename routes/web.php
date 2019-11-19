<?php

Route::redirect('/', '/posts');

Auth::routes();

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::post('/feedback', 'FeedbackController@store');

Route::resource('posts', 'PostController');
Route::get('/posts/tags/{tag}', 'TagController@index');

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/', 'admin.index');
    Route::get('/posts', 'Admin\PostController@index');
    Route::get('/feedback', 'Admin\FeedbackController@index');
});
