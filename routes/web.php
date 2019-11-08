<?php

Route::redirect('/', '/posts');

Route::get('/posts/tags/{tag}', 'TagController@index');

Route::resource('posts', 'PostController');

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::view('/admin', 'admin.index');

Route::get('/admin/feedback', 'FeedbackController@index');
Route::post('/admin/feedback', 'FeedbackController@store');

Auth::routes();
