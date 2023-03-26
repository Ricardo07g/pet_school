<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $payload = array();

        return view('/login/index');
    }

    public function inicio()
    {
        $payload = array();

        return view('/home/inicio');
    }
}
