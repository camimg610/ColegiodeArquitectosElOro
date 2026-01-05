<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\RegistroDeUsuarioController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermisosController;
use Illuminate\Support\Facades\Auth;

// Ruta raíz - redirigir al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Rutas protegidas con middleware de autenticación
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');

    // --- Ruta para el reporte de usuarios (declarada ANTES del resource) ---
    Route::get('/usuarios/reporte', [RegistroDeUsuarioController::class, 'reporte'])
        ->name('usuarios.reporte');

    // Usuarios
    Route::resource('usuarios', RegistroDeUsuarioController::class)
        ->except(['show']);

    // Inscripciones
    // Reporte de inscripciones (debe ir antes del resource)
    Route::get('/inscripciones/reporte', [InscripcionesController::class, 'reporte'])->name('inscripciones.reporte');
    Route::resource('inscripciones', InscripcionesController::class)
        ->except(['show']);

    // Eventos
    Route::resource('eventos', EventosController::class)
        ->except(['show']);

    // Alquileres
    // Reporte de alquiler (debe ir antes del resource)
    Route::get('/alquiler/reporte', [AlquilerController::class, 'reporte'])->name('alquiler.reporte');
    Route::resource('alquiler', AlquilerController::class)
        ->except(['show']);

    // Reporte de roles (debe ir antes del resource)
    Route::get('/roles/reporte', [RolesController::class, 'reporte'])->name('roles.reporte');
    Route::resource('roles', RolesController::class)
        ->except(['show']);
    // Reporte de permisos (debe ir antes del resource)
    Route::get('/permisos/reporte', [PermisosController::class, 'reporte'])->name('permisos.reporte');
    Route::resource('permisos', PermisosController::class)
        ->except(['show']);

    // Reportes
    Route::get('/reportes/usuarios', [RegistroDeUsuarioController::class, 'reporte'])->name('reportes.usuarios');
    Route::get('/reportes/inscripciones', [InscripcionesController::class, 'reporte'])->name('reportes.inscripciones');
    Route::get('/reportes/eventos', [EventosController::class, 'reporte'])->name('reportes.eventos');
    Route::get('/reportes/alquileres', [AlquilerController::class, 'reporte'])->name('reportes.alquileres');
});

// Ruta de prueba para verificar que el servidor funciona
Route::get('/test-server', function() {
    return 'Servidor funcionando correctamente - ' . now();
});

// Ruta de prueba para verificar autenticación
Route::get('/test-auth', function() {
    $user = Auth::user();
    if ($user) {
        return 'Usuario autenticado: ' . $user->Nombre . ' ' . $user->Apellido .
               '<br>ID: ' . $user->Cedula .
               '<br>Usuario: ' . $user->Usuario;
    }
    return 'No autenticado';
});
