@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/verify-email.css')}}">
@endsection

@section('content')
<div class="verify__content">
    <div class="verify__heading">
        {{ __('Verify Your Email Address') }}
    </div>
    <div class="verify__text">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="verify-form" method="POST" action="{{ route('verification.send') }}">
        @csrf
            <input class="verify-submit" type="submit" value="{{ __('click here to request another') }}">
        </form>
    </div>
</div>
@endsection
