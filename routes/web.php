<?php

Route::redirect('/', '/posts');

Route::get('/posts/tags/{tag}', 'TagController@index');

Route::resource('posts', 'PostController');

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::post('/feedback', 'FeedbackController@store');

Route::view('/admin', 'admin.index')->middleware('role:admin');
Route::get('/admin/feedback', 'FeedbackController@index');

Auth::routes();
