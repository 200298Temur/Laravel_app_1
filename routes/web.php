<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LangController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PageController::class,'main'])->name('main');

Route::get('/about',[PageController::class,'about'])->name('About');      
Route::get('/service',[PageController::class,'service'])->name('Service');      
Route::get('/projects',[PageController::class,'projects'])->name('Projects');     
Route::get('/contact',[PageController::class,'contact'])->name('contact');     

Route::get('login',[AuthController::class,'login'])->name('login');

Route::post('authenticate',[AuthController::class,'authenticate'])->name('authenticate');
Route::post('logout',[AuthController::class,'logout'])->name('logout');
Route::get('register',[AuthController::class,'register'])->name('register');
Route::post('register',[AuthController::class,'register_store'])->name('register.store');

Route::middleware(['auth'])->group(function () {
    Route::get('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notification.read');
});

Route::get('lang/{locale}',[LangController::class,'change_locale'])->name('lang');

Route::resources([
    'posts'=> PostController::class,
    'comments'=>CommentController::class,
    'users'=>UserController::class,    
    'notification'=>NotificationController::class,
]);