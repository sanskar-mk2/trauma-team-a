<?php

use App\Http\Controllers\FutureController;
use App\Http\Controllers\ProjectController;
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

Route::resource('projects', ProjectController::class);
Route::group(['prefix' => 'futures'], function () {
    Route::get('login', [FutureController::class, 'login']);
    Route::get('index', [FutureController::class, 'index']);
    Route::get('new-eval', [FutureController::class, 'newEval']);
});
