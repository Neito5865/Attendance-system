@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="date">日付</div>
    <div class="attendance-table">
        <table class="attendance-table__inner">
            <tr class="attendance-table__row">
                <th class="attendance-table__heading">名前</th>
                <th class="attendance-table__heading">勤務開始</th>
                <th class="attendance-table__heading">勤務終了</th>
                <th class="attendance-table__heading">休憩時間</th>
                <th class="attendance-table__heading">勤務時間</th>
            </tr>
            <tr class="attendance-table__row">
                <td class="attendance-table__item">テスト太郎</td>
                <td class="attendance-table__item">10:00:00</td>
                <td class="attendance-table__item">20:00:00</td>
                <td class="attendance-table__item">00:30:00</td>
                <td class="attendance-table__item">09:30:00</td>
            </tr>
            <tr class="attendance-table__row">
                <td class="attendance-table__item">テスト太郎</td>
                <td class="attendance-table__item">10:00:00</td>
                <td class="attendance-table__item">20:00:00</td>
                <td class="attendance-table__item">00:30:00</td>
                <td class="attendance-table__item">09:30:00</td>
            </tr>
            <tr class="attendance-table__row">
                <td class="attendance-table__item">テスト太郎</td>
                <td class="attendance-table__item">10:00:00</td>
                <td class="attendance-table__item">20:00:00</td>
                <td class="attendance-table__item">00:30:00</td>
                <td class="attendance-table__item">09:30:00</td>
            </tr>
        </table>
    </div>

</div>

@endsection
