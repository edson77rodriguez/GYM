<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SuplementoController;
use App\Http\Controllers\EstadoMembresiaController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\MantenimientoController;




Route::get('/equipo', function () {
    return view('equipo.index');
});


Route::resource('suplementos', SuplementoController::class);
Route::resource('estado_membresias', EstadoMembresiaController::class);
Route::resource('socios', SocioController::class);
Route::resource('equipos', EquipoController::class);
Route::resource('planes', PlanController::class);
Route::resource('membresias', MembresiaController::class);
Route::resource('mantenimientos', MantenimientoController::class);





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);