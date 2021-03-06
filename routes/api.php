<?php

use App\Http\Controllers\TwitterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UkraineCityController;
use  App\Http\Controllers\UkraineWebScraperController;
use App\Http\Controllers\RedditController;

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

Route::get('/ukraineWebScraper', [UkraineWebScraperController::class, 'index']);
Route::get('/ukraineWebScraper/tweets', [UkraineWebScraperController::class, 'twitter']);

//TWITTER APIS
Route::group(['prefix' => 'twitter'], function () {

    Route::get('/getTrends', [TwitterController::class, 'trends']);
    Route::post('/getTweets', [TwitterController::class, 'getTweetsByTrends']);
    Route::post('/geoDecode', [TwitterController::class, 'geoDecoder']);
    Route::post('/tweetsByCity', [TwitterController::class, 'getTweetsByCities']);
    Route::post('/tweetsByGeo', [TwitterController::class, 'getTweetsByGeo']);

});

//FACEBOOK APIS

//REDDIT APIS
Route::group(['prefix' => 'reddit'], function () {

    Route::get('/getReddit', [RedditController::class, 'index']);

});

