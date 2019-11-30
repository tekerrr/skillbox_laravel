<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Task;

class TaskStepsController extends Controller
{
    public function store(Task $task)
    {
        $step = $task->addStep(request()->validate([
            'description' => 'required|min:5',
        ]));

        $tagsToAttach = collect(explode(', ', request('tags')))->keyBy(function ($item) { return $item; });

        $syncIds = [];

        foreach ($tagsToAttach as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $syncIds[] = $tag->id;
        }

        $step->tags()->sync($syncIds);

        return back();
    }

//    public function update(Step $step)
//    {
//        $method = request()->has('completed') ? 'complete' : 'incomplete';
//        $step->{$method}(); // динамический вызов метода
//
//        return back();
//    }
}
