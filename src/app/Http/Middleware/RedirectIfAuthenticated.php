<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // ユーザーが認証済みであり、かつメール認証が完了していない場合
                if (!$user->hasVerifiedEmail()) {
                    // 現在のルートが /login の場合、ユーザーをログアウトさせてリダイレクト
                    if ($request->routeIs('login')) {
                        Auth::guard($guard)->logout(); // ログアウト処理
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();

                        return redirect('/login');
                    }

                    // /email/verify など、特定のページにアクセスを許可する
                    return redirect('/email/verify');
                }

                // 認証済みで、メール認証も完了している場合はホームページへリダイレクト
                return redirect(RouteServiceProvider::HOME);
            }
        }
        return $next($request);
    }
}
