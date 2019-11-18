<?php

Route::redirect('/', '/posts');

Route::get('/posts/tags/{tag}', 'TagController@index');

Route::resource('posts', 'PostController');

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::view('/admin', 'admin.index')->middleware('role:admin');

Route::get('/admin/feedback', 'FeedbackController@index')->middleware('role:admin');
Route::post('/admin/feedback', 'FeedbackController@store');

Auth::routes();
