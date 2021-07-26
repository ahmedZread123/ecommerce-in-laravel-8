<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use  App\Http\Controllers\admin\dashboard;
use  App\Http\Controllers\admin\lanuagecontroller;
use App\Http\Controllers\admin\logincontroller;
use App\Http\Controllers\admin\main_categorie_controller;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\admin\VendorController;

// define('PAGINATION_COUNT' , 10);

Route::group(['middleware'=>'auth:admin'] , function(){

Route::get('/', [ dashboard::class ,'index'])->name('admin.dashboard');

// lanuages route 
Route::resource('lanuage' , lanuagecontroller::class);
//  categorie route
Route::resource('categorie' , main_categorie_controller::class);
Route::get('/categoreactive/{id}' ,[ main_categorie_controller::class , 'active'])->name('categorie.active');
Route::get('/allsubcategory/{id}' ,[ main_categorie_controller::class , 'allsubcategory'])->name('categorie.subcategory');

//  vendor  route 
Route::resource('vendor' , VendorController::class);
Route::get('/vendoractive/{id}' ,[VendorController::class , 'active'])->name('vendor.active');

// subcategory route 
Route::resource('subcategory' ,SubcategoryController::class );
Route::get('/subcategoryactive/{id}' ,[ SubcategoryController::class , 'active'])->name('subcategory.active');

Route::get('/logout' ,[ logincontroller::class ,'logout'])->name('admin.logout');
});


Route::group(['namespace'=>'Admin' , 'middleware'=>'guest:admin'] , function(){
    Route::get('/login' ,[ logincontroller::class ,'getlogin'])->name('admin.login');
    Route::post('/setlogin' ,[ logincontroller::class ,'setlogin'])->name('login.set');
    // Route::get('/logout' ,[ logincontroller::class ,'logout'])->name('admin.logout');

});



