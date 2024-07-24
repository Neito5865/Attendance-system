@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="date-nav">
        <button class="date-nav__button">
            <a class="date-nav__link" href="{{route('attendance', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()])}}">＜</a>
        </button>
        <div class="date-nav__date">{{$date}}</div>
        <button class="date-nav__button">
            <a class="date-nav__link" href="{{route('attendance', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()])}}">＞</a>
        </button>
    </div>
    <div class="attendance-table">
        <table class="attendance-table__inner">
            <tr class="attendance-table__row">
                <th class="attendance-table__heading">名前</th>
                <th class="attendance-table__heading">勤務開始</th>
                <th class="attendance-table__heading">勤務終了</th>
                <th class="attendance-table__heading">休憩時間</th>
                <th class="attendance-table__heading">勤務時間</th>
            </tr>
            @foreach($attendances as $attendance)
            <tr class="attendance-table__row">
                <td class="attendance-table__item">{{$attendance->user->name}}</td>
                <td class="attendance-table__item">{{$attendance->work_in ? \Carbon\Carbon::parse($attendance->work_in)->format('H:i:s') : '-'}}</td>
                <td class="attendance-table__item">{{$attendance->work_out ? \Carbon\Carbon::parse($attendance->work_out)->format('H:i:s') : '-'}}</td>
                <td class="attendance-table__item">{{$attendance->break_time}}</td>
                <td class="attendance-table__item">{{$attendance->work_time}}</td>
            </tr>
            @endforeach
        </table>
    </div>

</div>

@endsection
