<?php


namespace App\Http\Controllers;


use App\Feedback;

class FeedbackController extends Controller
{
    public function store()
    {
        $attributes = request()->validate([
            'email' => 'email',
            'body'  => 'required',
        ]);

        Feedback::create($attributes);

        flash('Сообщение отправлено');

        return back();
    }
}
