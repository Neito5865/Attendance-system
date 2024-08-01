@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance-list.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="date-nav">
        <button class="date-nav__button">
            <a class="date-nav__link" href="{{route('attendance-list', ['date' => \Carbon\Carbon::parse($date)->subMonth()->toDateString()])}}">＜</a>
        </button>
        <div class="date-nav__date">{{\Carbon\Carbon::parse($date)->format('Y年m月')}}</div>
        <button class="date-nav__button">
            <a class="date-nav__link" href="{{route('attendance-list', ['date' => \Carbon\Carbon::parse($date)->addMonth()->toDateString()])}}">＞</a>
        </button>
    </div>
    <div class="attendance-list-table">
        <table class="attendance-list-table__inner">
            <tr class="attendance-list-table__row">
                <th class="attendance-list-table__heading">名前</th>
                @for($i = 1; $i <= \Carbon\Carbon::parse($date)->daysInMonth; $i++)
                    <th class="attendance-list-table__heading">{{\Carbon\Carbon::parse($date)->format('n')}}/{{$i}}</th>
                @endfor
            </tr>
            @foreach ($users as $user)
                <tr class="attendance-list-table__row">
                    <td class="attendance-list-table__item">{{ $user->name }}</td>
                    @for ($i = 1; $i <= \Carbon\Carbon::parse($date)->daysInMonth; $i++)
                        @php
                            $currentDate = \Carbon\Carbon::parse($date)->startOfMonth()->addDays($i - 1)->toDateString();
                            $attendance = $attendances->first(function($att) use ($user, $currentDate) {
                                return $att->user_id == $user->id && \Carbon\Carbon::parse($att->work_in)->toDateString() == $currentDate;
                            });
                        @endphp
                        <td class="attendance-list-table__item">{{ $attendance ? '○' : '×' }}</td>
                    @endfor
                </tr>
            @endforeach
        </table>
    </div>
    <div class="attendance-list-paginate">
        {{$users->appends(['date' => $date])->links()}}
    </div>
</div>

@endsection
