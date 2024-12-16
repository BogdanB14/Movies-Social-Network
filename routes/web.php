<?php

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

Route::get('/', function () {   //Bez rute ce biti stranica za registarciju
    //return view('registration');
    return 'Please register';
});

Route::get('/home', function () {
    //return view('home');
    return 'Welcome to home page';
});

Route::get('/login', function () {
    //return view('login');
    return 'Hello, login first';
});

Route::get('/dashboard', function () {
    //return view('dash');
    return 'Here is your dashboard admin';
});

Route::get('/profile', function () {
    //return view('profile');
    return 'Welcome to your profile';
});
