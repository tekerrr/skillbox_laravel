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

Route::get('/test1', function () {
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

Route::get('/test2', function () {
//    \DB::connection('other')->select();
//    \DB::connection('other')->getPdo();
//    dd(\DB::select('select * from users where id = ?', [1]));

//    \DB::transaction(function () {
//        // query 1
//        // query 2
//        // query 3
//    });
//
//    \DB::beginTransaction();
//
//    \DB::rollBack();
//
//    \DB::commit();

//    $tasks = \DB::table('tasks')->first();
//    $tasks = \DB::table('tasks')->where('id', 2)->value('title');
//    $tasks = \DB::table('tasks')->pluck('title', 'id');

//    $tasks = \DB::table('tasks')
//        ->orderBy('id')
////        ->chunk(2, function ($tasks) {
//        ->chunkById(2, function ($tasks) { // в случае изменения, обновления
//            dump($tasks);
////            return false;
//        })
//    ;

//    $tasks = \DB::table('tasks')->count();
//    $tasks = \DB::table('tasks')->max('id');
//    $tasks = \DB::table('tasks')->average('id');

//    $tasks = \DB::table('tasks')->where('title', '12345')->exists();
//    $tasks = \DB::table('tasks')->where('title', '12345')->doesntExist();

//    $tasks = \DB::table('tasks')->select('title', 'body')->get();
//    $tasks = \DB::table('tasks')->select('title')->addSelect('type')->get();
//    $tasks = \DB::table('tasks')->select('type')->distinct()->get();
//    $tasks = \DB::table('tasks')->select(\DB::raw('count(*) as task_count, type'))->groupBy('type')->get();
//    $tasks = \DB::table('tasks')
//        ->selectRaw('id * ? as big_id', [10])
//        ->get();
//    $tasks = \DB::table('tasks')
//        ->whereRaw('type = IF(id < 3, ?, "New")', ['Old'])
//        ->get();
//    $tasks = \DB::table('tasks')
//        ->select(\DB::raw('count(*) as task_count, type'))
//        ->groupBy('type')
//        ->havingRaw('count(*) > ?', [1])
//        ->get()
//    ;
//    $tasks = \DB::table('tasks')
//        ->orderByRaw('updated_at - created_at')
//        ->get()
//    ;

//    $users = \DB::table('users')
//        ->join('tasks', 'users.id', '=', 'tasks.owner_id')
////        ->leftJoin('tasks', 'users.id', '=', 'tasks.owner_id')
////        ->rightJoin('tasks', 'users.id', '=', 'tasks.owner_id')
////        ->crossJoin('tasks', 'users.id', '=', 'tasks.owner_id')
//        ->join('companies', 'users.id', '=', 'companies.owner_id')
//        ->select('users.id', 'users.email', 'tasks.title', 'companies.name')
//        ->get()
//    ;

//    $latestTask = DB::table('tasks')
//        ->select('owner_id', DB::raw('MAX(updated_at) as last_task_updated_at'))
//        ->where('completed', false)
//        ->groupBy('owner_id')
//    ;
//
//    $users = DB::table('users')
//        ->joinSub($latestTask, 'latest_completed_task', function ($join) {
//            $join->on('users.id', '=', 'latest_completed_task.owner_id');
//        })
//        ->get()
//    ;

//    $firstUser = DB::table('users')->where('id', 1);
//    $users = DB::table('users')
//        ->where('id', 2)
//        ->union($firstUser)
//        ->get()
//    ;

//    $tasks = DB::table('tasks')
//        ->where('type', 'old')
//        ->where('type', '=', 'old')
//        ->where('type', '<>', 'old')
//        ->where('type', '<', 'old')
//        ->where('type', '<=', 'old')
//        ->where('type', '>', 'old')
//        ->where('type', '>=', 'old')
//        ->where('type', 'like', '%e%')
//        ->where([
//            ['type', 'new'],
//            ['completed', '<>', true],
//        ])
//        ->where('type', 'new')->orWhere('type', 'old')
//        ->whereBetween('id', [2, 4])
//        ->whereNotBetween('id', [2, 4])
//        ->whereIn('id', [1, 3, 5])
//        ->whereNotIn('id', [1, 3, 5])
//        ->whereNull('options')
//        ->whereNotNull('options')
//        ->whereDate('created_ad', '2019-01-01')
//        ->whereMonth('created_ad', '12')
//        ->whereDay('created_ad', '31')
//        ->whereYear('created_ad', '2007')
//        ->whereTime('created_ad', '11:22:33')
//        ->whereColumn('updated_at', '>', 'created_at')
//        ->where('type', 'new')->orWhere(function ($query) {
//            $query
//                ->where('type', '<>', 'new')
//                ->where('completed', true)
//            ;
//        })
//        ->whereExists(function ($query) {
//            //
//        })
//        ->where('options->lang', 'ru') // Json
//        ->whereJsonContains('options->lang', 'ru') // Json
//        ->whereJsonLength('options->lang', '>', 1) // Json
//        ->get()
//    ;

//    $tasks = DB::table('tasks')
//        ->orderBy('title', 'asc')
//        ->orderBy('title', 'desc')
//        ->orderByDesc('title')
//        ->latest()
//        ->oldest()
//        ->inRandomOrder()
//        ->get()
//    ;

//    $tasks = DB::table('tasks') // TODO разобраться!
//        ->groupBy('id')
//        ->having('id', '>', 3)
//        ->select('id', 'type')
//        ->get()
//    ;

//    $tasks = DB::table('tasks')
//        ->skip(2) // offset()
//        ->take(2) // limit()
//        ->get()
//    ;

    $tasks = DB::table('tasks')
        ->when(\request()->has('old'), function ($query) {
            $query->where('type', 'old');
        }, function ($query) {
            // при невыполнении условия
        })
        ->get()
    ;

//    $tasks = DB::table('companies')
////        ->insert([
////            ['name' => 'new Company 1', 'owner_id' => 1],
////            ['name' => 'new Company 2', 'owner_id' => 1],
////            ['name' => 'new Company 3', 'owner_id' => 1],
////        ])
//        ->insertGetId(['name' => 'new Company 1', 'owner_id' => 1])
//    ;

//    $tasks = DB::table('companies')
////        ->update(['owner_id' => 2])
////        ->updateOrInsert(['name' => 'Test'], ['owner_id' => 2])
////        ->where('id', 1)->update(['options->color' => 'red'])
////        ->where('id', 1)->increment('field', 2)
//        ->where('id', 1)->decrement('field', 2)
//    ;

//    $tasks = DB::table('companies')
//        ->where('id', '>=', 2)
//        ->delete()
//    ;

//    $tasks = DB::table('companies')
//        ->where('id', '>=', 2)
//        ->sharedLock()
//        ->get()
//    ;
//
//    $tasks = DB::table('companies')
//        ->where('id', '>=', 2)
//        ->lockForUpdate()
//        ->update([])
//    ;

//    $tasks = DB::table('tasks')
////        ->paginate(2)
//        ->simplePaginate(2)
//    ;

    $images = \App\Image::with('imageable') // TODO подумать!!
        ->get()
        ->loadMorph('imageable', [
            \App\User::class => ['company', 'tasks'],
            \App\Company::class => ['user'],

        ])
        ->toArray()
    ;

    dump($images);
});

Route::get('/test3', function () {
    \App\Jobs\CompetedTasksReport::dispatch();
    \App\Jobs\CompetedTasksReport::dispatch(\App\User::first())
        ->onQueue('reports')
    ;
//
//    dispatch(function () {
//        echo 'Hello';
//    });
});

Route::get('/test4', function () {
    event(new \App\Events\SomethingHappens('Мы настроили WS-соединение!'));
});

Route::post('/chat', function () {
    broadcast(new \App\Events\ChatMessage(request('message'), auth()->user()))->toOthers();
})->middleware('auth');

Route::get('/test', function () {
//    Cache::put('key', 200, 10);
//    $value = Cache::get('key');

//    $count = Cache::remember('task_count', 3600, function () {
//        return \App\Task::count();
//    });
//    dump($count);
//
//    $count = Cache::rememberForever('task_count', function () {
//        return \App\Task::count();
//    });
//
//    $value = Cache::pull('key');
//    Cache::put('key', 'value', $secons ?? 10);
//    Cache::add('key', 'value', $secons ?? 10);
//    Cache::forget('key');
//    Cache::flush();
//
//    dump($count);

//    $lock = Cache::lock('foo', 10);
//
//    if ($lock->get()) {

//
//        $lock->release();
//    }

//    Cache::lock('foo', 10)->get(function () {
//
//    });

//    $lock = Cache::lock('foo', 10);
//
//    try {
//        $lock->block(5);
//    } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
//        //
//    } finally {
//        optional($lock)->release();
//    }

//    Cache::lock('foo', 10)->block(5, function () {
//        //
//    });

//    // Controller
//    $task = \App\Task::find($id);
//    $lock = Cache::lock('foo', 120);
//
//    if ($result = $lock->get()) {
//        ProcessTask::dispatch($task, $lock->ownre());
//    }
//
//    // ProcessTask Job
//    Cache::restoreLock('foo', $this->owner)->release();
//
//    Cache::lock('foo')->forceRelease();

//    cache()->remember('foo', 10, function () {return 'test';});

//    Cache::tags(['people', 'artists'])->put('John', 'John', 3600);
//    Cache::tags(['people', 'authors'])->put('Anne', 'Anne', 3600);
//
//    Cache::tags(['people', 'artists'])->get('John');
//    Cache::tags(['people', 'authors'])->get('Anne');
//
//    $john = Cache::tags(['people', 'authors'])->remember('John', 3600, function () {
//        return 'John';
//    });
//
//    Cache::tags(['people'])->flush();

});
