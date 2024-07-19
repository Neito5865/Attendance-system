@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection

@section('content')
<div class="register__content">
    <div class="register__heading">
        <h2>
            会員登録
        </h2>
    </div>
    <form class="register-form" action="/register" method="post">
    @csrf
        <div class="register-form__group">
            <div class="register-form__input">
                <input type="text" name="name" value="{{old('name')}}" placeholder="名前">
            </div>
            <div class="register-form__error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="register-form__group">
            <div class="register-form__input">
                <input type="email" name="email" value="{{old('email')}}" placeholder="メールアドレス">
            </div>
            <div class="register-form__error">
                @error('email')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="register-form__group">
            <div class="register-form__input">
                <input type="password" name="password" placeholder="パスワード">
            </div>
            <div class="register-form__error">
                @error('password')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="register-form__group">
            <div class="register-form__input">
                <input type="password" name="password_confirmation" placeholder="確認用パスワード">
            </div>
            <div class="register-form__error">
                @error('password')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="register-form__button">
            <input class="register-form__button-submit" type="submit" value="会員登録">
        </div>
    </form>
    <div class="register__login-link">
        <p class="register__login-link--text">アカウントをお持ちの方はこちらから</p>
        <a href="/login" class="register__login-link--item">ログイン</a>
    </div>
</div>

@endsection
