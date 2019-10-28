<?php

Route::get('/about', function () {
    return view('about');
});
Route::get('/contacts', function () {
    return view('contacts');
});
Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/', 'PostsController@index');
Route::get('/posts/create', 'PostsController@create');
Route::post('/posts', 'PostsController@store');
Route::get('posts/{post}', 'PostsController@show');

Route::get('/admin/feedback', 'FeedbackController@index');
Route::post('/admin/feedback', 'FeedbackController@store');
