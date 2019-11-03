<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{


    /**
     * TestController constructor.
     */
    public function __construct()
    {
        $this->middleware('test' , ['only' => 'index']);
    }

    function index()
    {
        return 'hello';
    }
}
