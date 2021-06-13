<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tickets')->group(function () {
    Route::get('/', 'TicketController@index');
    Route::get('/using', 'TicketController@inUse');
    Route::post('/', 'TicketController@store');
    Route::patch('/{ticket}', 'TicketController@update');
});

Route::prefix('parks')->group(function () {
    Route::get('/q', 'ParkController@qs');
    Route::get('/q/{park}', 'ParkController@inQ');
    Route::post('/q/{park}', 'ParkController@q');
    Route::get('/{type}', 'ParkController@index');
});

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::middleware('auth:sanctum')->post('/logout', 'AuthController@logout');