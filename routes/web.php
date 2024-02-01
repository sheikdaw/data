<?php

use Illuminate\Support\Facades\Route;
use AApp\Https\Controllers\HomeController;
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
})->name('/');
Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');

Route::get("/gisid/{id}/id", [HomeController::class, 'show']);

