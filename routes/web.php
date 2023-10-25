<?php

use App\Http\Controllers\AlbergueController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\HistorialPatologiasController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\PatologiaController;
use App\Http\Controllers\VacunaController;
use App\Models\Historialvacuna;
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
Route::get('/crearExpediente/{id}', 'App\Http\Controllers\AnimalControlador@expediente');
Route::post('animal/{id}/historialVacuna', 'App\Http\Controllers\AnimalControlador@historialstore');

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

Route::resource('/albergue', 'App\Http\Controllers\AlbergueController');
Route::put('albergue/update/{id}', [AlbergueController::class, 'update'])->name('albergue.update');
Route::get('/destroyAlbergue/{id}', [AlbergueController::class, 'destroy'])->name('albergue.destroy');
Route::get('/albergue/alta/{id}', [AlbergueController::class, 'alta'])->name('albergue.alta');

Route::resource('/especie', 'App\Http\Controllers\EspecieController');
Route::put('especie/update/{id}', [EspecieController::class, 'update'])->name('especie.update');
Route::get('/especie/destroy/{id}', 'App\Http\Controllers\EspecieController@destroy');

Route::resource('/vacuna', 'App\Http\Controllers\VacunaController');
Route::put('vacuna/update/{id}', [VacunaController::class, 'update'])->name('vacuna.update');
Route::get('/vacuna/destroy/{id}', 'App\Http\Controllers\VacunaController@destroy');

Route::resource('/patologia', 'App\Http\Controllers\PatologiaController');
Route::put('patologia/update/{id}', [PatologiaController::class, 'update'])->name('patologia.update');
Route::get('/destroyPatologia/{id}', 'App\Http\Controllers\PatologiaController@destroy');

Route::resource('/historialVacunas', 'App\Http\Controllers\HistorialVacunasController');
Route::post('/historialVacunas/store', 'App\Http\Controllers\HistorialVacunasController@store')->name('historial.store');
Route::get('/cargarListaDatos/{id}', 'App\Http\Controllers\HistorialVacunasController@cargarListaDatos');
Route::get('/cargarHistoriales/{id}', 'App\Http\Controllers\HistorialVacunasController@cargarHistoriales');
Route::delete('/destroyHistorialVacunas/{id}', 'App\Http\Controllers\HistorialVacunasController@destroy');
Route::get('/obtener-vacunas', 'App\Http\Controllers\HistorialVacunasController@ObtenerVacunas');
Route::post('/historialVacunas/actualizacionVacunas', 'App\Http\Controllers\HistorialVacunasController@actualizacionHistorialVacunas');
Route::get('/getTablaVacunas/{idExpediente}/{idVacuna}', 'App\Http\Controllers\HistorialVacunasController@tablaMostrarVacunas');

Route::resource('expediente', 'App\Http\Controllers\ExpedienteController');
Route::get('/getExpedientes', 'App\Http\Controllers\ExpedienteController@getExpedientes');
Route::get('/crearExpediente/{id}', 'App\Http\Controllers\ExpedienteController@crearExpediente');
Route::put('/expediente/update/{id}', [ExpedienteController::class, 'update']);
Route::get('/expedientedestroy/{id}', 'App\Http\Controllers\ExpedienteController@destroy');
Route::get('/expedienteAlta/{id}', 'App\Http\Controllers\ExpedienteController@alta');

Route::resource('historialPatologias', 'App\Http\Controllers\HistorialPatologiasController');
Route::post('/historialPatologias/store', [HistorialPatologiasController::class, 'store'])->name('historialP.store');
Route::get('/obtener-patologias', 'App\Http\Controllers\HistorialPatologiasController@ObtenerPatologias');
Route::get('/obtener-registros-guardados/{id}', 'App\Http\Controllers\HistorialPatologiasController@obtenerPatologiasGuardadas');
Route::delete('/historialPatologiaEliminar/{id}', 'App\Http\Controllers\HistorialPatologiasController@eliminarPatologia');
Route::get('/cargarHistorialesPatologia/{id}', 'App\Http\Controllers\HistorialPatologiasController@cargarHistorialesPatologia');
Route::post('/historialPatologias/actualizacion', 'App\Http\Controllers\HistorialPatologiasController@actualizacionHistorial');
Route::get('/getTablaPatologia/{idExpediente}/{idPatologia}', 'App\Http\Controllers\HistorialPatologiasController@tablaMostrar');

Route::get('/albergar/{idExpediente}/{idAlvergue}', 'App\Http\Controllers\AlbergueController@albergar');
Route::get('/desalbergar/{idExpediente}/{idAlvergue}', 'App\Http\Controllers\AlbergueController@desalbergar');
Route::get('/albergarDeExpediente/{idAlvergue}/{idExpediente}', 'App\Http\Controllers\AnimalControlador@albergarDeExpediente');

Route::resource('/adopcion', 'App\Http\Controllers\AdopcionController');
Route::get('/getAdopciones', 'App\Http\Controllers\AdopcionController@getAdopciones');
Route::get('/getExpedientesSinAdopcion', 'App\Http\Controllers\AdopcionController@getExpedientesSinAdopcion');
Route::get('/get-exp-ad-elegido/{idAdoptante}/{idExpediente}', 'App\Http\Controllers\AdopcionController@getExp_AdDElegido');