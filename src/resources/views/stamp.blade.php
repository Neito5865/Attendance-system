@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/stamp.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="time-message">
        <p class="time-message__text">
            ユーザーさんお疲れ様です！
        </p>
    </div>
    <form class="time-form" action="" method="">
        <div class="time-form__content">
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="勤務開始">
            </div>
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="勤務終了">
            </div>
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="休憩開始">
            </div>
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="休憩終了">
            </div>
        </div>
    </form>
</div>

@endsection
