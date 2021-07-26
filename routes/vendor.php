<?php

use App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\vendor\authcontroller;
use App\Http\Controllers\vendor\ProducteController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=>'auth:vendor']  , function(){
    Route::get('/', [ dashboard::class ,'dashboardvendor'])->name('vendor.dashboard');

    // route producte 
    Route::resource('/producte' , ProducteController::class);
    Route::get('/active/{id}', [ ProducteController::class ,'active'])->name('producte.active');



});

Route::group(['middleware'=>'guest:vendor' ,'namespace'=>'vendor']  , function(){

    Route::get('/login' , [authcontroller::class , 'getlogin'])->name('getlogin');
    Route::post('/authlogin' , [authcontroller::class , 'login'])->name('authlogin');
    Route::get('/getregister' , [authcontroller::class , 'getregister'])->name('getregister');
    Route::post('/register' , [authcontroller::class , 'register'])->name('authregister');
});

