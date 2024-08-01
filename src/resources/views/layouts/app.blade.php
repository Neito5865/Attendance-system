<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Atte</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <h1 class="header__logo">Atte</h1>
                <nav class="nav">
                    <ul class="header-nav">
                        @if(Auth::check())
                        <li class="header-nav__item">
                            <a href="/" class="header-nav__link">ホーム</a>
                        </li>
                        <li class="header-nav__item">
                            <a href="/attendance" class="header-nav__link">日付一覧</a>
                        </li>
                        <li class="header-nav__item">
                            <a href="/attendance-list" class="header-nav__link">勤怠管理一覧</a>
                        </li>
                        <li class="header-nav__item">
                            <form action="/logout" method="post">
                            @csrf
                                <input class="header-nav__button" type="submit" value="ログアウト">
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__innner">
            <div class="footer-utilities">
                <small class="footer-small__text">Atte, inc</small>
            </div>
        </div>
    </footer>
</body>
</html>
