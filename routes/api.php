<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignerController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signUp']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group([
    'prefix' => 'signer',
    'middleware' => 'auth:api'
], function () {
    Route::get('obtain-contracts', [SignerController::class, 'obtainContracts']);
    Route::post('sign-and-send', [SignerController::class, 'signAndSend']);
});