<?php

use Illuminate\Support\Facades\Route;


Route::get('/equipo', function () {
    return view('equipo.index');
});


Route::get('/suplementos', function () {
    return view('suplementos.index');
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
