@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')
<div class="login__content">
    <div class="login__heading">
        <h2>
            ログイン
        </h2>
    </div>
    <form class="login-form" action="/login" method="post">
    @csrf
        <div class="login-form__group">
            <div class="login-form__input">
                <input type="email" name="email" value="{{old('email')}}" placeholder="メールアドレス">
            </div>
            <div class="login-form__error">
                @error('email')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="login-form__group">
            <div class="login-form__input">
                <input type="password" name="password" placeholder="パスワード">
            </div>
            <div class="login-form__error">
                @error('password')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="login-form__button">
            <input class="login-form__button-submit" type="submit" value="ログイン">
        </div>
    </form>
    <div class="login__login-link">
        <p class="login__register-link--text">アカウントをお持ちでない方はこちらから</p>
        <a href="/register" class="login__register-link--item">会員登録</a>
    </div>
</div>
@endsection
