<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BreedController;

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

Route::post('/user/{user}/associate', UserController::class);
Route::post('/park/{park}/breed', ParkController::class);
Route::get('/breeds/random', [BreedController::class, 'showRandom']);
Route::get('/breeds/{breed}/image', [BreedController::class, 'showImage']);
Route::resource('/breeds', BreedController::class);
