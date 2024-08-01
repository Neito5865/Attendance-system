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
        $existingTimestamp = Timestamp::where('user_id', $user->id)->where('status', 2)->whereNull('work_out')->first();

        if($existingTimestamp){
            return redirect('/')->with('error', 'すでに勤務を開始しています');
        }

        Timestamp::create([
            'user_id' => $user->id,
            'work_in' => Carbon::now(),
            'status' => 2,
        ]);
        return redirect('/')->with('message', '勤務を開始しました');
    }

    public function workOut(Request $request){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)
        ->where(function($query){
            $query->where('status', 2)->orWhere('status', 3);
        })->latest()->first();

        if($timestamp){
            $workOutTime = Carbon::now();

            $breaks = $timestamp->breakstamps()->whereNull('break_out')->get();
            foreach($breaks as $break){
                $break->update([
                    'break_out' => $workOutTime,
                ]);
            }

            $timestamp->update([
            'work_out' => $workOutTime,
            'status' => 1,
            ]);

            return redirect('/')->with('message', '勤務を終了しました');
        }
        return redirect('/')->with('error', '勤務中ではないため、勤務終了の操作ができません');
    }

    public function breakIn(Request $request){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)->where('status', 2)->latest()->first();

        if($timestamp){
            Breakstamp::create([
                'timestamp_id' => $timestamp->id,
                'break_in' => Carbon::now(),
            ]);

            $timestamp->update([
                'status' => 3,
            ]);

            return redirect('/')->with('message', '休憩を開始しました');
        }
        return redirect('/')->with('error', '勤務中ではないため、休憩開始の操作ができません');
    }

    public function breakOut(Request $request){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)->where('status', 3)->latest()->first();

        if($timestamp){
            $break = Breakstamp::where('timestamp_id', $timestamp->id)->whereNull('break_out')->latest()->first();

            if($break){
                $break->update([
                    'break_out' => Carbon::now(),
                ]);
                $timestamp->update([
                    'status' => 2,
                ]);
                return redirect('/')->with('message', '休憩を終了しました');
            }

            return redirect('/')->with('error', '休憩開始されていません');
        }
        return redirect('/')->with('error', '勤務中ではないため、休憩終了の操作ができません');
    }

    public function attendance(Request $request){
        $date = $request->query('date', Carbon::today()->toDateString());
        $attendances = Timestamp::whereDate('work_in', $date)->with('user')->paginate(5);
        return view('attendance', compact('date', 'attendances'));
    }

    public function attendanceList(Request $request){
        $date = $request->query('date', Carbon::today()->toDateString());
        $users = User::paginate(10); // ユーザーのリストを取得（必要に応じて調整）
        $attendances = Timestamp::whereBetween('work_in', [
            Carbon::parse($date)->startOfMonth()->toDateString(),
            Carbon::parse($date)->endOfMonth()->toDateString()
        ])->get();
        return view('attendance-list', compact('date', 'users', 'attendances'));
    }
}
