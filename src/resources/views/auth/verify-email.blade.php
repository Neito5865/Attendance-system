@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/verify-email.css')}}">
@endsection

@section('content')
<div class="verify__content">
    <div class="verify__heading">
        <h2>
            認証メールを送信しました
        </h2>
    </div>
    <div class="verify__text">
        <p>登録メールアドレスに届いたメール本文内の<br>
        URLへアクセスし、認証を完了してください。</p>
    </div>
    <form class="verify-form" action="/email/verification-notification" method="post">
    @csrf
        <div class="">
            <input type="submit" value="認証メール再送信">
        </div>
    </form>
</div>
@endsection
