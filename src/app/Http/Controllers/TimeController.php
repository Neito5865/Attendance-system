<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Timestamp;

class TimeController extends Controller
{
    public function stamp(){
        return view('stamp');
    }

    public function startWork(Request $request){
        $today = Carbon::today();
        $user = Auth::user();
        Timestamp::create(
            //
        );
        return redirect('/')->with('message', '出勤しました');
    }

    public function attendance(){
        return view('attendance');
    }
}
