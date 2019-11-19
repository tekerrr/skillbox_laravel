<?php


namespace App\Http\Controllers;


use App\Feedback;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except('store');
    }

    public function index()
    {
        $feedbacks = Feedback::latest()->get();

        return view('admin.feedback', compact('feedbacks'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'email',
            'body'  => 'required',
        ]);

        Feedback::create($attributes);

        flash('Сообщение отправлено');

        return redirect('/contacts');
    }
}
