<?php

Route::redirect('/', '/posts');

Auth::routes();

Route::view('/about', 'about')->name('about');
Route::view('/contacts', 'contacts')->name('contacts');
Route::post('/feedback', 'FeedbackController@store')->name('feedback.store');

Route::resource('posts', 'PostController');
Route::post('/posts/{post}/comments', 'PostController@addComment')->name('posts.comments.store');

Route::resource('news', 'NewsController')->only(['index', 'show']);
Route::post('/news/{news}/comments', 'NewsController@addComment')->name('news.comments.store');

Route::get('/tags/{tag}', 'TagController@show')->name('tags.show');

Route::prefix('/admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/', 'admin.index')->name('index');
    Route::get('/feedback', 'Admin\FeedbackController@index')->name('feedback.index');
    Route::get('/statistics', 'Admin\StatisticsController@index')->name('statistics.index');

    Route::view('/reports', 'admin.reports.index')->name('reports.index');
    Route::get('/reports/total', 'Admin\Reports\TotalController@index')->name('reports.total');
    Route::post('/reports/total', 'Admin\Reports\TotalController@store')->name('reports.total.store');

    Route::get('/reports/files', 'Admin\Reports\SavedReportController@index')->name('reports.files');
    Route::get('/reports/files/{file}', 'Admin\Reports\SavedReportController@download')->name('reports.files.download');

    Route::get('/posts', 'Admin\PostController@index')->name('posts.index');
    Route::patch('/posts/{post}/activate', 'Admin\PostController@activate')->name('posts.activate');
    Route::patch('/posts/{post}/deactivate', 'Admin\PostController@deactivate')->name('posts.deactivate');

    Route::resource('news', 'Admin\NewsController')->except(['show']);
    Route::patch('/news/{news}/activate', 'Admin\NewsController@activate')->name('news.activate');
    Route::patch('/news/{news}/deactivate', 'Admin\NewsController@deactivate')->name('news.deactivate');
});
