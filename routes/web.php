<?php

use App\Http\Controllers\PiscinaController;
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
    return redirect("/login");
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/piscinas', function () {
        return view('dashboard');
    })->name('piscinas');

    Route::get('/lecturas', function () {
        return view('dashboard');
    })->name('lecturas');

    Route::post("/lecturas", [PiscinaController::class, "lecturas"]);
    Route::post("/lecturas/cantidad", [PiscinaController::class, "cant_lecturas"]);
});

Route::get("/arduino/lectura/{uuid_piscina}/{lectura}", [PiscinaController::class, "lectura_prueba"])->name("lectura_arduino");
Route::get("/mensaje", [PiscinaController::class, "store"])->name("lectura");

// Route::post("/arduino/lectura/{uuid_piscina}/{lectura}", [PiscinaController::class, "lectura_prueba"])->name("lectura_arduino");

// Route::post("/arduino/lectura", [PiscinaController::class, "lectura_arduino"])->name("lectura_arduino");
// Route::post("/notificacion/enviada", [PiscinaController::class, "guardar_lectura"])->name("ph_lectura");
