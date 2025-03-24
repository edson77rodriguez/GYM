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
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;






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
Route::delete('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
Route::resource('pedidos', PedidoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('asistencias', AsistenciaController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('ventas', VentaController::class);
Route::get('ventas/{id_venta}/detalles', [VentaController::class, 'detalles'])->name('ventas.detalles');
Route::post('ventas/{id_venta}/detalles', [VentaController::class, 'storeDetalles'])->name('ventas.storeDetalles');
Route::resource('marcas', MarcaController::class);
Route::resource('categorias', CategoriaController::class);








Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);