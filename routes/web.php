<?php

use App\Http\Controllers\AlbergueController;
use App\Http\Controllers\MiembroController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('dashboard.dashboard');
});

Route::resource('animal', 'App\Http\Controllers\AnimalControlador');
Route::put('/animal/update/{id}', 'App\Http\Controllers\AnimalControlador@update');

Route::get('/obtener-razas/{especie}', 'App\Http\Controllers\AnimalControlador@obtenerRazas');
// Route::post('/store', [AnimalControlador::class, 'store'])->name('animal.store');

Route::get('/form1', function () {
    return view('formularios.form1');
});

Route::get('/form2', function () {
    return view('formularios.form2');
});

Route::get('/form3', function () {
    return view('formularios.form3');
});



////////////////////////////MIS RUTAS PETER////////////////////////////////////////
Route::resource('/miembro', 'App\Http\Controllers\MiembroController');
Route::put('miembro/update/{id}', [MiembroController::class, 'update'])->name('miembros.update');
Route::get('miembro/telefonos/{id}', [MiembroController::class, 'ObtenerTelefonos'])->name('miembro.telefono');
Route::get('/destroy/{id}', [MiembroController::class, 'destroy'])->name('miembros.destroy');
Route::delete('/destroyTelefono/{id}', [MiembroController::class, 'destroyTelefono'])->name('miembros.destroyTelefono');
Route::post('/validar-telefono', 'App\Http\Controllers\AnimalControlador@validarTelefono');
/////////////////////////////////////////////////////////////////////////////////
Route::resource('/albergue', 'App\Http\Controllers\AlbergueController');
Route::put('albergue/update/{id}', [AlbergueController::class, 'update'])->name('albergue.update');
Route::delete('/destroyAlbergue/{id}', [AlbergueController::class, 'destroy'])->name('albergue.destroy');
