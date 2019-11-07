<?php


namespace App\Http\Controllers;


use App\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();

        return view('admin.feedback', compact('feedbacks'));
    }

    public function store()
    {
        $this->validate(request(), [
            'email' => 'email',
            'body'  => 'required',
        ]);

        Feedback::create(request()->all());

        flash('Сообщение отправлено');

        return redirect('/contacts');
    }
}
