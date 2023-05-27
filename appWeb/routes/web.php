<?php

use App\Http\Controllers\usuarioController;
use Illuminate\Support\Facades\Route;

// TODO,  Ruta por defecto
Route::get('/',  [usuarioController::class, 'lista'])->name('index');

// ? Si no encontró la ruta
Route::fallback(function () {
    return redirect('/');
});

// TODO, Usuarios
Route::prefix('usuarios')->group(function () {
    //* Ruta para enviar email
    Route::post('enviar/email', [usuarioController::class, 'enviarEmail'])->name('enviar.email');
});
