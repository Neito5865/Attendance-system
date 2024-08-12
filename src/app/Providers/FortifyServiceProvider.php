<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Http\Requests\LoginRequest;
use Laravel\Fortify\Http\Requests\RegisterRequest as FortifyRegisterRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::registerView(function(){
            return view('auth.register');
        });

        Fortify::createUsersUsing(RegisterRequest::class);

        Fortify::loginView(function(){
            return view('auth.login');
        });

        RateLimiter::for('login', function(Request $request){
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);

        $this->app->bind(FortifyRegisterRequest::class, RegisterRequest::class);
    }
}
