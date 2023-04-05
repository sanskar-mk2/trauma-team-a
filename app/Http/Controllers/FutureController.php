<?php

namespace App\Http\Controllers;

class FutureController extends Controller
{
    public function login()
    {
        return view('futures.login');
    }

    public function index()
    {
        return view('futures.index');
    }

    public function newEval()
    {
        return view('futures.new-eval');
    }
}
