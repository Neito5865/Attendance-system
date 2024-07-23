<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeController;

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

Route::middleware('auth')->group(function(){
    Route::get('/', [TimeController::class, 'stamp']);
    Route::post('/work_in', [TimeController::class, 'workIn']);
    Route::post('/work_out', [TimeController::class, 'workOut']);
    Route::post('/break_in', [TimeController::class, 'breakIn']);
    Route::post('/break_out', [TimeController::class, 'breakOut']);
    Route::get('/attendance', [TimeController::class, 'attendance'])->name('attendance');
});
