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
    Route::post('/work_in', [TimeController::class, 'startWork']);
    Route::get('/attendance', [TimeController::class, 'attendance']);
});
