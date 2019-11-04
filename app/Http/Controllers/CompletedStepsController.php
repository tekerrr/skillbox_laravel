<?php

namespace App\Http\Controllers;

use App\Notifications\TaskStepCompleted;
use App\Step;

class CompletedStepsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('can:update,step'); // StepPolicy
    }

    public function store(Step $step)
    {
        $step->complete();

        $step->task->owner->notify(new TaskStepCompleted());

        return back();
    }

    public function destroy(Step $step)
    {
        $step->incomplete();
        return back();
    }
}
