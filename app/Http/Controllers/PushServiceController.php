<?php

namespace App\Http\Controllers;

use App\Service\Pushall;
use Illuminate\Http\Request;

class PushServiceController extends Controller
{
    public function form()
    {
        return view('service');
    }

    public function send()
    {
        $data = \request()->validate([
            'title' => 'required|max:80',
            'text'  => 'required|max:500',
        ]);

        push_all($data['title'], $data['text']);

        flash('Push-уведомление успешно отправлено');

        return back();
    }
}
