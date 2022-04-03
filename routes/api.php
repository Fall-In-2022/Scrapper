<?php

use App\Http\Controllers\TwitterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UkraineCityController;

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

Route::apiResource('ukraineCities', UkraineCityController::class);

//TWITTER APIS
Route::group(['prefix' => 'twitter'], function () {

    Route::get('/getTrends', [TwitterController::class, 'trends']);
    Route::get('/getTweets', [TwitterController::class, 'getTweetsByTrends']);

});

//FACEBOOK APIS

//REDDIT APIS

