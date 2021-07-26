<?php

use Illuminate\Support\Facades\Route;
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

// Route::get('/', function () {
//     return view('front.home');
// });


// Home comtroller

// login and register 
Route::get('/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::post('/at_login', [App\Http\Controllers\HomeController::class, 'at_login'])->name('at_login');

// register 
Route::get('/register', [App\Http\Controllers\HomeController::class, 'register'])->name('register');
Route::post('/save_register', [App\Http\Controllers\HomeController::class, 'save_register'])->name('save_register');
// logout 
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');



// الصفحة الرئيسية 
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// عرض التفاصيل 
Route::get('/show/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('show.producte');
// السلة
Route::post('/AddToCart/{id}', [App\Http\Controllers\HomeController::class, 'AddToCart'])->name('AddToCart')->middleware('auth');
Route::get('/showcart', [App\Http\Controllers\HomeController::class, 'showcart'])->name('showcart')->middleware('auth');
// Shop
Route::get('/shop', [App\Http\Controllers\HomeController::class, 'shop'])->name('shop');
//about us
Route::get('/about_us', [App\Http\Controllers\HomeController::class, 'about_us'])->name('about_us');

// contact 
Route::get('/contact_us', [App\Http\Controllers\HomeController::class, 'contact_us'])->name('contact_us');
Route::post('/contact_save', [App\Http\Controllers\HomeController::class, 'contact_save'])->name('contact_save');

// التعديل على عدد المنتجات 
Route::get('/mor/{id}', [App\Http\Controllers\HomeController::class, 'mor'])->name('mor');
Route::get('/les/{id}', [App\Http\Controllers\HomeController::class, 'les'])->name('les');




