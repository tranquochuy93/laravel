<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FreeTrialController;
use App\Http\Controllers\api\KeyAdsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[UserController::class, 'login'])->name('login');
Route::post('register', [UserController::class, 'register']);
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('details', [UserController::class, 'details']);
});

Route::group(['prefix'=>'/free-trial'], function() {
    Route::post('/create', [FreeTrialController::class, 'create']);
    Route::post('/update', [FreeTrialController::class, 'update']);
});

Route::group(['prefix'=>'/key-ads'], function() {
    Route::post('/detail', [KeyAdsController::class, 'detail']);
});