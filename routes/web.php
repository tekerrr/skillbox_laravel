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

    Route::get('/posts', 'Admin\PostController@index')->name('posts.index');
    Route::patch('/posts/{post}/activate', 'Admin\PostController@activate')->name('posts.activate');
    Route::patch('/posts/{post}/deactivate', 'Admin\PostController@deactivate')->name('posts.deactivate');

    Route::resource('news', 'Admin\NewsController')->except(['show']);
    Route::patch('/news/{news}/activate', 'Admin\NewsController@activate')->name('news.activate');
    Route::patch('/news/{news}/deactivate', 'Admin\NewsController@deactivate')->name('news.deactivate');
});

Route::get('/test', function () {
    $header = ['first name', 'last name', 'email'];
    $records = [
        [1, 2, 3],
        ['foo', 'bar', 'baz'],
        ['john', 'doe', 'john.doe@example.com'],
    ];

    $csv = \League\Csv\Writer::createFromPath(storage_path('app/new_file.csv'), 'w+');
    $csv->insertOne($header);
    $csv->insertAll($records);
    return 'ok';
});
