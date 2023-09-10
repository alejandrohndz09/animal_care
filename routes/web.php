<?php


use App\Http\Controllers\MiembroController;
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

Route::resource('animal','App\Http\Controllers\AnimalControlador');
Route::get('/obtener-razas/{especie}', 'App\Http\Controllers\AnimalControlador@obtenerRazas');
Route::post('/store', [AnimalControlador::class, 'store'])->name('animal.store');

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
Route::get('/miembro', [MiembroController::class, 'index'])->name('miembros.index');
Route::post('/store', [MiembroController::class, 'store'])->name('miembros.store');

Route::get('/edit/{id}', [MiembroController::class, 'edit'])->name('miembros.edit');
Route::put('/update/{id}', [MiembroController::class, 'update'])->name('miembros.update');

Route::get('/destroy/{id}', [MiembroController::class,'destroy'])->name('miembros.destroy');

Route::get('/destroyTelefono/{id}', [MiembroController::class,'destroyTelefono'])->name('miembros.destroyTelefono');


