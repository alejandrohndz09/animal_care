<?php

use App\Http\Controllers\AlbergueController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\PatologiaController;
use App\Http\Controllers\VacuanaController;
use App\Http\Controllers\VacunaController;
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
    return view('dashboard.dashboard');
});

Route::resource('animal', 'App\Http\Controllers\AnimalControlador');
Route::put('/animal/update/{id}', 'App\Http\Controllers\AnimalControlador@update');
Route::get('/animal/destroy/{id}', 'App\Http\Controllers\AnimalControlador@destroy');
Route::get('/obtener-razas/{especie}', 'App\Http\Controllers\AnimalControlador@obtenerRazas');

Route::resource('raza', 'App\Http\Controllers\RazaController');
Route::put('/raza/update/{id}', 'App\Http\Controllers\RazaController@update');
Route::get('/raza/destroy/{id}', 'App\Http\Controllers\RazaController@destroy');


Route::resource('miembro1', 'App\Http\Controllers\MiembroController1');
Route::put('/miembro1/update/{id}', 'App\Http\Controllers\MiembroController1@update');

Route::resource('/miembro', 'App\Http\Controllers\MiembroController');
Route::put('miembro/update/{id}', [MiembroController::class, 'update'])->name('miembros.update');
Route::get('miembro/Alta/{id}', [MiembroController::class, 'alta'])->name('miembros.alta');
Route::get('miembro/telefonos/{id}', [MiembroController::class, 'ObtenerTelefonos'])->name('miembro.telefono');
Route::get('/destroy/{id}', [MiembroController::class, 'destroy'])->name('miembros.destroy');
Route::delete('/destroyTelefono/{id}', [MiembroController::class, 'destroyTelefono'])->name('miembros.destroyTelefono');
Route::post('/validar-telefono', 'App\Http\Controllers\AnimalControlador@validarTelefono');
/////////////////////////////////////////////////////////////////////////////////
Route::resource('/albergue', 'App\Http\Controllers\AlbergueController');
Route::put('albergue/update/{id}', [AlbergueController::class, 'update'])->name('albergue.update');
Route::delete('/destroyAlbergue/{id}', [AlbergueController::class, 'destroy'])->name('albergue.destroy');


Route::resource('/especie', 'App\Http\Controllers\EspecieController');
Route::put('especie/update/{id}', [EspecieController::class, 'update'])->name('especie.update');
Route::get('/especie/destroy/{id}', 'App\Http\Controllers\EspecieController@destroy');



Route::resource('/vacuna', 'App\Http\Controllers\VacunaController');
Route::put('vacuna/update/{id}', [VacunaController::class, 'update'])->name('vacuna.update');
Route::get('/vacuna/destroy/{id}', 'App\Http\Controllers\VacunaController@destroy');


Route::resource('/patologia', 'App\Http\Controllers\PatologiaController');
Route::put('patologia/update/{id}', [PatologiaController::class, 'update'])->name('patologia.update');
Route::get('/destroyPatologia/{id}', 'App\Http\Controllers\PatologiaController@destroy');

