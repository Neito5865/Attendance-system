@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/stamp.css')}}">
@endsection

@section('content')
<div class="stamp__akert">
    @if(session('message'))
    <div class="stamp__alert--success">
        {{session('message')}}
    </div>
    @endif
</div>
<div class="content">
    <div class="time-message">
        @if(Auth::check())
        <p class="time-message__text">
            {{Auth::user()->name}}さんお疲れ様です！
        </p>
        @endif
    </div>
    <div class="time-form__content">
        <form class="time-form" action="/work_in" method="post">
        @csrf
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="勤務開始" {{ $timestamp->status == 2 || $timestamp->status == 3 ? 'disabled' : '' }}>
            </div>
        </form>
        <form class="time-form" action="/time_out" method="post">
        @csrf
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="勤務終了" {{ $timestamp->status == 1 ? 'disabled' : '' }}>
            </div>
        </form>
        <form class="time-form" action="/break_in" method="post">
        @csrf
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="休憩開始" {{ $timestamp->status == 1 || $timestamp->status == 3 ? 'disabled' : '' }}>
            </div>
        </form>
        <form class="time-form" action="/break_out" method="post">
        @csrf
            <div class="time-form__button">
                <input class="time-form__button-submit" type="submit" value="休憩終了" {{ $timestamp->status == 1 || $timestamp->status == 2 ? 'disabled' : '' }}>>
            </div>
        </form>
    </div>
</div>

@endsection
