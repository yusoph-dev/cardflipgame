<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PlayerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(PlayerController::class)->group(function () {
    Route::get('/rankings', 'getRankings');
    Route::get('/session', 'getSession');
    Route::post('/postplayer', 'postPlayer');
    Route::post('/postSession', 'postSession');
});