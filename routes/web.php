<?php

Route::get('/', function () {
    return redirect('/posts');
});

Route::resource('posts', 'PostController');

Route::get('/about', function () {
    return view('about');
});
Route::get('/contacts', function () {
    return view('contacts');
});
Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/admin/feedback', 'FeedbackController@index');
Route::post('/admin/feedback', 'FeedbackController@store');
