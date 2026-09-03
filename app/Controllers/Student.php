<?php

namespace App\Controllers;

class Student extends BaseController
{
    public function dashboard()
    {
        return view('student/dashboard');
    }

    public function library()
    {
        return view('student/library');
    }

    public function planner()
    {
        return view('student/planner');
    }

    public function chatbot()
    {
        return view('student/chatbot');
    }

    public function profile()
    {
        return view('student/profile');
    }
}