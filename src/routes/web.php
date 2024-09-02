<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/email/verify', function(){
//     return view('auth.verify-email');
// })->name('verification.notice');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/', [TimeController::class, 'stamp']);
    Route::post('/work_in', [TimeController::class, 'workIn']);
    Route::post('/work_out', [TimeController::class, 'workOut']);
    Route::post('/break_in', [TimeController::class, 'breakIn']);
    Route::post('/break_out', [TimeController::class, 'breakOut']);
    Route::get('/attendance', [TimeController::class, 'attendance'])->name('attendance');
    Route::get('/attendance-list', [TimeController::class, 'attendanceList'])->name('attendance-list');
});
