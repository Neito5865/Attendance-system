<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function stamp(){
        return view('stamp');
    }

    public function attendance(){
        return view('attendance');
    }
}
