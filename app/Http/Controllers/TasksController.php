<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Tag;
use App\Task;
use Illuminate\Support\Collection;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:update,task')->except(['index', 'store', 'create']);
    }

    public function index()
    {
        $tasks = auth()->user()->tasks()->with('tags')->latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $attributes['owner_id'] = auth()->id();

        $task = Task::create($attributes);

        flash('Задача успешно создана');

//        event(new TaskCreated($task));

        return redirect('/tasks');
    }

    public function edit(Task $task)
    {
        // abort_if
        // abort_unless

        // abort_if(\Gate::denies('update', $task), 403)
        // abort_unless(\Gate::allows('update', $task), 403)

        // abort_if(auth()->user()->cannot('update', $task), 403)
        // abort_unless(auth()->user()->can('update', $task), 403)

//        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Task $task)
    {
        $attributes = request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $task->update($attributes);

        /** @var Collection $taskTags */
        $taskTags = $task->tags->keyBy('name');
        $tags = collect(explode(', ', request('tags')))->keyBy(function ($item) { return $item; });

//        $tagsToAttach = $tags->diffKeys($taskTags);
//        $tagsToDetach = $taskTags->diffKeys($tags);

//        foreach ($tagsToAttach as $tag) {
//            $tag = Tag::firstOrCreate(['name' => $tag]);
//            $task->tags()->attach($tag);
//        }
//
//        foreach ($tagsToDetach as $tag) {
//            $task->tags()->detach($tag);
//        }

        $syncIds = $taskTags->intersectByKeys($tags)->pluck('id')->toArray();
        $tagsToAttach = $tags->diffKeys($taskTags);

        foreach ($tagsToAttach as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $syncIds[] = $tag->id;
        }

        $task->tags()->sync($syncIds);

        flash('Задача успешно обновлена');

        return redirect('/tasks');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        flash('Задача удалена', 'warning');

        return redirect('tasks');
    }
}
