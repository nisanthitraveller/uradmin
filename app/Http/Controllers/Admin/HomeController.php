<?php

namespace App\Http\Controllers\Admin;
use App\Email;
class HomeController
{
    public function index()
    {
        return view('home');
    }
    
    public function emails()
    {
        $emails = Email::orderBy('id', 'desc')->with('user')->get();
        return view('admin.emails', compact('emails'));
        //return view('home');
    }
}
