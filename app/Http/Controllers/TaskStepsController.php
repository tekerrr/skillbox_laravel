<?php

namespace App\Http\Controllers;

use App\Step;
use App\Task;
use Illuminate\Http\Request;

class TaskStepsController extends Controller
{
    public function store(Task $task)
    {
        $task->addStep(request()->validate([
            'description' => 'required|min:5',
        ]));

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
