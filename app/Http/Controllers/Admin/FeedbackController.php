<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Http\Controllers\Controller;
use App\Service\TaggedCache;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = TaggedCache::feedbacks()->remember('admin.feedbacks', function () {
            return Feedback::latest()->get();
        });

        return view('admin.feedback', compact('feedbacks'));
    }
}
