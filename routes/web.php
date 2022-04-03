<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $path = public_path('ukraine_cities.json');
    $data = json_decode(file_get_contents($path), true); 
    dump($data[0]['city']);
    return "<h1>This is a test page.</h1>";
});