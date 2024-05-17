<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('leads', LeadController::class)->middleware('jwt.auth');

Route::resource('orders', OrderController::class)->middleware('jwt.auth');
Route::post('orders/edit/addFiles/{id}', [OrderController::class, 'addFiles'])->middleware('jwt.auth');

Route::resource('clientBases', ClientBaseController::class)->middleware('jwt.auth');
Route::post('clientBases/edit/addComment/{id}', [ClientBaseController::class, 'addComment'])->middleware('jwt.auth');

