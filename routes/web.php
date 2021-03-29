<?php

use App\Http\Controllers\ReceptionistController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/home', function () {
    return view('layouts.admin');
});
Route::group(['middleware' => 'auth'],function () {
    Route::prefix("receptionist")->group(function (){
        Route::get('/index', [ReceptionistController::class, 'index'])->name('receptionist.index');
        Route::get('/create', [ReceptionistController::class, 'create'])->name('receptionist.create');
        Route::post('/', [ReceptionistController::class, 'store'])->name('receptionist.store');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

