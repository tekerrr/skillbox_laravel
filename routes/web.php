<?php

Route::get('/', function () {
    return redirect('/posts');
});

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::view('/admin', 'admin.index');

Route::resource('posts', 'PostsController');
Route::resource('tasks', 'TasksController');

Route::get('/admin/feedback', 'FeedbackController@index');
Route::post('/admin/feedback', 'FeedbackController@store');
