<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[MainController::class,'index'])->name('main');
Route::match(['get','post'],'about',[PostController::class,'about'])->name('about');
Route::match(['get','post'],'contact',[MainController::class,'contact'])->name('contact');
Route::get('/login',[LoginController::class,'login'])->name('login');
Route::get('register',[LoginController::class,'register'])->name('register');
Route::post('register_store',[LoginController::class,'register_store'])->name('register_store');
Route::post('authenticate',[LoginController::class,'authenticate'])->name('authenticate')->middleware('guest');
Route::match(['get','post'],'home',[AdminController::class,'home'])->name('home')->middleware('auth');
Route::post('dashbord',[AdminController::class,'dashbord'])->name('dashbord')->middleware('auth');
Route::get('logout',[LoginController::class,'logout'])->name('logout');
Route::get('newslist',[AdminController::class,'newslist'])->name('newslist')->middleware('auth');
Route::get('create',[PostController::class,'create'])->name('create')->middleware('auth');
Route::post('store',[PostController::class,'store'])->name('store')->middleware('auth');
Route::get('edit/{post}',[AdminController::class,'edit'])->name('edit')->middleware('auth');
Route::post('update/{post}',[PostController::class,'update'])->name('post.update')->middleware('auth');
Route::get('delete/{post}',[AdminController::class,'delete'])->name('delete')->middleware('auth');

