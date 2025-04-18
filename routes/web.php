<?php

use App\Http\Controllers\GestionPedidosController;
use App\Http\Controllers\GestionProveedoresController;
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
use App\Http\Controllers\GestionMantenimientoController;

use App\Http\Controllers\GestionSociosController;





Route::get('/equipo', function () {
    return view('equipo.index');
});


Route::resource('suplementos', SuplementoController::class);
Route::delete('/suplementos/{suplemento}', [SuplementoController::class, 'destroy'])->name('suplementos.destroy');

Route::resource('estado_membresias', EstadoMembresiaController::class);
Route::delete('/estados/{id}', [EstadoMembresiaController::class, 'destroy'])->name('estados.destroy');

Route::resource('socios', SocioController::class);
Route::delete('/socios/{id}', [SocioController::class, 'destroy'])->name('socios.destroy');

Route::resource('equipos', EquipoController::class);
Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');

Route::resource('planes', PlanController::class);
Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');

Route::resource('membresias', MembresiaController::class);
Route::delete('/membresias/{membresia}', [MembresiaController::class, 'destroy'])->name('membresias.destroy');
Route::post('/membresias/storee', [MembresiaController::class, 'storee'])->name('membresias.storee');


Route::resource('mantenimientos', MantenimientoController::class);
Route::delete('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');

Route::resource('pedidos', PedidoController::class);
Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
Route::resource('empleados', EmpleadoController::class);
Route::delete('/empleados/{empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');

Route::resource('asistencias', AsistenciaController::class);
Route::delete('/asistencias/{asistencia}', [AsistenciaController::class, 'destroy'])->name('asistencias.destroy');

Route::resource('proveedores', ProveedorController::class);
Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

Route::resource('ventas', VentaController::class);
Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
Route::get('ventas/{venta}/detalles', [VentaController::class, 'agregarDetalles'])->name('ventas.detalle');
Route::post('ventas/{venta}/detalles', [VentaController::class, 'storeDetalles'])->name('ventas.detalles.store');
Route::delete('ventas/detalles/{detalle}', [VentaController::class, 'destroyDetalle'])->name('ventas.detalles.destroy');

Route::get('ventas/{id_venta}/detalles', [VentaController::class, 'detalles'])->name('ventas.detalles');
Route::post('ventas/{id_venta}/detalles', [VentaController::class, 'storeDetalles'])->name('ventas.storeDetalles');

Route::resource('marcas', MarcaController::class);
Route::delete('/marcas/{marca}', [MarcaController::class, 'destroy'])->name('marcas.destroy');

Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

Route::resource('categorias', CategoriaController::class);

Route::resource('GSM', GestionSociosController::class);
Route::resource('GPM', GestionProveedoresController::class);
Route::resource('GESP', GestionPedidosController::class)->names([
    'index' => 'GESP.index',
    'store' => 'GESP.store',
    'update' => 'GESP.update',
    'destroy' => 'GESP.destroy'
]);
Route::prefix('GESP')->group(function() {
    Route::get('/search', [GestionPedidosController::class, 'search'])->name('GESP.search');
    Route::get('/checkLowStock', [GestionPedidosController::class, 'checkLowStock'])->name('GESP.checkLowStock');
});
Route::post('GESP/{pedido}/recibir', [GestionPedidosController::class, 'recibir'])
    ->name('GESP.recibir');
    Route::resource('GPM', GestionProveedoresController::class);
Route::get('GPM/{proveedor}/edit', [GestionProveedoresController::class, 'edit'])->name('GPM.edit');

Route::prefix('gestion-mantenimiento')->group(function() {
    Route::get('/', [GestionMantenimientoController::class, 'index'])->name('gestion-mantenimiento.index');
    Route::post('/', [GestionMantenimientoController::class, 'store'])->name('gestion-mantenimiento.store');
    Route::get('/{mantenimiento}', [GestionMantenimientoController::class, 'show'])->name('gestion-mantenimiento.show');
    Route::put('/{mantenimiento}', [GestionMantenimientoController::class, 'update'])->name('gestion-mantenimiento.update');
    Route::delete('/{mantenimiento}', [GestionMantenimientoController::class, 'destroy'])->name('gestion-mantenimiento.destroy');
    Route::get('/calendar', [GestionMantenimientoController::class, 'calendar'])->name('gestion-mantenimiento.calendar');
});






Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
