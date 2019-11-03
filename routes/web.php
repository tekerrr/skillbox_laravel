<?php

app()->bind(\App\PriceFormatter::class, function () {
    return new \App\OtherPriceFormatter();
});

Route::get('/test', function (\App\PriceFormatter $formatter) {
    dd($formatter->format(10000));
});

Route::get('/', function () {
    return redirect('/posts');
});

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::view('/admin', 'admin.index');

Route::resource('posts', 'PostsController');

Route::get('/admin/feedback', 'FeedbackController@index');
Route::post('/admin/feedback', 'FeedbackController@store');



Route::get('/tasks/tags/{tag}', 'TagsController@index');

Route::resource('tasks', 'TasksController');
Route::patch('/steps/{step}', 'TaskStepsController@update');

Route::post('/completed-steps/{step}', 'CompletedStepsController@store');
Route::delete('/completed-steps/{step}', 'CompletedStepsController@destroy');

