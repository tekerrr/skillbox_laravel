<?php

namespace App\Http\Controllers;

use App\Step;

class CompletedStepsController extends Controller
{
    public function store(Step $step)
    {
        $step->complete();
        return back();
    }

    public function destroy(Step $step)
    {
        $step->incomplete();
        return back();
    }
}
