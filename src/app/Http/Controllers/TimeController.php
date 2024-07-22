<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Timestamp;
use App\Models\Breakstamp;

class TimeController extends Controller
{
    public function stamp(){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)->latest()->first();
        if(!$timestamp){
            $timestamp = new Timestamp([
                'user_id' => $user->id,
                'status' => 1,
            ]);
        }
        return view('stamp', compact('timestamp'));
    }

    public function workIn(Request $request){
        $user = Auth::user();
        Timestamp::create([
            'user_id' => $user->id,
            'work_in' => Carbon::now(),
            'status' => 2,
        ]);
        return redirect('/')->with('message', '勤務を開始しました');
    }

    public function workOut(Request $request){

        return redirect('/')->with('message', '勤務を終了しました');
    }

    public function breakIn(Request $request){
        return redirect('/')->with('message', '休憩を開始しました');
    }

    public function breakOut(Request $request){
        return redirect('/')->with('message', '休憩を終了しました');
    }

    public function attendance(){
        return view('attendance');
    }
}
