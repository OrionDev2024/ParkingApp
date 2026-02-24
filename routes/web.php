<?php

use App\Http\Controllers\ParkingSessionController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\VehiculoController;
use App\Models\ParkingSession;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('sede', SedeController::class);

Route::resource('vehiculo', VehiculoController::class);


Route::get('parkingSession/editar',
[ParkingSessionController::class, 'editar']
)->name('parkingSession.editar');
Route::post('parkingSession/buscar', [ParkingSessionController::class, 'buscar'])->name('parkingSession.buscar');
Route::resource('parkingSession', ParkingSessionController::class);
