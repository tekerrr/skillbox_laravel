<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $attributes = $this->validate($request, ['body' => 'required']);
        $attributes['owner_id'] = auth()->id();

        $request->input('commentable_type')::find($request->input('commentable_id'))
            ->comments()
            ->create($attributes)
        ;

        return back();
    }
}
