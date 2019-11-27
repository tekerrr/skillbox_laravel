<?php

Route::get('/', function () {
    return redirect('/posts');
});

Route::view('/about', 'about');
Route::view('/contacts', 'contacts');
Route::view('/admin', 'admin.index');

Route::resource('posts', 'PostsController');

Route::get('/admin/feedback', 'FeedbackController@index');
Route::post('/admin/feedback', 'FeedbackController@store');

Route::view('/demo', 'demo');



Route::get('/tasks/tags/{tag}', 'TagsController@index');

Route::resource('tasks', 'TasksController');
Route::post('/tasks/{task}/steps', 'TaskStepsController@store');
Route::patch('/steps/{step}', 'TaskStepsController@update');

Route::post('/completed-steps/{step}', 'CompletedStepsController@store');
Route::delete('/completed-steps/{step}', 'CompletedStepsController@destroy');

Auth::routes();

Route::middleware('auth')->post('/companies', function () {
    auth()->user()->company()->create(request()->validate(['name' => 'required']));
});

Route::get('/service', 'PushServiceController@form');
Route::post('/service', 'PushServiceController@send');

Route::get('/test', function () {
//    return \App\User::all()
////        ->makeVisible('email')
////        ->each->append(['is_manager'])
//        ->each->setAppends(['is_manager']) // переопределяет appends!
//    ;

//    return \App\User::whereHas('tasks', function ($query) {
//        $query->where('type', 'old');
//    }, '>', 1)->with('tasks')->get();

//    return \App\User::whereDoesntHas('tasks', function ($query) {
//        $query->where('type', 'old');
//    }, '>', 1)->with('tasks')->get();

//    return \App\User::withCount('tasks')->get();

//    return \App\User::withCount(['tasks as all_tasks', 'tasks' => function ($query) {
//        $query->new();
//    }])->get();

//    return \App\User::has('tasks')->with(['tasks:id,title,owner_id'])->get();

//    return \App\User::has('tasks')->with(['tasks' => function ($query) {
//        $query->select(['id', 'title', 'owner_id'])->new();
//    }])->get();

    $users = \App\User::all();
    return $users->load('tasks');
});
