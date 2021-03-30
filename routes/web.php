<?php

use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ManagerController;
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

Route::prefix("manager")->group(function (){
    Route::get('/index', [ManagerController::class, 'index'])->name('manager.index');
    Route::get('/create', [ManagerController::class, 'create'])->name('manager.create');
    Route::post('/', [ManagerController::class, 'store'])->name('manager.store');
});

Route::group(['middleware' => 'auth'],function () {
    Route::prefix("receptionist")->group(function (){
        Route::get('/index', [ReceptionistController::class, 'index'])->name('receptionist.index');
        Route::get('/create', [ReceptionistController::class, 'create'])->name('receptionist.create');
        Route::post('/', [ReceptionistController::class, 'store'])->name('receptionist.store');
    });
});

Route::prefix("client")->group(function (){
    Route::get('/index', [ClientController::class, 'index'])->name('client.index');
    
    
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

